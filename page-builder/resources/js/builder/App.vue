<template>
  <div class="builder-app h-screen flex flex-col bg-gray-50">
    <!-- Page List View -->
    <PageList v-if="currentView === 'list'" @open-page="openPageInEditor" />

    <!-- Editor View -->
    <template v-else-if="currentView === 'editor'">
      <!-- Top Bar -->
      <TopBar @back-to-list="backToList" />

      <!-- Main Editor Area -->
      <div class="flex flex-1 overflow-hidden">
        <!-- Left Panel - Widgets -->
        <LeftPanel />

        <!-- Center Canvas - Preview -->
        <Canvas />

        <!-- Right Panel - Settings -->
        <RightPanel />
      </div>
    </template>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import TopBar from './components/Editor/TopBar.vue';
import LeftPanel from './components/Editor/LeftPanel.vue';
import Canvas from './components/Editor/Canvas.vue';
import RightPanel from './components/Editor/RightPanel.vue';
import PageList from './components/Pages/PageList.vue';
import { usePageStore } from './stores/pageStore';

const pageStore = usePageStore();
const currentView = ref('list'); // 'list' or 'editor'

onMounted(() => {
  // Check if there's a page_id in the URL
  const pageId = new URLSearchParams(window.location.search).get('page_id');
  if (pageId) {
    openPageInEditor(parseInt(pageId));
  }
});

function openPageInEditor(pageId) {
  currentView.value = 'editor';
  pageStore.loadPage(pageId);

  // Update URL without reload
  window.history.pushState({}, '', `?page_id=${pageId}`);
}

function backToList() {
  currentView.value = 'list';

  // Update URL without reload
  window.history.pushState({}, '', window.location.pathname);
}
</script>

<style scoped>
.builder-app {
  font-family: Inter, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}
</style>
