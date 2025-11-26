<template>
  <div class="dimension-control">
    <label class="block text-sm font-medium text-gray-700 mb-2">{{ label }}</label>
    <div class="flex gap-2">
      <input
        :value="numberValue"
        @input="handleInput"
        type="number"
        :placeholder="placeholder"
        class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500"
      />
      <select
        :value="unit"
        @change="handleUnitChange"
        class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 w-20"
      >
        <option value="px">px</option>
        <option value="%">%</option>
        <option value="em">em</option>
        <option value="rem">rem</option>
        <option value="vw">vw</option>
        <option value="vh">vh</option>
        <option value="auto">auto</option>
      </select>
    </div>
    <p v-if="description" class="mt-1 text-xs text-gray-500">{{ description }}</p>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  label: {
    type: String,
    required: true,
  },
  modelValue: {
    type: String,
    default: 'auto',
  },
  placeholder: {
    type: String,
    default: '0',
  },
  description: {
    type: String,
    default: '',
  },
});

const emit = defineEmits(['update:modelValue']);

const numberValue = computed(() => {
  if (props.modelValue === 'auto') return '';
  return props.modelValue.replace(/[a-z%]+/gi, '');
});

const unit = computed(() => {
  if (props.modelValue === 'auto') return 'auto';
  const match = props.modelValue.match(/[a-z%]+/gi);
  return match ? match[0] : 'px';
});

function handleInput(event) {
  const val = event.target.value;
  if (val === '') {
    emit('update:modelValue', 'auto');
  } else {
    emit('update:modelValue', `${val}${unit.value}`);
  }
}

function handleUnitChange(event) {
  const newUnit = event.target.value;
  if (newUnit === 'auto') {
    emit('update:modelValue', 'auto');
  } else {
    const val = numberValue.value || '0';
    emit('update:modelValue', `${val}${newUnit}`);
  }
}
</script>
