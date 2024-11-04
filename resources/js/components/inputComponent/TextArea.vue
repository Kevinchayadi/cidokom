<template >
    <textarea :name="name" :id="name" :placeholder="placeholder"  v-model="inputed" required ref="textarea" :class="classes"></textarea>
</template>
<script setup>
import { onMounted, ref, watch } from 'vue';

    const props = defineProps({
        name:{
            type: String,
        },
        placeholder:{
            type: String,
            Default:'Deskripsi'
        },
        modelValue: {
        type: [String, Number],
        default: ''
        }
    })

    const classes = ref('bg-gray-100 border-b border-black outline-none focus:border border-blue-500 w-full min-h-[120px] rounded-md drop-shadow-sm text-xs md:text-base  mt-2 resize-none')

    const inputed = ref('');
    const textarea = ref(null);
    const emit = defineEmits(['update:modelValue']);

    onMounted(()=>{
        if(textarea.value.hasAttribute('autofocus')){
            textarea.value.focus();
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
<style >
    
</style>