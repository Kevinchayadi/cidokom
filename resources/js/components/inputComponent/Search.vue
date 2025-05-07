<template>
    <div class="flex ">
         <input v-model="search" class=" text-left md:text-md text-xs border rounded-lg focus:ring focus:ring-blue-100 focus:outline-none w-[150px] px-2"  type="text" :placeholder="place">
         
    </div>
    </template>
<script setup>
import {  ref, watch } from 'vue';

    const props = defineProps({
        modelValue: { type: String, default: '' },
        place:{Type:String, default:'Search'}

    })
    const search = ref(props.modelValue)


    const emit = defineEmits(["update:modelValue"])
    watch(search, (newval)=>{
        emit('update:modelValue', newval)
    })
    watch (()=>props.modelValue, (newval)=>{
        search.value = newval
    })
</script>
<style>
    
</style>