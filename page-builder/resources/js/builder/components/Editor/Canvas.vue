<template>
  <div class="canvas flex-1 bg-gray-100 overflow-auto p-8">
    <div
      :class="['canvas-viewport mx-auto bg-white shadow-lg transition-all', canvasWidth]"
      :style="{ minHeight: '600px' }"
    >
      <!-- Render Elements -->
      <div
        v-for="(element, index) in pageStore.elements"
        :key="element.id"
        class="relative"
      >
        <ElementRenderer
          :element="element"
          :is-selected="pageStore.selectedElementId === element.id"
          @select="pageStore.selectElement(element.id)"
          @drop="handleDrop($event, null, index)"
        />
      </div>

      <!-- Drop Zone when empty -->
      <div
        v-if="pageStore.elements.length === 0"
        @dragover.prevent
        @drop="handleDrop($event, null, 0)"
        class="h-96 flex items-center justify-center border-2 border-dashed border-gray-300 rounded-lg m-4"
      >
        <div class="text-center">
          <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M7 16a4 4 4 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          <p class="mt-4 text-gray-500">Drop widgets here to start building</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { usePageStore } from '../../stores/pageStore';
import { useUIStore } from '../../stores/uiStore';
import ElementRenderer from './ElementRenderer.vue';

const pageStore = usePageStore();
const uiStore = useUIStore();

const canvasWidth = computed(() => {
  switch (uiStore.responsiveMode) {
    case 'mobile':
      return 'max-w-sm';
    case 'tablet':
      return 'max-w-3xl';
    default:
      return 'max-w-7xl';
  }
});

function handleDrop(event, parentId, index) {
  event.preventDefault();
  event.stopPropagation();

  try {
    const widgetData = JSON.parse(event.dataTransfer.getData('text/plain'));

    const newElement = {
      type: widgetData.type,
      content: widgetData.defaultContent || '',
      settings: widgetData.defaultSettings || {},
      children: widgetData.type === 'container' ? [] : undefined,
    };

    pageStore.addElement(newElement, parentId, index);
  } catch (error) {
    console.error('Failed to parse dropped widget:', error);
  }
}
</script>
