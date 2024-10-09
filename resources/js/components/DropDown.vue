<template>
    
    
      <select 
        id="inputSelect"
        :name="name"
        v-model="selectedOption" 
        :class="classes"
      >
      
        <option disabled value="">Please select an option</option>
        <option v-if="data" v-for="data in datas" :key="data.id" :value="data.id">
          {{ data.name }}
        </option>
      </select>
    
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  const props = defineProps({
    datas : {
        type: Array,
        required: true,
    },
    name:{
        type: String,
        
    }
  })

  const classes = ref('bg-gray-100 border-b border-black outline-none focus:border border-blue-500 rounded-md drop-shadow-sm text-xs pl-2 p-1 mt-2')

  

  const selectedOption = ref('');
  </script>
  
  <style scoped>

  </style>
  
  