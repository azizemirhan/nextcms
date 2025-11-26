<template>
  <div
    :class="['element-wrapper', { 'selected': isSelected, 'is-container': isContainer }]"
    @click.stop="$emit('select')"
    @dragover.prevent="handleDragOver"
    @drop="handleDrop"
  >
    <!-- Selection Overlay -->
    <div v-if="isSelected" class="absolute inset-0 border-2 border-indigo-500 pointer-events-none z-10 rounded">
      <div class="absolute -top-6 left-0 bg-indigo-500 text-white text-xs px-2 py-1 rounded-t">
        {{ element.type }}
      </div>
    </div>

    <!-- Render based on type -->
    <component
      :is="componentMap[element.type] || 'div'"
      :element="element"
      :style="computedStyle"
      :class="element.settings?.className"
      :href="element.type === 'button' ? element.settings?.link : undefined"
      :src="element.type === 'image' ? element.settings?.src : undefined"
      :alt="element.type === 'image' ? element.settings?.alt : undefined"
    >
      <!-- Container children -->
      <template v-if="isContainer && element.children">
        <ElementRenderer
          v-for="child in element.children"
          :key="child.id"
          :element="child"
          :is-selected="pageStore.selectedElementId === child.id"
          @select="pageStore.selectElement(child.id)"
        />

        <!-- Drop zone for empty container -->
        <div
          v-if="element.children.length === 0"
          class="min-h-[100px] flex items-center justify-center border-2 border-dashed border-gray-300 rounded m-2"
        >
          <p class="text-sm text-gray-400">Drop widgets here</p>
        </div>
      </template>

      <!-- Render content for text-based widgets -->
      <template v-else-if="['heading', 'text'].includes(element.type)">
        <div v-html="element.content"></div>
      </template>

      <!-- Render button content (directly, no wrapper) -->
      <template v-else-if="element.type === 'button'">
        {{ element.content }}
      </template>
    </component>

    <!-- Hover Overlay -->
    <div v-if="!isSelected" class="element-hover-overlay"></div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { usePageStore } from '../../stores/pageStore';

const props = defineProps({
  element: {
    type: Object,
    required: true,
  },
  isSelected: {
    type: Boolean,
    default: false,
  },
});

defineEmits(['select', 'drop']);

const pageStore = usePageStore();

const isContainer = computed(() => props.element.type === 'container');

// Map element types to render components/tags
const componentMap = {
  container: 'div',
  heading: 'div',
  text: 'div',
  button: 'a',
  image: 'img',
  divider: 'hr',
  spacer: 'div',
};

const computedStyle = computed(() => {
  const settings = props.element.settings || {};
  const style = {};

  // Layout properties (for containers)
  if (settings.display) style.display = settings.display;
  if (settings.flexDirection) style.flexDirection = settings.flexDirection;
  if (settings.justifyContent) style.justifyContent = settings.justifyContent;
  if (settings.alignItems) style.alignItems = settings.alignItems;
  if (settings.gap) style.gap = settings.gap;

  // Dimensions
  if (settings.width) style.width = settings.width;
  if (settings.height) style.height = settings.height;
  if (settings.maxWidth) style.maxWidth = settings.maxWidth;
  if (settings.minHeight) style.minHeight = settings.minHeight;

  // Spacing
  if (settings.padding) {
    if (typeof settings.padding === 'object') {
      style.paddingTop = settings.padding.top || 0;
      style.paddingRight = settings.padding.right || 0;
      style.paddingBottom = settings.padding.bottom || 0;
      style.paddingLeft = settings.padding.left || 0;
    } else {
      style.padding = settings.padding;
    }
  }

  if (settings.margin) {
    if (typeof settings.margin === 'object') {
      style.marginTop = settings.margin.top || 0;
      style.marginRight = settings.margin.right || 0;
      style.marginBottom = settings.margin.bottom || 0;
      style.marginLeft = settings.margin.left || 0;
    } else {
      style.margin = settings.margin;
    }
  }

  // Typography
  if (settings.fontSize) style.fontSize = settings.fontSize;
  if (settings.fontWeight) style.fontWeight = settings.fontWeight;
  if (settings.lineHeight) style.lineHeight = settings.lineHeight;
  if (settings.textAlign) style.textAlign = settings.textAlign;
  if (settings.color) style.color = settings.color;

  // Background
  if (settings.backgroundColor) style.backgroundColor = settings.backgroundColor;

  // Border
  if (settings.borderRadius) style.borderRadius = settings.borderRadius;
  if (settings.borderWidth) style.borderWidth = settings.borderWidth;
  if (settings.borderColor) style.borderColor = settings.borderColor;
  if (settings.borderStyle) style.borderStyle = settings.borderStyle;

  // Button specific styles
  if (props.element.type === 'button') {
    style.display = 'inline-block';
    style.textDecoration = 'none';
    style.cursor = 'pointer';
  }

  return style;
});

function handleDragOver(event) {
  if (isContainer.value) {
    event.stopPropagation();
  }
}

function handleDrop(event) {
  if (isContainer.value) {
    event.stopPropagation();
    const widgetData = JSON.parse(event.dataTransfer.getData('text/plain'));

    const newElement = {
      type: widgetData.type,
      content: widgetData.defaultContent || '',
      settings: widgetData.defaultSettings || {},
      children: widgetData.type === 'container' ? [] : undefined,
    };

    pageStore.addElement(newElement, props.element.id);
  }
}
</script>

<style scoped>
.element-wrapper {
  position: relative;
  min-height: 20px;
}

.element-wrapper.selected {
  outline: none;
}

.element-wrapper:hover .element-hover-overlay {
  position: absolute;
  inset: 0;
  border: 1px dashed #a5b4fc;
  pointer-events: none;
  z-index: 5;
}

.element-wrapper.selected .element-hover-overlay {
  display: none;
}

.is-container {
  min-height: 60px;
}

/* Render content for different widget types */
.element-wrapper[data-type="heading"] {
  font-size: inherit;
}
</style>
