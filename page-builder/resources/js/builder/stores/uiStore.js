import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useUIStore = defineStore('ui', () => {
  // State
  const leftPanelOpen = ref(true);
  const rightPanelOpen = ref(true);
  const responsiveMode = ref('desktop'); // 'desktop', 'tablet', 'mobile'
  const isDragging = ref(false);
  const draggedWidget = ref(null);

  // Actions
  function toggleLeftPanel() {
    leftPanelOpen.value = !leftPanelOpen.value;
  }

  function toggleRightPanel() {
    rightPanelOpen.value = !rightPanelOpen.value;
  }

  function setResponsiveMode(mode) {
    responsiveMode.value = mode;
  }

  function startDragging(widget) {
    isDragging.value = true;
    draggedWidget.value = widget;
  }

  function stopDragging() {
    isDragging.value = false;
    draggedWidget.value = null;
  }

  return {
    // State
    leftPanelOpen,
    rightPanelOpen,
    responsiveMode,
    isDragging,
    draggedWidget,

    // Actions
    toggleLeftPanel,
    toggleRightPanel,
    setResponsiveMode,
    startDragging,
    stopDragging,
  };
});
