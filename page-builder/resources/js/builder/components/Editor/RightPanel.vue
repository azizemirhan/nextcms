<template>
  <div v-if="uiStore.rightPanelOpen" class="right-panel w-96 bg-white border-l border-gray-200 overflow-y-auto">
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
      <div v-if="pageStore.selectedElement" class="space-y-6">
        <!-- Element Type Badge -->
        <div class="flex items-center justify-between">
          <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 capitalize">
            {{ pageStore.selectedElement.type }}
          </span>
          <button
            @click="deleteElement"
            class="p-1.5 text-red-600 hover:bg-red-50 rounded transition-colors"
            title="Delete element"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>
        </div>

        <!-- Tabs -->
        <div class="border-b border-gray-200">
          <nav class="-mb-px flex space-x-4">
            <button
              v-for="tab in tabs"
              :key="tab.id"
              @click="activeTab = tab.id"
              :class="['py-2 px-1 border-b-2 font-medium text-sm transition-colors', activeTab === tab.id ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300']"
            >
              {{ tab.label }}
            </button>
          </nav>
        </div>

        <!-- Tab Content -->
        <div class="space-y-6">
          <!-- CONTENT TAB -->
          <template v-if="activeTab === 'content'">
            <!-- Content Editor (for text-based widgets) -->
            <div v-if="hasContent">
              <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
              <textarea
                v-model="pageStore.selectedElement.content"
                @input="handleContentChange"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                rows="6"
              ></textarea>
            </div>

            <!-- Image Source (for image widget) -->
            <div v-if="pageStore.selectedElement.type === 'image'">
              <label class="block text-sm font-medium text-gray-700 mb-2">Image URL</label>
              <input
                v-model="pageStore.selectedElement.settings.src"
                @input="handleSettingChange"
                type="text"
                placeholder="https://example.com/image.jpg"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
              />
            </div>

            <!-- Button Link -->
            <div v-if="pageStore.selectedElement.type === 'button'">
              <label class="block text-sm font-medium text-gray-700 mb-2">Link URL</label>
              <input
                v-model="pageStore.selectedElement.settings.link"
                @input="handleSettingChange"
                type="text"
                placeholder="https://example.com"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
              />
            </div>
          </template>

          <!-- LAYOUT TAB -->
          <template v-if="activeTab === 'layout'">
            <!-- Container Layout Controls -->
            <template v-if="isContainer">
              <FlexboxControls
                :settings="pageStore.selectedElement.settings"
                @update="handleSettingsUpdate"
              />
              <div class="border-t border-gray-200 pt-4"></div>
            </template>

            <!-- Sizing -->
            <div class="space-y-3">
              <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Dimensions</h3>

              <DimensionControl
                label="Width"
                v-model="localSettings.width"
                @update:model-value="updateLocalSetting('width', $event)"
                placeholder="auto"
              />

              <DimensionControl
                label="Max Width"
                v-model="localSettings.maxWidth"
                @update:model-value="updateLocalSetting('maxWidth', $event)"
                placeholder="none"
              />

              <DimensionControl
                label="Height"
                v-model="localSettings.height"
                @update:model-value="updateLocalSetting('height', $event)"
                placeholder="auto"
              />

              <DimensionControl
                label="Min Height"
                v-model="localSettings.minHeight"
                @update:model-value="updateLocalSetting('minHeight', $event)"
                placeholder="none"
              />
            </div>

            <div class="border-t border-gray-200 pt-4"></div>

            <!-- Spacing -->
            <SpacingControl
              label="Padding"
              v-model="localSettings.padding"
              @update:model-value="updateLocalSetting('padding', $event)"
            />

            <SpacingControl
              label="Margin"
              v-model="localSettings.margin"
              @update:model-value="updateLocalSetting('margin', $event)"
            />

            <div class="border-t border-gray-200 pt-4"></div>

            <!-- Position -->
            <PositionControl
              :settings="localSettings"
              @update="handleSettingsUpdate"
            />
          </template>

          <!-- STYLE TAB -->
          <template v-if="activeTab === 'style'">
            <!-- Typography (for text-based widgets) -->
            <template v-if="hasTypography">
              <div class="space-y-3">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Typography</h3>

                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Font Size</label>
                  <input
                    v-model="localSettings.fontSize"
                    @input="updateLocalSetting('fontSize', $event.target.value)"
                    type="text"
                    placeholder="16px"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
                  />
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Font Weight</label>
                  <select
                    v-model="localSettings.fontWeight"
                    @change="updateLocalSetting('fontWeight', $event.target.value)"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
                  >
                    <option value="300">Light</option>
                    <option value="400">Regular</option>
                    <option value="500">Medium</option>
                    <option value="600">Semibold</option>
                    <option value="700">Bold</option>
                    <option value="800">Extra Bold</option>
                  </select>
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Line Height</label>
                  <input
                    v-model="localSettings.lineHeight"
                    @input="updateLocalSetting('lineHeight', $event.target.value)"
                    type="text"
                    placeholder="1.5"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
                  />
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Text Align</label>
                  <div class="grid grid-cols-4 gap-2">
                    <button
                      v-for="align in ['left', 'center', 'right', 'justify']"
                      :key="align"
                      @click="updateLocalSetting('textAlign', align)"
                      :class="['py-2 border rounded-lg text-sm font-medium transition-colors capitalize', localSettings.textAlign === align ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50']"
                    >
                      {{ align.substring(0, 1).toUpperCase() }}
                    </button>
                  </div>
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Text Color</label>
                  <input
                    v-model="localSettings.color"
                    @input="updateLocalSetting('color', $event.target.value)"
                    type="color"
                    class="w-full h-10 border border-gray-300 rounded-lg cursor-pointer"
                  />
                </div>
              </div>

              <div class="border-t border-gray-200 pt-4"></div>
            </template>

            <!-- Background & Colors -->
            <div class="space-y-3">
              <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Background & Colors</h3>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Background Color</label>
                <input
                  v-model="localSettings.backgroundColor"
                  @input="updateLocalSetting('backgroundColor', $event.target.value)"
                  type="color"
                  class="w-full h-10 border border-gray-300 rounded-lg cursor-pointer"
                />
              </div>
            </div>

            <div class="border-t border-gray-200 pt-4"></div>

            <!-- Border & Radius -->
            <div class="space-y-3">
              <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Border</h3>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Border Radius</label>
                <input
                  v-model="localSettings.borderRadius"
                  @input="updateLocalSetting('borderRadius', $event.target.value)"
                  type="text"
                  placeholder="0px"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
                />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Border Width</label>
                <input
                  v-model="localSettings.borderWidth"
                  @input="updateLocalSetting('borderWidth', $event.target.value)"
                  type="text"
                  placeholder="0px"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
                />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Border Color</label>
                <input
                  v-model="localSettings.borderColor"
                  @input="updateLocalSetting('borderColor', $event.target.value)"
                  type="color"
                  class="w-full h-10 border border-gray-300 rounded-lg cursor-pointer"
                />
              </div>
            </div>
          </template>

          <!-- ADVANCED TAB -->
          <template v-if="activeTab === 'advanced'">
            <div class="space-y-3">
              <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide">HTML Attributes</h3>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">HTML Tag</label>
                <select
                  v-model="localSettings.htmlTag"
                  @change="updateLocalSetting('htmlTag', $event.target.value)"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
                >
                  <option value="div">div</option>
                  <option value="section">section</option>
                  <option value="article">article</option>
                  <option value="aside">aside</option>
                  <option value="header">header</option>
                  <option value="footer">footer</option>
                  <option value="nav">nav</option>
                  <option value="main">main</option>
                </select>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">CSS Class</label>
                <input
                  v-model="localSettings.className"
                  @input="updateLocalSetting('className', $event.target.value)"
                  type="text"
                  placeholder="my-custom-class"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
                />
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Element ID</label>
                <input
                  v-model="localSettings.elementId"
                  @input="updateLocalSetting('elementId', $event.target.value)"
                  type="text"
                  placeholder="my-element-id"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
                />
              </div>
            </div>
          </template>
        </div>
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
import { ref, computed, watch } from 'vue';
import { usePageStore } from '../../stores/pageStore';
import { useUIStore } from '../../stores/uiStore';
import SpacingControl from '../Controls/SpacingControl.vue';
import DimensionControl from '../Controls/DimensionControl.vue';
import FlexboxControls from '../Controls/FlexboxControls.vue';
import PositionControl from '../Controls/PositionControl.vue';

