<template>
  <div class="position-control space-y-4">
    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Position & Layout</h3>

    <!-- Position Type -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">Position</label>
      <select
        :value="settings.position || 'relative'"
        @change="updateSetting('position', $event.target.value)"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
      >
        <option value="static">Static</option>
        <option value="relative">Relative</option>
        <option value="absolute">Absolute</option>
        <option value="fixed">Fixed</option>
        <option value="sticky">Sticky</option>
      </select>
    </div>

    <!-- Position Offsets (for absolute, fixed, sticky) -->
    <template v-if="['absolute', 'fixed', 'sticky', 'relative'].includes(settings.position)">
      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="block text-xs text-gray-600 mb-1">Top</label>
          <input
            :value="settings.top || ''"
            @input="updateSetting('top', $event.target.value)"
            type="text"
            placeholder="auto"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
          />
        </div>
        <div>
          <label class="block text-xs text-gray-600 mb-1">Right</label>
          <input
            :value="settings.right || ''"
            @input="updateSetting('right', $event.target.value)"
            type="text"
            placeholder="auto"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
          />
        </div>
        <div>
          <label class="block text-xs text-gray-600 mb-1">Bottom</label>
          <input
            :value="settings.bottom || ''"
            @input="updateSetting('bottom', $event.target.value)"
            type="text"
            placeholder="auto"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
          />
        </div>
        <div>
          <label class="block text-xs text-gray-600 mb-1">Left</label>
          <input
            :value="settings.left || ''"
            @input="updateSetting('left', $event.target.value)"
            type="text"
            placeholder="auto"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
          />
        </div>
      </div>
    </template>

    <!-- Z-Index -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">Z-Index</label>
      <input
        :value="settings.zIndex || ''"
        @input="updateSetting('zIndex', $event.target.value)"
        type="number"
        placeholder="auto"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
      />
    </div>

    <!-- Overflow -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">Overflow</label>
      <div class="grid grid-cols-2 gap-2">
        <button
          v-for="overflow in ['visible', 'hidden', 'scroll', 'auto']"
          :key="overflow"
          @click="updateSetting('overflow', overflow)"
          :class="['py-2 px-3 border rounded-lg text-sm font-medium transition-colors capitalize', settings.overflow === overflow ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50']"
        >
          {{ overflow }}
        </button>
      </div>
    </div>
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

function updateSetting(key, value) {
  emit('update', { ...props.settings, [key]: value });
}
</script>
