<template>
  <div v-if="uiStore.rightPanelOpen" class="right-panel w-80 bg-white border-l border-gray-200 overflow-y-auto">
    <div class="p-4">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-sm font-semibold text-gray-900 uppercase tracking-wide">Settings</h2>
        <button @click="uiStore.toggleRightPanel()" class="p-1 hover:bg-gray-100 rounded">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" />
          </svg>
        </button>
      </div>

      <!-- Selected Element Settings -->
      <div v-if="pageStore.selectedElement" class="space-y-4">
        <div>
          <div class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">Element Type</div>
          <div class="text-sm font-medium text-gray-900">{{ pageStore.selectedElement.type }}</div>
        </div>

        <!-- Content Editor (for text-based widgets) -->
        <div v-if="hasContent">
          <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
          <textarea
            v-model="pageStore.selectedElement.content"
            @input="handleContentChange"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
            rows="4"
          ></textarea>
        </div>

        <!-- Settings -->
        <div class="space-y-3">
          <div class="text-xs font-medium text-gray-500 uppercase tracking-wide">Styling</div>

          <!-- Font Size -->
          <div v-if="pageStore.selectedElement.settings?.fontSize !== undefined">
            <label class="block text-sm font-medium text-gray-700 mb-1">Font Size</label>
            <input
              v-model="pageStore.selectedElement.settings.fontSize"
              @input="handleSettingChange"
              type="text"
              placeholder="16px"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
            />
          </div>

          <!-- Font Weight -->
          <div v-if="pageStore.selectedElement.settings?.fontWeight !== undefined">
            <label class="block text-sm font-medium text-gray-700 mb-1">Font Weight</label>
            <select
              v-model="pageStore.selectedElement.settings.fontWeight"
              @change="handleSettingChange"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
            >
              <option value="400">Regular</option>
              <option value="500">Medium</option>
              <option value="600">Semibold</option>
              <option value="700">Bold</option>
            </select>
          </div>

          <!-- Color -->
          <div v-if="pageStore.selectedElement.settings?.color !== undefined">
            <label class="block text-sm font-medium text-gray-700 mb-1">Text Color</label>
            <input
              v-model="pageStore.selectedElement.settings.color"
              @input="handleSettingChange"
              type="color"
              class="w-full h-10 border border-gray-300 rounded-lg cursor-pointer"
            />
          </div>

          <!-- Background Color -->
          <div v-if="pageStore.selectedElement.settings?.backgroundColor !== undefined">
            <label class="block text-sm font-medium text-gray-700 mb-1">Background Color</label>
            <input
              v-model="pageStore.selectedElement.settings.backgroundColor"
              @input="handleSettingChange"
              type="color"
              class="w-full h-10 border border-gray-300 rounded-lg cursor-pointer"
            />
          </div>

          <!-- Text Align -->
          <div v-if="pageStore.selectedElement.settings?.textAlign !== undefined">
            <label class="block text-sm font-medium text-gray-700 mb-1">Text Align</label>
            <div class="flex gap-2">
              <button
                v-for="align in ['left', 'center', 'right']"
                :key="align"
                @click="setTextAlign(align)"
                :class="['flex-1 py-2 border rounded-lg text-sm font-medium transition-colors', pageStore.selectedElement.settings.textAlign === align ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50']"
              >
                {{ align }}
              </button>
            </div>
          </div>
        </div>

        <!-- Delete Button -->
        <button
          @click="deleteElement"
          class="w-full mt-6 px-4 py-2 bg-red-50 text-red-700 border border-red-200 rounded-lg hover:bg-red-100 transition-colors text-sm font-medium"
        >
          Delete Element
        </button>
      </div>

      <!-- No Selection -->
      <div v-else class="text-center py-12">
        <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <p class="mt-4 text-sm text-gray-500">Select an element to edit its settings</p>
      </div>
    </div>
  </div>

  <!-- Toggle button when closed -->
  <button
    v-else
    @click="uiStore.toggleRightPanel()"
    class="right-panel-toggle fixed right-0 top-1/2 -translate-y-1/2 bg-white border border-r-0 border-gray-200 rounded-l-lg p-2 hover:bg-gray-50 z-10"
  >
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path d="M15 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
    </svg>
  </button>
</template>

<script setup>
import { computed } from 'vue';
import { usePageStore } from '../../stores/pageStore';
import { useUIStore } from '../../stores/uiStore';

const pageStore = usePageStore();
const uiStore = useUIStore();

const hasContent = computed(() => {
  const type = pageStore.selectedElement?.type;
  return ['heading', 'text', 'button'].includes(type);
});

function handleContentChange() {
  // Trigger save to history
  pageStore.updateElement(pageStore.selectedElementId, {
    content: pageStore.selectedElement.content,
  });
}

function handleSettingChange() {
  // Trigger save to history
  pageStore.updateElement(pageStore.selectedElementId, {
    settings: pageStore.selectedElement.settings,
  });
}

function setTextAlign(align) {
  pageStore.selectedElement.settings.textAlign = align;
  handleSettingChange();
}

function deleteElement() {
  if (confirm('Are you sure you want to delete this element?')) {
    pageStore.deleteElement(pageStore.selectedElementId);
  }
}
</script>
