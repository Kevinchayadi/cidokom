<template>
    <div class="flex items-center align-center m-2 space-x-2">
        <input
            type="checkbox"
            :id="name"
            :name="name"
            :checked="modelValue"
            @change="updateValue"
        />
        <label :for="name" class="text-md align-middle">{{ text }}</label>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
    modelValue: {
        type: Boolean,
        default: false
    },
    text: {
        type: String,
        default: 'Remember ME'
    },
    name: {
        type: String,
        default: 'name'
    }
});

const emit = defineEmits(['update:modelValue']);

const updateValue = (event) => {
    emit('update:modelValue', event.target.checked);
};
</script>