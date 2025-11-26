<template>
  <div class="background-controls space-y-4">
    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Background</h3>

    <!-- Background Type Tabs -->
    <div class="flex gap-1 bg-gray-100 rounded-lg p-1">
      <button
        v-for="type in ['color', 'gradient', 'image']"
        :key="type"
        @click="backgroundType = type"
        :class="['flex-1 px-3 py-2 rounded text-sm font-medium transition-colors capitalize', backgroundType === type ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900']"
      >
        {{ type }}
      </button>
    </div>

    <!-- Color Background -->
    <div v-if="backgroundType === 'color'">
      <ColorPicker
        :model-value="settings.backgroundColor"
        @update:model-value="updateSetting('backgroundColor', $event)"
        label="Background Color"
        :supports-alpha="true"
      />
    </div>

    <!-- Gradient Background -->
    <div v-if="backgroundType === 'gradient'" class="space-y-4">
      <!-- Gradient Type -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Gradient Type</label>
        <div class="grid grid-cols-2 gap-2">
          <button
            v-for="type in ['linear', 'radial']"
            :key="type"
            @click="updateGradient('type', type)"
            :class="['py-2 px-3 border rounded-lg text-sm font-medium transition-colors capitalize', gradient.type === type ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50']"
          >
            {{ type }}
          </button>
        </div>
      </div>

      <!-- Gradient Angle (for linear) -->
      <div v-if="gradient.type === 'linear'">
        <label class="block text-sm font-medium text-gray-700 mb-2">
          Angle: {{ gradient.angle }}°
        </label>
        <input
          type="range"
          min="0"
          max="360"
          :value="gradient.angle"
          @input="updateGradient('angle', $event.target.value)"
          class="w-full"
        />
      </div>

      <!-- Gradient Position (for radial) -->
      <div v-if="gradient.type === 'radial'">
        <label class="block text-sm font-medium text-gray-700 mb-2">Position</label>
        <select
          :value="gradient.position"
          @change="updateGradient('position', $event.target.value)"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
        >
          <option value="center">Center</option>
          <option value="top">Top</option>
          <option value="bottom">Bottom</option>
          <option value="left">Left</option>
          <option value="right">Right</option>
          <option value="top left">Top Left</option>
          <option value="top right">Top Right</option>
          <option value="bottom left">Bottom Left</option>
          <option value="bottom right">Bottom Right</option>
        </select>
      </div>

      <!-- Color Stops -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Color Stops</label>
        <div class="space-y-3">
          <div
            v-for="(stop, index) in gradient.colorStops"
            :key="index"
            class="flex items-center gap-2"
          >
            <ColorPicker
              :model-value="stop.color"
              @update:model-value="updateColorStop(index, 'color', $event)"
              :supports-alpha="true"
            />
            <input
              type="number"
              min="0"
              max="100"
              :value="stop.position"
              @input="updateColorStop(index, 'position', $event.target.value)"
              class="w-20 px-2 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
            />
            <span class="text-sm text-gray-500">%</span>
            <button
              v-if="gradient.colorStops.length > 2"
              @click="removeColorStop(index)"
              class="p-2 text-red-500 hover:text-red-700 transition-colors"
              title="Remove stop"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </div>
        </div>
        <button
          @click="addColorStop"
          class="mt-3 w-full py-2 text-sm font-medium text-indigo-600 border border-indigo-600 rounded-lg hover:bg-indigo-50 transition-colors"
        >
          + Add Color Stop
        </button>
      </div>

      <!-- Gradient Preview -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Preview</label>
        <div
          class="w-full h-24 rounded-lg border-2 border-gray-200"
          :style="{ background: gradientCss }"
        ></div>
      </div>
    </div>

    <!-- Image Background -->
    <div v-if="backgroundType === 'image'" class="space-y-4">
      <!-- Image URL -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Image URL</label>
        <input
          :value="settings.backgroundImage"
          @input="updateSetting('backgroundImage', $event.target.value)"
          type="text"
          placeholder="https://example.com/image.jpg"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
        />
      </div>

      <!-- Image Upload -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Or Upload Image</label>
        <input
          type="file"
          accept="image/*"
          @change="handleImageUpload"
          class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
        />
      </div>

      <!-- Background Size -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Size</label>
        <select
          :value="settings.backgroundSize"
          @change="updateSetting('backgroundSize', $event.target.value)"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
        >
          <option value="cover">Cover</option>
          <option value="contain">Contain</option>
          <option value="auto">Auto</option>
          <option value="100% 100%">Stretch</option>
        </select>
      </div>

      <!-- Background Position -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Position</label>
        <div class="grid grid-cols-3 gap-2">
          <button
            v-for="pos in ['top', 'center', 'bottom']"
            :key="pos"
            @click="updateSetting('backgroundPosition', pos)"
            :class="['py-2 px-3 border rounded-lg text-sm font-medium transition-colors capitalize', settings.backgroundPosition === pos ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50']"
          >
            {{ pos }}
          </button>
        </div>
      </div>

      <!-- Background Repeat -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Repeat</label>
        <select
          :value="settings.backgroundRepeat"
          @change="updateSetting('backgroundRepeat', $event.target.value)"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
        >
          <option value="no-repeat">No Repeat</option>
          <option value="repeat">Repeat</option>
          <option value="repeat-x">Repeat X</option>
          <option value="repeat-y">Repeat Y</option>
        </select>
      </div>

      <!-- Background Attachment -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Attachment</label>
        <div class="grid grid-cols-2 gap-2">
          <button
            v-for="attachment in ['scroll', 'fixed']"
            :key="attachment"
            @click="updateSetting('backgroundAttachment', attachment)"
            :class="['py-2 px-3 border rounded-lg text-sm font-medium transition-colors capitalize', settings.backgroundAttachment === attachment ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50']"
          >
            {{ attachment }}
          </button>
        </div>
      </div>

      <!-- Image Preview -->
      <div v-if="settings.backgroundImage">
        <label class="block text-sm font-medium text-gray-700 mb-2">Preview</label>
        <div
          class="w-full h-32 rounded-lg border-2 border-gray-200"
          :style="{
            backgroundImage: `url(${settings.backgroundImage})`,
            backgroundSize: settings.backgroundSize || 'cover',
            backgroundPosition: settings.backgroundPosition || 'center',
            backgroundRepeat: settings.backgroundRepeat || 'no-repeat',
          }"
        ></div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import ColorPicker from './ColorPicker.vue';

