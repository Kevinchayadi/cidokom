<template>
    
    <input :type="type" :id="name" :name="name" :placeholder="placeholder":required="required"
        v-model="inputed" ref="inputref" :step="isStep ? '0.01' : '1'" :class="classes">
</template>
<script setup>
    import {
        onMounted,
        ref,
        watch
    } from 'vue';

    const props = defineProps({
        name: {
            type: String,
        },
        type: {
            type: String,
            default: 'text'
        },
        placeholder: {
            type: String,
            Default: ''
        },
        required:{
            type: Boolean,
            default: true
        },
        isStep: {
            type: Boolean,
            default: false
        },
        modelValue: {
        type: [String, Number],
        default: ''
    }
    })

    const classes = ref(
        'bg-gray-100 border-b border-black outline-none w-full focus:border border-blue-500 rounded-md drop-shadow-sm text-xs md:text-base pl-2 mt-2 py-1'
        )

    const inputed = ref('');
    const inputref = ref(null)

    const emit = defineEmits(['update:modelValue']);

    onMounted(() => {
        if (inputref.value.hasAttribute('autofocus')) {
            inputref.value.focus();
        }
    })
    watch(inputed, (newVal) => {
        emit('update:modelValue', newVal);
    });

    // Sync with changes from the parent component
    watch(() => props.modelValue, (newVal) => {
        inputed.value = newVal;
    });
</script>
<style>

</style>