const pageStore = usePageStore();
const uiStore = useUIStore();

const activeTab = ref('layout');
const localSettings = ref({});

const tabs = [
  { id: 'content', label: 'Content' },
  { id: 'layout', label: 'Layout' },
  { id: 'style', label: 'Style' },
  { id: 'advanced', label: 'Advanced' },
];

const hasContent = computed(() => {
  const type = pageStore.selectedElement?.type;
  return ['heading', 'text', 'button'].includes(type);
});

const hasTypography = computed(() => {
  const type = pageStore.selectedElement?.type;
  return ['heading', 'text', 'button'].includes(type);
});

const isContainer = computed(() => {
  return pageStore.selectedElement?.type === 'container';
});

// Watch for element selection changes
watch(() => pageStore.selectedElement, (newElement) => {
  if (newElement) {
    localSettings.value = { ...newElement.settings };
  }
}, { immediate: true, deep: true });

function handleContentChange() {
  pageStore.updateElement(pageStore.selectedElementId, {
    content: pageStore.selectedElement.content,
  });
}

function handleSettingChange() {
  pageStore.updateElement(pageStore.selectedElementId, {
    settings: pageStore.selectedElement.settings,
  });
}

function updateLocalSetting(key, value) {
  localSettings.value[key] = value;
  handleSettingsUpdate(localSettings.value);
}

function handleSettingsUpdate(newSettings) {
  pageStore.updateElement(pageStore.selectedElementId, {
    settings: newSettings,
  });
  localSettings.value = { ...newSettings };
}

function deleteElement() {
  if (confirm('Are you sure you want to delete this element?')) {
    pageStore.deleteElement(pageStore.selectedElementId);
  }
}
</script>
