<template>
  <div class="top-bar bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-between">
    <!-- Left: Page Title -->
    <div class="flex items-center gap-4">
      <h1 class="text-lg font-semibold text-gray-900">{{ pageStore.pageTitle }}</h1>
      <span v-if="pageStore.isSaving" class="text-sm text-gray-500">Saving...</span>
      <span v-else-if="pageStore.lastSaved" class="text-sm text-gray-500">
        Saved {{ formatTime(pageStore.lastSaved) }}
      </span>
    </div>

    <!-- Center: Responsive Mode Switcher -->
    <div class="flex items-center gap-2 bg-gray-100 rounded-lg p-1">
      <button
        @click="uiStore.setResponsiveMode('desktop')"
        :class="['px-3 py-1.5 rounded text-sm font-medium transition-colors', uiStore.responsiveMode === 'desktop' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900']"
      >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <rect x="2" y="3" width="20" height="14" rx="2" stroke-width="2" />
          <path d="M8 21h8" stroke-width="2" stroke-linecap="round" />
          <path d="M12 17v4" stroke-width="2" stroke-linecap="round" />
        </svg>
      </button>
      <button
        @click="uiStore.setResponsiveMode('tablet')"
        :class="['px-3 py-1.5 rounded text-sm font-medium transition-colors', uiStore.responsiveMode === 'tablet' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900']"
      >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <rect x="5" y="2" width="14" height="20" rx="2" stroke-width="2" />
          <path d="M12 18h.01" stroke-width="2" stroke-linecap="round" />
        </svg>
      </button>
      <button
        @click="uiStore.setResponsiveMode('mobile')"
        :class="['px-3 py-1.5 rounded text-sm font-medium transition-colors', uiStore.responsiveMode === 'mobile' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900']"
      >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <rect x="7" y="2" width="10" height="20" rx="2" stroke-width="2" />
          <path d="M12 18h.01" stroke-width="2" stroke-linecap="round" />
        </svg>
      </button>
    </div>

    <!-- Right: Actions -->
    <div class="flex items-center gap-3">
      <button
        @click="pageStore.undo()"
        :disabled="!pageStore.canUndo"
        :class="['p-2 rounded hover:bg-gray-100 transition-colors', !pageStore.canUndo && 'opacity-50 cursor-not-allowed']"
        title="Undo (Ctrl+Z)"
      >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M9 14l-4-4 4-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          <path d="M5 10h11a4 4 4 0 1 1 0 8h-1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </button>

      <button
        @click="pageStore.redo()"
        :disabled="!pageStore.canRedo"
        :class="['p-2 rounded hover:bg-gray-100 transition-colors', !pageStore.canRedo && 'opacity-50 cursor-not-allowed']"
        title="Redo (Ctrl+Shift+Z)"
      >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M15 14l4-4-4-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          <path d="M19 10H8a4 4 4 0 0 0 0 8h1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </button>

      <div class="w-px h-6 bg-gray-300"></div>

      <button
        @click="showGlobalSettings = true"
        class="p-2 rounded hover:bg-gray-100 transition-colors"
        title="Global Settings"
      >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </button>

      <button
        @click="handlePreview"
        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
      >
        Preview
      </button>

      <button
        @click="pageStore.savePage()"
        :disabled="pageStore.isSaving"
        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors disabled:opacity-50"
      >
        {{ pageStore.isSaving ? 'Saving...' : 'Save' }}
      </button>
    </div>
  </div>

  <!-- Global Settings Modal -->
  <GlobalSettingsModal :is-open="showGlobalSettings" @close="showGlobalSettings = false" />
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { usePageStore } from '../../stores/pageStore';
import { useUIStore } from '../../stores/uiStore';
import GlobalSettingsModal from '../Shared/GlobalSettingsModal.vue';

const pageStore = usePageStore();
const uiStore = useUIStore();
const showGlobalSettings = ref(false);

function formatTime(date) {
  const now = new Date();
  const diff = Math.floor((now - date) / 1000); // seconds

  if (diff < 60) return 'just now';
  if (diff < 3600) return `${Math.floor(diff / 60)}m ago`;
  if (diff < 86400) return `${Math.floor(diff / 3600)}h ago`;
  return date.toLocaleDateString();
}

function handlePreview() {
  // Open preview in new window
  const previewUrl = `/builder/preview?page_id=${pageStore.pageId}`;
  window.open(previewUrl, '_blank');
}

// Keyboard shortcuts
function handleKeyboard(e) {
  // Ctrl/Cmd + S: Save
  if ((e.ctrlKey || e.metaKey) && e.key === 's') {
    e.preventDefault();
    pageStore.savePage();
  }

  // Ctrl/Cmd + Z: Undo
  if ((e.ctrlKey || e.metaKey) && e.key === 'z' && !e.shiftKey) {
    e.preventDefault();
    pageStore.undo();
  }

  // Ctrl/Cmd + Shift + Z: Redo
  if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'z') {
    e.preventDefault();
    pageStore.redo();
  }
}

onMounted(() => {
  window.addEventListener('keydown', handleKeyboard);
});

onUnmounted(() => {
  window.removeEventListener('keydown', handleKeyboard);
});
</script>
