<template>
  <div class="color-picker">
    <label v-if="label" class="block text-sm font-medium text-gray-700 mb-2">{{ label }}</label>

    <div class="flex gap-2">
      <!-- Color Preview/Input Button -->
      <div class="relative flex-1">
        <button
          type="button"
          @click="showPicker = !showPicker"
          class="w-full flex items-center gap-2 px-3 py-2 border border-gray-300 rounded-lg hover:border-gray-400 transition-colors"
        >
          <div
            class="w-8 h-8 rounded border-2 border-white shadow-sm"
            :style="{ backgroundColor: modelValue || '#ffffff' }"
          ></div>
          <span class="text-sm font-mono text-gray-700 flex-1 text-left">{{ displayValue }}</span>
        </button>

        <!-- Picker Dropdown -->
        <div
          v-if="showPicker"
          class="absolute z-50 mt-2 bg-white rounded-lg shadow-xl border border-gray-200 p-4 w-72"
          @click.stop
        >
          <!-- Native Color Input -->
          <div class="mb-4">
            <input
              type="color"
              :value="hexValue"
              @input="handleColorInput"
              class="w-full h-32 rounded cursor-pointer border border-gray-300"
            />
          </div>

          <!-- Global Palette Colors -->
          <div v-if="globalSettingsStore.colorPalette.length > 0" class="mb-4">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Global Colors</p>
            <div class="grid grid-cols-8 gap-2">
              <button
                v-for="(color, index) in globalSettingsStore.colorPalette"
                :key="index"
                type="button"
                @click="selectColor(color.value)"
                class="w-8 h-8 rounded border-2 border-white shadow-sm hover:scale-110 transition-transform"
                :style="{ backgroundColor: color.value }"
                :title="color.name"
              ></button>
            </div>
          </div>

          <!-- Opacity Slider (if enabled) -->
          <div v-if="supportsAlpha" class="mb-4">
            <label class="block text-xs font-medium text-gray-700 mb-2">
              Opacity: {{ opacity }}%
            </label>
            <input
              type="range"
              min="0"
              max="100"
              :value="opacity"
              @input="handleOpacityChange"
              class="w-full"
            />
          </div>

          <!-- HEX Input -->
          <div class="mb-4">
            <label class="block text-xs font-medium text-gray-700 mb-1">HEX</label>
            <input
              type="text"
              :value="hexValue"
              @input="handleHexInput"
              placeholder="#000000"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm font-mono focus:ring-2 focus:ring-indigo-500"
            />
          </div>

          <!-- RGB Inputs -->
          <div class="grid grid-cols-3 gap-2 mb-4">
            <div>
              <label class="block text-xs font-medium text-gray-700 mb-1">R</label>
              <input
                type="number"
                min="0"
                max="255"
                :value="rgb.r"
                @input="handleRgbInput('r', $event)"
                class="w-full px-2 py-1 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-indigo-500"
              />
            </div>
            <div>
              <label class="block text-xs font-medium text-gray-700 mb-1">G</label>
              <input
                type="number"
                min="0"
                max="255"
                :value="rgb.g"
                @input="handleRgbInput('g', $event)"
                class="w-full px-2 py-1 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-indigo-500"
              />
            </div>
            <div>
              <label class="block text-xs font-medium text-gray-700 mb-1">B</label>
              <input
                type="number"
                min="0"
                max="255"
                :value="rgb.b"
                @input="handleRgbInput('b', $event)"
                class="w-full px-2 py-1 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-indigo-500"
              />
            </div>
          </div>

          <!-- Quick Actions -->
          <div class="flex gap-2">
            <button
              type="button"
              @click="clearColor"
              class="flex-1 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50"
            >
              Clear
            </button>
            <button
              type="button"
              @click="showPicker = false"
              class="flex-1 px-3 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700"
            >
              Done
            </button>
          </div>
        </div>
      </div>

      <!-- Clear Button -->
      <button
        v-if="modelValue"
        type="button"
        @click="clearColor"
        class="p-2 text-gray-400 hover:text-gray-600 transition-colors"
        title="Clear color"
      >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted, onUnmounted } from 'vue';
