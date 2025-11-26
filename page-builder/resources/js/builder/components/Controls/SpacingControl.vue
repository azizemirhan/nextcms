<template>
  <div class="spacing-control">
    <div class="flex items-center justify-between mb-2">
      <label class="block text-sm font-medium text-gray-700">{{ label }}</label>
      <button
        @click="toggleLinked"
        :class="['p-1 rounded hover:bg-gray-100 transition-colors', isLinked ? 'text-indigo-600' : 'text-gray-400']"
        :title="isLinked ? 'Unlink values' : 'Link values'"
      >
        <svg v-if="isLinked" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd"/>
        </svg>
        <svg v-else class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" clip-rule="evenodd"/>
        </svg>
      </button>
    </div>

    <div v-if="isLinked" class="space-y-2">
      <div class="flex gap-2">
        <input
          v-model="allValue"
          @input="handleAllChange"
          type="text"
          placeholder="0px"
          class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
        />
        <select
          v-model="unit"
          @change="handleUnitChange"
          class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
        >
          <option value="px">px</option>
          <option value="%">%</option>
          <option value="em">em</option>
          <option value="rem">rem</option>
          <option value="vw">vw</option>
          <option value="vh">vh</option>
        </select>
      </div>
      <p class="text-xs text-gray-500">All sides</p>
    </div>

    <div v-else class="grid grid-cols-2 gap-2">
      <!-- Top -->
      <div>
        <label class="block text-xs text-gray-600 mb-1">Top</label>
        <input
          v-model="localValue.top"
          @input="handleChange"
          type="text"
          placeholder="0px"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
        />
      </div>

      <!-- Right -->
      <div>
        <label class="block text-xs text-gray-600 mb-1">Right</label>
        <input
          v-model="localValue.right"
          @input="handleChange"
          type="text"
          placeholder="0px"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
        />
      </div>

      <!-- Bottom -->
      <div>
        <label class="block text-xs text-gray-600 mb-1">Bottom</label>
        <input
          v-model="localValue.bottom"
          @input="handleChange"
          type="text"
          placeholder="0px"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
        />
      </div>

      <!-- Left -->
      <div>
        <label class="block text-xs text-gray-600 mb-1">Left</label>
        <input
          v-model="localValue.left"
          @input="handleChange"
          type="text"
          placeholder="0px"
          class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
  label: {
    type: String,
    required: true,
  },
  modelValue: {
    type: Object,
    default: () => ({ top: '0px', right: '0px', bottom: '0px', left: '0px' }),
  },
});

const emit = defineEmits(['update:modelValue']);

const isLinked = ref(false);
const unit = ref('px');
const allValue = ref('0');
const localValue = ref({ ...props.modelValue });

watch(() => props.modelValue, (newVal) => {
  localValue.value = { ...newVal };
}, { deep: true });

function toggleLinked() {
  isLinked.value = !isLinked.value;
  if (isLinked.value) {
    // Set all to top value when linking
    const topValue = localValue.value.top || '0px';
    allValue.value = topValue.replace(/[a-z%]+/gi, '');
    const match = topValue.match(/[a-z%]+/gi);
    if (match) unit.value = match[0];
    handleAllChange();
  }
}

function handleAllChange() {
  const val = `${allValue.value}${unit.value}`;
  localValue.value = {
    top: val,
    right: val,
    bottom: val,
    left: val,
  };
  emit('update:modelValue', localValue.value);
}

function handleUnitChange() {
  handleAllChange();
}

function handleChange() {
  emit('update:modelValue', localValue.value);
}
</script>
