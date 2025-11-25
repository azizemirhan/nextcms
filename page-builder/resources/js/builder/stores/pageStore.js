import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import { v4 as uuidv4 } from 'uuid';
import api from '../utils/api';

export const usePageStore = defineStore('page', () => {
  // State
  const pageId = ref(null);
  const pageTitle = ref('Untitled Page');
  const pageSlug = ref('');
  const elements = ref([]); // Array of sections/containers/widgets
  const selectedElementId = ref(null);
  const history = ref([]);
  const historyIndex = ref(-1);
  const isSaving = ref(false);
  const lastSaved = ref(null);

  // Computed
  const selectedElement = computed(() => {
    if (!selectedElementId.value) return null;
    return findElementById(elements.value, selectedElementId.value);
  });

  const canUndo = computed(() => historyIndex.value > 0);
  const canRedo = computed(() => historyIndex.value < history.value.length - 1);

  // Actions
  function initializeDefaultLayout() {
    elements.value = [
      {
        id: uuidv4(),
        type: 'container',
        settings: {
          display: 'flex',
          flexDirection: 'column',
          gap: '20px',
          padding: { top: '80px', right: '20px', bottom: '80px', left: '20px' },
          backgroundColor: '#ffffff',
        },
        children: [
          {
            id: uuidv4(),
            type: 'heading',
            content: 'Welcome to Page Builder',
            settings: {
              tag: 'h1',
              fontSize: '48px',
              fontWeight: '700',
              textAlign: 'center',
              color: '#1f2937',
              marginBottom: '20px',
            },
          },
          {
            id: uuidv4(),
            type: 'text',
            content: '<p>Start building your page by dragging widgets from the left panel.</p>',
            settings: {
              fontSize: '18px',
              textAlign: 'center',
              color: '#6b7280',
              lineHeight: '1.8',
            },
          },
          {
            id: uuidv4(),
            type: 'button',
            content: 'Get Started',
            settings: {
              backgroundColor: '#667eea',
              color: '#ffffff',
              padding: { top: '12px', right: '32px', bottom: '12px', left: '32px' },
              borderRadius: '8px',
              fontSize: '16px',
              fontWeight: '600',
              textAlign: 'center',
              link: '#',
            },
          },
        ],
      },
    ];

    saveToHistory();
  }

  async function loadPage(id) {
    try {
      const response = await api.get(`/builder/pages/${id}`);
      pageId.value = response.data.id;
      pageTitle.value = response.data.title;
      pageSlug.value = response.data.slug;
      elements.value = response.data.layout_data || [];

      saveToHistory();
    } catch (error) {
      console.error('Failed to load page:', error);
    }
  }

  async function savePage() {
    isSaving.value = true;

    try {
      const payload = {
        title: pageTitle.value,
        slug: pageSlug.value,
        layout_data: elements.value,
        status: 'draft',
      };

      if (pageId.value) {
        // Update existing page
        await api.put(`/builder/pages/${pageId.value}`, payload);
      } else {
        // Create new page
        const response = await api.post('/builder/pages', payload);
        pageId.value = response.data.id;
      }

      lastSaved.value = new Date();
    } catch (error) {
      console.error('Failed to save page:', error);
      alert('Failed to save page. Please try again.');
    } finally {
      isSaving.value = false;
    }
  }

  function addElement(element, parentId = null, index = null) {
    const newElement = {
      ...element,
      id: uuidv4(),
    };

    if (parentId) {
      // Add to specific parent
      const parent = findElementById(elements.value, parentId);
      if (parent) {
        if (!parent.children) parent.children = [];
        if (index !== null) {
          parent.children.splice(index, 0, newElement);
        } else {
          parent.children.push(newElement);
        }
      }
    } else {
      // Add to root
      if (index !== null) {
        elements.value.splice(index, 0, newElement);
      } else {
        elements.value.push(newElement);
      }
    }

    saveToHistory();
    return newElement.id;
  }

  function updateElement(elementId, updates) {
    const element = findElementById(elements.value, elementId);
    if (element) {
      Object.assign(element, updates);
      saveToHistory();
    }
  }

  function deleteElement(elementId) {
    elements.value = removeElementById(elements.value, elementId);
    if (selectedElementId.value === elementId) {
      selectedElementId.value = null;
    }
    saveToHistory();
  }

  function selectElement(elementId) {
    selectedElementId.value = elementId;
  }

  function duplicateElement(elementId) {
    const element = findElementById(elements.value, elementId);
    if (element) {
      const duplicate = JSON.parse(JSON.stringify(element));
      duplicate.id = uuidv4();

      // Find parent and insert after original
      const { parent, index } = findElementParent(elements.value, elementId);
      if (parent) {
        parent.children.splice(index + 1, 0, duplicate);
      } else {
        const index = elements.value.findIndex(el => el.id === elementId);
        elements.value.splice(index + 1, 0, duplicate);
      }

      saveToHistory();
      return duplicate.id;
    }
  }

  function undo() {
    if (canUndo.value) {
      historyIndex.value--;
      elements.value = JSON.parse(JSON.stringify(history.value[historyIndex.value]));
    }
  }

  function redo() {
    if (canRedo.value) {
      historyIndex.value++;
      elements.value = JSON.parse(JSON.stringify(history.value[historyIndex.value]));
    }
  }

  function saveToHistory() {
    // Remove future history if we're not at the end
    if (historyIndex.value < history.value.length - 1) {
      history.value = history.value.slice(0, historyIndex.value + 1);
    }

    // Add current state to history
    history.value.push(JSON.parse(JSON.stringify(elements.value)));
    historyIndex.value++;

    // Limit history to last 50 states
    if (history.value.length > 50) {
      history.value.shift();
      historyIndex.value--;
    }
  }

  // Helper functions
  function findElementById(elements, id) {
    for (const element of elements) {
      if (element.id === id) return element;
      if (element.children) {
        const found = findElementById(element.children, id);
        if (found) return found;
      }
    }
    return null;
  }

  function findElementParent(elements, id, parent = null) {
    for (let i = 0; i < elements.length; i++) {
      if (elements[i].id === id) {
        return { parent, index: i };
      }
      if (elements[i].children) {
        const result = findElementParent(elements[i].children, id, elements[i]);
        if (result.parent) return result;
      }
    }
    return { parent: null, index: -1 };
  }

  function removeElementById(elements, id) {
    return elements.filter(element => {
      if (element.id === id) return false;
      if (element.children) {
        element.children = removeElementById(element.children, id);
      }
      return true;
    });
  }

  return {
    // State
    pageId,
    pageTitle,
    pageSlug,
    elements,
    selectedElementId,
    isSaving,
    lastSaved,

    // Computed
    selectedElement,
    canUndo,
    canRedo,

    // Actions
    initializeDefaultLayout,
    loadPage,
    savePage,
    addElement,
    updateElement,
    deleteElement,
    selectElement,
    duplicateElement,
    undo,
    redo,
  };
});
