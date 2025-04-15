<template>
    <div class="flex ">
         <input v-model="date" class=" text-center  border rounded-lg focus:ring focus:ring-blue-100 focus:outline-none"  type="date">
         
    </div>
    </template>
<script setup>
import {  ref, watch } from 'vue';

    const props = defineProps({
        modelValue: { type: String, default: '' }

    })
    const date = ref(props.modelValue)


    const emit = defineEmits(["update:modelValue"])
    watch(date, (newval)=>{
        emit('update:modelValue', newval)
    })
    watch (()=>props.modelValue, (newval)=>{
        date.value = newval
    })
</script>
<style>
    
</style>