import { useGlobalSettingsStore } from '../../stores/globalSettingsStore';

const props = defineProps({
  modelValue: {
    type: String,
    default: '',
  },
  label: {
    type: String,
    default: '',
  },
  supportsAlpha: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(['update:modelValue']);

const globalSettingsStore = useGlobalSettingsStore();
const showPicker = ref(false);
const opacity = ref(100);

// Parse color to RGB
const rgb = computed(() => {
  const color = props.modelValue || '#000000';

  // Handle hex colors
  if (color.startsWith('#')) {
    const hex = color.replace('#', '');
    const r = parseInt(hex.substring(0, 2), 16);
    const g = parseInt(hex.substring(2, 4), 16);
    const b = parseInt(hex.substring(4, 6), 16);
    return { r, g, b };
  }

  // Handle rgb/rgba colors
  const match = color.match(/rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*([\d.]+))?\)/);
  if (match) {
    return {
      r: parseInt(match[1]),
      g: parseInt(match[2]),
      b: parseInt(match[3]),
    };
  }

  return { r: 0, g: 0, b: 0 };
});

const hexValue = computed(() => {
  const { r, g, b } = rgb.value;
  return '#' + [r, g, b].map(x => {
    const hex = x.toString(16);
    return hex.length === 1 ? '0' + hex : hex;
  }).join('');
});

const displayValue = computed(() => {
  if (!props.modelValue) return 'No color';
  if (props.supportsAlpha && opacity.value < 100) {
    return `rgba(${rgb.value.r}, ${rgb.value.g}, ${rgb.value.b}, ${opacity.value / 100})`;
  }
  return hexValue.value.toUpperCase();
});

function handleColorInput(event) {
  selectColor(event.target.value);
}

function handleHexInput(event) {
  const hex = event.target.value;
  if (/^#[0-9A-Fa-f]{6}$/.test(hex)) {
    selectColor(hex);
  }
}

function handleRgbInput(channel, event) {
  const value = Math.max(0, Math.min(255, parseInt(event.target.value) || 0));
  const newRgb = { ...rgb.value, [channel]: value };
  const hex = '#' + [newRgb.r, newRgb.g, newRgb.b].map(x => {
    const h = x.toString(16);
    return h.length === 1 ? '0' + h : h;
  }).join('');
  selectColor(hex);
}

function handleOpacityChange(event) {
  opacity.value = parseInt(event.target.value);
  emitColor();
}

function selectColor(color) {
  emit('update:modelValue', color);
}

function emitColor() {
  if (props.supportsAlpha && opacity.value < 100) {
    const color = `rgba(${rgb.value.r}, ${rgb.value.g}, ${rgb.value.b}, ${opacity.value / 100})`;
    emit('update:modelValue', color);
  } else {
    emit('update:modelValue', hexValue.value);
  }
}

function clearColor() {
  emit('update:modelValue', '');
  showPicker.value = false;
}

// Close picker on outside click
function handleClickOutside(event) {
  const picker = event.target.closest('.color-picker');
  if (!picker && showPicker.value) {
    showPicker.value = false;
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside);

  // Parse opacity from rgba if present
  if (props.modelValue && props.modelValue.includes('rgba')) {
    const match = props.modelValue.match(/rgba?\([\d,\s]+,\s*([\d.]+)\)/);
    if (match) {
      opacity.value = Math.round(parseFloat(match[1]) * 100);
    }
  }
});

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside);
});

// Watch for external changes
watch(() => props.modelValue, (newVal) => {
  if (newVal && newVal.includes('rgba')) {
    const match = newVal.match(/rgba?\([\d,\s]+,\s*([\d.]+)\)/);
    if (match) {
      opacity.value = Math.round(parseFloat(match[1]) * 100);
    }
  }
});
</script>
