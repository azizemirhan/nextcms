<template>
  <div v-if="uiStore.leftPanelOpen" class="left-panel w-64 bg-white border-r border-gray-200 overflow-y-auto">
    <div class="p-4">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Widgets</h2>
        <button @click="uiStore.toggleLeftPanel()" class="p-1 hover:bg-gray-100 rounded">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" />
          </svg>
        </button>
      </div>

      <!-- Widget Categories -->
      <div class="space-y-1">
        <button
          v-for="category in categories"
          :key="category.id"
          @click="activeCategory = category.id"
          :class="['w-full text-left px-3 py-2 rounded text-sm font-medium transition-colors', activeCategory === category.id ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50']"
        >
          {{ category.name }}
        </button>
      </div>

      <div class="mt-4 space-y-2">
        <!-- Widget List -->
        <div
          v-for="widget in filteredWidgets"
          :key="widget.type"
          :draggable="true"
          @dragstart="handleDragStart($event, widget)"
          @dragend="handleDragEnd"
          class="widget-item p-3 bg-gray-50 border border-gray-200 rounded-lg cursor-move hover:bg-gray-100 hover:border-indigo-400 transition-all"
        >
          <div class="flex items-center gap-3">
            <div class="text-indigo-600" v-html="widget.icon"></div>
            <div>
              <div class="text-sm font-medium text-gray-900">{{ widget.label }}</div>
              <div class="text-xs text-gray-500">{{ widget.description }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Toggle button when closed -->
  <button
    v-else
    @click="uiStore.toggleLeftPanel()"
    class="left-panel-toggle fixed left-0 top-1/2 -translate-y-1/2 bg-white border border-l-0 border-gray-200 rounded-r-lg p-2 hover:bg-gray-50 z-10"
  >
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path d="M9 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
    </svg>
  </button>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useUIStore } from '../../stores/uiStore';

const uiStore = useUIStore();
const activeCategory = ref('basic');

const categories = [
  { id: 'basic', name: 'Basic' },
  { id: 'layout', name: 'Layout' },
  { id: 'content', name: 'Content' },
];

const widgets = [
  // Layout
  {
    type: 'container',
    label: 'Container',
    description: 'Flexbox/Grid container',
    category: 'layout',
    icon: '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" stroke-width="2"/><path d="M3 9h18M9 9v12" stroke-width="2"/></svg>',
    defaultSettings: {
      display: 'flex',
      flexDirection: 'column',
      gap: '20px',
      padding: { top: '40px', right: '20px', bottom: '40px', left: '20px' },
    },
  },

  // Basic Widgets
  {
    type: 'heading',
    label: 'Heading',
    description: 'H1-H6 headings',
    category: 'basic',
    icon: '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h10" stroke-width="2" stroke-linecap="round"/></svg>',
    defaultContent: 'Your Heading Here',
    defaultSettings: {
      tag: 'h2',
      fontSize: '32px',
      fontWeight: '700',
      color: '#1f2937',
    },
  },
  {
    type: 'text',
    label: 'Text',
    description: 'Rich text editor',
    category: 'basic',
    icon: '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M4 14h10M4 18h6" stroke-width="2" stroke-linecap="round"/></svg>',
    defaultContent: '<p>Your text content here...</p>',
    defaultSettings: {
      fontSize: '16px',
      lineHeight: '1.6',
      color: '#4b5563',
    },
  },
  {
    type: 'button',
    label: 'Button',
    description: 'Call-to-action button',
    category: 'basic',
    icon: '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="8" width="18" height="8" rx="2" stroke-width="2"/></svg>',
    defaultContent: 'Click Me',
    defaultSettings: {
      backgroundColor: '#667eea',
      color: '#ffffff',
      padding: { top: '12px', right: '24px', bottom: '12px', left: '24px' },
      borderRadius: '8px',
      fontSize: '16px',
      fontWeight: '600',
      textAlign: 'center',
      link: '#',
    },
  },
  {
    type: 'image',
    label: 'Image',
    description: 'Image display',
    category: 'content',
    icon: '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" stroke-width="2"/><circle cx="8.5" cy="8.5" r="1.5" stroke-width="2"/><path d="M21 15l-5-5L5 21" stroke-width="2" stroke-linecap="round"/></svg>',
    defaultSettings: {
      src: 'https://via.placeholder.com/800x600',
      alt: 'Image',
      width: '100%',
    },
  },
  {
    type: 'divider',
    label: 'Divider',
    description: 'Horizontal line',
    category: 'basic',
    icon: '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 12h16" stroke-width="2" stroke-linecap="round"/></svg>',
    defaultSettings: {
      borderColor: '#e5e7eb',
      borderWidth: '1px',
      marginTop: '20px',
      marginBottom: '20px',
    },
  },
  {
    type: 'spacer',
    label: 'Spacer',
    description: 'Vertical space',
    category: 'basic',
    icon: '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 12h16" stroke-width="2" stroke-linecap="round" stroke-dasharray="2 2"/></svg>',
    defaultSettings: {
      height: '40px',
    },
  },
];

const filteredWidgets = computed(() => {
  return widgets.filter(w => w.category === activeCategory.value);
});

function handleDragStart(event, widget) {
  uiStore.startDragging(widget);
  event.dataTransfer.effectAllowed = 'copy';
  event.dataTransfer.setData('text/plain', JSON.stringify(widget));
}

function handleDragEnd() {
  uiStore.stopDragging();
}
</script>

<style scoped>
.widget-item {
  transition: all 0.2s ease;
}

.widget-item:active {
  opacity: 0.7;
  transform: scale(0.98);
}
</style>
