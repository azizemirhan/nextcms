<template>
  <Teleport to="body">
    <div v-if="isOpen" class="fixed inset-0 z-50 overflow-y-auto">
      <!-- Backdrop -->
      <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="$emit('close')"></div>

      <!-- Modal -->
      <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative w-full max-w-4xl bg-white rounded-xl shadow-2xl transform transition-all">
          <!-- Header -->
          <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Global Settings</h2>
            <button
              @click="$emit('close')"
              class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round"/>
              </svg>
            </button>
          </div>

          <!-- Content -->
          <div class="px-6 py-6 max-h-[70vh] overflow-y-auto">
            <!-- Tabs -->
            <div class="border-b border-gray-200 mb-6">
              <nav class="-mb-px flex space-x-6">
                <button
                  v-for="tab in tabs"
                  :key="tab.id"
                  @click="activeTab = tab.id"
                  :class="['py-3 px-1 border-b-2 font-medium text-sm transition-colors', activeTab === tab.id ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300']"
                >
                  {{ tab.label }}
                </button>
              </nav>
            </div>

            <!-- Color Palette Tab -->
            <div v-if="activeTab === 'colors'" class="space-y-6">
              <div>
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Color Palette</h3>
                <p class="text-sm text-gray-500 mb-4">
                  Define your site's color palette. These colors will be available throughout the builder.
                </p>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                  <div
                    v-for="(color, index) in globalSettings.colorPalette"
                    :key="index"
                    class="space-y-2"
                  >
                    <div class="relative">
                      <input
                        v-model="color.value"
                        @input="updateColor(index, color)"
                        type="color"
                        class="w-full h-24 rounded-lg cursor-pointer border-2 border-gray-200"
                      />
                      <button
                        v-if="globalSettings.colorPalette.length > 1"
                        @click="removeColor(index)"
                        class="absolute -top-2 -right-2 p-1 bg-red-500 text-white rounded-full hover:bg-red-600 transition-colors"
                      >
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                      </button>
                    </div>
                    <input
                      v-model="color.name"
                      @input="updateColor(index, color)"
                      type="text"
                      placeholder="Color Name"
                      class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
                    />
                    <p class="text-xs text-gray-500 font-mono">{{ color.value }}</p>
                  </div>

                  <!-- Add Color Button -->
                  <button
                    @click="addColor"
                    class="h-24 border-2 border-dashed border-gray-300 rounded-lg hover:border-indigo-400 hover:bg-indigo-50 transition-colors flex items-center justify-center"
                  >
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path d="M12 4v16m8-8H4" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                  </button>
                </div>
              </div>
            </div>

            <!-- Typography Tab -->
            <div v-if="activeTab === 'typography'" class="space-y-6">
              <div>
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Typography Presets</h3>
                <p class="text-sm text-gray-500 mb-4">
                  Set default typography styles for headings and body text.
                </p>

                <div class="space-y-4">
                  <div
                    v-for="(preset, type) in globalSettings.typographyPresets"
                    :key="type"
                    class="p-4 border border-gray-200 rounded-lg"
                  >
                    <h4 class="text-sm font-semibold text-gray-700 mb-3 uppercase">{{ type }}</h4>
                    <div class="grid grid-cols-2 gap-4">
                      <!-- Font Family -->
                      <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Font Family</label>
                        <select
                          v-model="preset.fontFamily"
                          @change="updatePreset(type, preset)"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
                        >
                          <option v-for="font in globalSettings.selectedFonts" :key="font" :value="font">
                            {{ font }}
                          </option>
                        </select>
                      </div>

                      <!-- Font Size -->
                      <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Font Size</label>
                        <input
                          v-model="preset.fontSize"
                          @input="updatePreset(type, preset)"
                          type="text"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
                        />
                      </div>

                      <!-- Font Weight -->
                      <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Font Weight</label>
                        <select
                          v-model="preset.fontWeight"
                          @change="updatePreset(type, preset)"
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

                      <!-- Line Height -->
                      <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Line Height</label>
                        <input
                          v-model="preset.lineHeight"
                          @input="updatePreset(type, preset)"
                          type="text"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
                        />
                      </div>
                    </div>

                    <!-- Preview -->
                    <div class="mt-3 p-3 bg-gray-50 rounded">
                      <p
                        :style="{
                          fontFamily: preset.fontFamily,
                          fontSize: preset.fontSize,
                          fontWeight: preset.fontWeight,
                          lineHeight: preset.lineHeight,
                        }"
                      >
                        Preview Text ({{ type.toUpperCase() }})
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Fonts Tab -->
            <div v-if="activeTab === 'fonts'" class="space-y-6">
              <div>
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Google Fonts</h3>
                <p class="text-sm text-gray-500 mb-4">
                  Select fonts to use in your project. Selected fonts will be loaded from Google Fonts.
                </p>

                <!-- Selected Fonts -->
                <div class="mb-6">
                  <h4 class="text-xs font-semibold text-gray-700 mb-2 uppercase">Selected Fonts ({{ globalSettings.selectedFonts.length }})</h4>
                  <div class="flex flex-wrap gap-2">
                    <div
                      v-for="font in globalSettings.selectedFonts"
                      :key="font"
                      class="inline-flex items-center gap-2 px-3 py-1.5 bg-indigo-100 text-indigo-800 rounded-full text-sm"
                    >
                      <span>{{ font }}</span>
                      <button
                        @click="removeFont(font)"
                        class="hover:bg-indigo-200 rounded-full p-0.5"
                      >
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                      </button>
                    </div>
                  </div>
                </div>

                <!-- Available Fonts -->
                <div>
                  <h4 class="text-xs font-semibold text-gray-700 mb-2 uppercase">Available Fonts</h4>
                  <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 max-h-96 overflow-y-auto">
                    <button
                      v-for="font in availableFonts"
                      :key="font"
                      @click="addFont(font)"
                      :disabled="globalSettings.selectedFonts.includes(font)"
                      :class="['px-4 py-3 text-left border rounded-lg transition-colors', globalSettings.selectedFonts.includes(font) ? 'border-gray-200 bg-gray-50 text-gray-400 cursor-not-allowed' : 'border-gray-300 hover:border-indigo-400 hover:bg-indigo-50']"
                      :style="{ fontFamily: font }"
                    >
                      {{ font }}
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Footer -->
          <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-200 bg-gray-50">
            <button
              @click="$emit('close')"
              class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
            >
              Cancel
            </button>
            <button
              @click="saveSettings"
              :disabled="isSaving"
              class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors disabled:opacity-50"
            >
              {{ isSaving ? 'Saving...' : 'Save Changes' }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </Teleport>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useGlobalSettingsStore } from '../../stores/globalSettingsStore';

