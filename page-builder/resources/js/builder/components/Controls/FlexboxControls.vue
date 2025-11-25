<template>
  <div class="flexbox-controls space-y-4">
    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Flexbox Layout</h3>

    <!-- Display -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">Display</label>
      <div class="grid grid-cols-3 gap-2">
        <button
          v-for="display in ['flex', 'grid', 'block']"
          :key="display"
          @click="updateSetting('display', display)"
          :class="['py-2 px-3 border rounded-lg text-sm font-medium transition-colors capitalize', settings.display === display ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50']"
        >
          {{ display }}
        </button>
      </div>
    </div>

    <template v-if="settings.display === 'flex'">
      <!-- Flex Direction -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Direction</label>
        <div class="grid grid-cols-2 gap-2">
          <button
            v-for="dir in flexDirections"
            :key="dir.value"
            @click="updateSetting('flexDirection', dir.value)"
            :class="['py-2 px-3 border rounded-lg text-sm font-medium transition-colors flex items-center justify-center gap-2', settings.flexDirection === dir.value ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50']"
            :title="dir.label"
          >
            <span v-html="dir.icon"></span>
            <span class="text-xs">{{ dir.label }}</span>
          </button>
        </div>
      </div>

      <!-- Justify Content -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Justify Content</label>
        <select
          :value="settings.justifyContent"
          @change="updateSetting('justifyContent', $event.target.value)"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
        >
          <option value="flex-start">Start</option>
          <option value="center">Center</option>
          <option value="flex-end">End</option>
          <option value="space-between">Space Between</option>
          <option value="space-around">Space Around</option>
          <option value="space-evenly">Space Evenly</option>
        </select>
      </div>

      <!-- Align Items -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Align Items</label>
        <select
          :value="settings.alignItems"
          @change="updateSetting('alignItems', $event.target.value)"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
        >
          <option value="flex-start">Start</option>
          <option value="center">Center</option>
          <option value="flex-end">End</option>
          <option value="stretch">Stretch</option>
          <option value="baseline">Baseline</option>
        </select>
      </div>

      <!-- Gap -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Gap</label>
        <input
          :value="settings.gap"
          @input="updateSetting('gap', $event.target.value)"
          type="text"
          placeholder="20px"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
        />
      </div>

      <!-- Wrap -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Wrap</label>
        <div class="grid grid-cols-3 gap-2">
          <button
            v-for="wrap in ['nowrap', 'wrap', 'wrap-reverse']"
            :key="wrap"
            @click="updateSetting('flexWrap', wrap)"
            :class="['py-2 px-3 border rounded-lg text-sm font-medium transition-colors', settings.flexWrap === wrap ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50']"
          >
            {{ wrap.replace('-', ' ') }}
          </button>
        </div>
      </div>
    </template>

    <template v-if="settings.display === 'grid'">
      <!-- Grid Template Columns -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Columns</label>
        <input
          :value="settings.gridTemplateColumns"
          @input="updateSetting('gridTemplateColumns', $event.target.value)"
          type="text"
          placeholder="repeat(3, 1fr)"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
        />
        <p class="mt-1 text-xs text-gray-500">e.g., repeat(3, 1fr) or 1fr 2fr 1fr</p>
      </div>

      <!-- Grid Gap -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Gap</label>
        <input
          :value="settings.gap"
          @input="updateSetting('gap', $event.target.value)"
          type="text"
          placeholder="20px"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
        />
      </div>
    </template>
  </div>
</template>

<script setup>
const props = defineProps({
  settings: {
    type: Object,
    required: true,
  },
});

const emit = defineEmits(['update']);

const flexDirections = [
  {
    value: 'row',
    label: 'Row',
    icon: '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
  },
  {
    value: 'column',
    label: 'Column',
    icon: '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
  },
  {
    value: 'row-reverse',
    label: 'Row Rev',
    icon: '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
  },
  {
    value: 'column-reverse',
    label: 'Col Rev',
    icon: '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 15l7-7 7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
  },
];

function updateSetting(key, value) {
  emit('update', { ...props.settings, [key]: value });
}
</script>
