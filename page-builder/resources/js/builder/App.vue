<template>
  <div class="builder-app h-screen flex flex-col bg-gray-50">
    <!-- Top Bar -->
    <TopBar />

    <!-- Main Editor Area -->
    <div class="flex flex-1 overflow-hidden">
      <!-- Left Panel - Widgets -->
      <LeftPanel />

      <!-- Center Canvas - Preview -->
      <Canvas />

      <!-- Right Panel - Settings -->
      <RightPanel />
    </div>
  </div>
</template>

<script setup>
import TopBar from './components/Editor/TopBar.vue';
import LeftPanel from './components/Editor/LeftPanel.vue';
import Canvas from './components/Editor/Canvas.vue';
import RightPanel from './components/Editor/RightPanel.vue';
import { usePageStore } from './stores/pageStore';
import { onMounted } from 'vue';

const pageStore = usePageStore();

onMounted(() => {
  // Load page data from server (if editing existing page)
  const pageId = new URLSearchParams(window.location.search).get('page_id');
  if (pageId) {
    pageStore.loadPage(pageId);
  } else {
    // Initialize with default layout
    pageStore.initializeDefaultLayout();
  }
});
</script>

<style scoped>
.builder-app {
  font-family: Inter, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}
</style>