const props = defineProps({
  isOpen: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(['close']);

const globalSettings = useGlobalSettingsStore();
const activeTab = ref('colors');
const isSaving = ref(false);

const tabs = [
  { id: 'colors', label: 'Colors' },
  { id: 'typography', label: 'Typography' },
  { id: 'fonts', label: 'Fonts' },
];

const availableFonts = computed(() => {
  return globalSettings.googleFonts;
});

onMounted(() => {
  globalSettings.loadGoogleFonts();
  globalSettings.loadSelectedFonts();
});

function updateColor(index, color) {
  globalSettings.updateColorPalette(index, color);
}

function addColor() {
  globalSettings.addColorToPalette({
    name: 'New Color',
    value: '#000000',
  });
}

function removeColor(index) {
  globalSettings.removeColorFromPalette(index);
}

function updatePreset(type, preset) {
  globalSettings.updateTypographyPreset(type, preset);
}

function addFont(fontFamily) {
  globalSettings.addSelectedFont(fontFamily);
}

function removeFont(fontFamily) {
  globalSettings.removeSelectedFont(fontFamily);
}

async function saveSettings() {
  try {
    isSaving.value = true;
    await globalSettings.saveGlobalSettings();
    emit('close');
  } catch (error) {
    alert('Failed to save settings. Please try again.');
  } finally {
    isSaving.value = false;
  }
}
</script>
