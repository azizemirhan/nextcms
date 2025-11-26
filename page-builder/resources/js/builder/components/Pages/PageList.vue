<template>
  <div class="page-list-container min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">Pages</h1>
            <p class="mt-1 text-sm text-gray-500">Manage your pages</p>
          </div>
          <button
            @click="createNewPage"
            :disabled="isCreating"
            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50"
          >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path d="M12 4v16m8-8H4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            {{ isCreating ? 'Creating...' : 'New Page' }}
          </button>
        </div>
      </div>
    </div>

    <!-- Page List -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div v-if="isLoading" class="text-center py-12">
        <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
        <p class="mt-4 text-sm text-gray-500">Loading pages...</p>
      </div>

      <div v-else-if="pages.length === 0" class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No pages</h3>
        <p class="mt-1 text-sm text-gray-500">Get started by creating a new page.</p>
        <div class="mt-6">
          <button
            @click="createNewPage"
            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700"
          >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path d="M12 4v16m8-8H4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            New Page
          </button>
        </div>
      </div>

      <div v-else class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <div
          v-for="page in pages"
          :key="page.id"
          class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition-shadow cursor-pointer"
          @click="openPage(page.id)"
        >
          <div class="p-6">
            <div class="flex items-center justify-between mb-4">
              <span :class="['inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium', page.status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800']">
                {{ page.status }}
              </span>
              <button
                @click.stop="deletePage(page.id)"
                class="text-gray-400 hover:text-red-600 transition-colors"
                title="Delete page"
              >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </button>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ page.title }}</h3>
            <p class="text-sm text-gray-500">{{ page.slug }}</p>
            <div class="mt-4 text-xs text-gray-400">
              Updated {{ formatDate(page.updated_at) }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import api from '../../utils/api';

const emit = defineEmits(['open-page']);

const pages = ref([]);
const isLoading = ref(true);
const isCreating = ref(false);

onMounted(async () => {
  await loadPages();
});

async function loadPages() {
  try {
    isLoading.value = true;
    // Using the existing API - we'll need to add a list endpoint
    const response = await api.get('/builder/pages');
    pages.value = response.data;
  } catch (error) {
    console.error('Failed to load pages:', error);
    pages.value = [];
  } finally {
    isLoading.value = false;
  }
}

async function createNewPage() {
  try {
    isCreating.value = true;
    const response = await api.post('/builder/pages', {
      title: 'Untitled Page',
      status: 'draft',
      layout_data: [],
    });

    // Open the newly created page
    emit('open-page', response.data.id);
  } catch (error) {
    console.error('Failed to create page:', error);
    alert('Failed to create page. Please try again.');
  } finally {
    isCreating.value = false;
  }
}

function openPage(pageId) {
  emit('open-page', pageId);
}

async function deletePage(pageId) {
  if (!confirm('Are you sure you want to delete this page?')) {
    return;
  }

  try {
    await api.delete(`/builder/pages/${pageId}`);
    await loadPages();
  } catch (error) {
    console.error('Failed to delete page:', error);
    alert('Failed to delete page. Please try again.');
  }
}

function formatDate(dateString) {
  const date = new Date(dateString);
  const now = new Date();
  const diff = Math.floor((now - date) / 1000); // seconds

  if (diff < 60) return 'just now';
  if (diff < 3600) return `${Math.floor(diff / 60)}m ago`;
  if (diff < 86400) return `${Math.floor(diff / 3600)}h ago`;
  if (diff < 604800) return `${Math.floor(diff / 86400)}d ago`;
  return date.toLocaleDateString();
}
</script>