const props = defineProps({
  settings: {
    type: Object,
    required: true,
  },
});

const emit = defineEmits(['update']);

const backgroundType = ref('color');

// Gradient state
const gradient = ref({
  type: 'linear',
  angle: 90,
  position: 'center',
  colorStops: [
    { color: '#667eea', position: 0 },
    { color: '#764ba2', position: 100 },
  ],
});

function updateSetting(key, value) {
  emit('update', { ...props.settings, [key]: value });
}

function updateGradient(key, value) {
  gradient.value[key] = value;
  applyGradient();
}

function updateColorStop(index, key, value) {
  gradient.value.colorStops[index][key] = value;
  applyGradient();
}

function addColorStop() {
  const lastStop = gradient.value.colorStops[gradient.value.colorStops.length - 1];
  const newPosition = Math.min(lastStop.position + 10, 100);
  gradient.value.colorStops.push({
    color: lastStop.color,
    position: newPosition,
  });
  applyGradient();
}

function removeColorStop(index) {
  if (gradient.value.colorStops.length > 2) {
    gradient.value.colorStops.splice(index, 1);
    applyGradient();
  }
}

const gradientCss = computed(() => {
  const stops = gradient.value.colorStops
    .sort((a, b) => a.position - b.position)
    .map(stop => `${stop.color} ${stop.position}%`)
    .join(', ');

  if (gradient.value.type === 'linear') {
    return `linear-gradient(${gradient.value.angle}deg, ${stops})`;
  } else {
    return `radial-gradient(circle at ${gradient.value.position}, ${stops})`;
  }
});

function applyGradient() {
  emit('update', { ...props.settings, backgroundImage: gradientCss.value });
}

async function handleImageUpload(event) {
  const file = event.target.files[0];
  if (!file) return;

  // Create a temporary URL for preview
  const reader = new FileReader();
  reader.onload = (e) => {
    updateSetting('backgroundImage', e.target.result);
  };
  reader.readAsDataURL(file);

  // TODO: Upload to server and get permanent URL
  // For now, we're using data URL which is not ideal for production
}
</script>
