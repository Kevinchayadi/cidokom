<template >
    <input :type="type" :id="name" :name="name" :placeholder="placeholder" required ref="inputref" :class="classes"> 
</template>
<script setup>
import { onMounted, ref } from 'vue';

    const props = defineProps({
        name:{
            type: String,
        },
        type:{
            type: String,
            default: 'text'
        },
        placeholder:{
            type: String,
            Default:''
        },
    })

    const classes = ref('bg-gray-100 border-b border-black outline-none focus:border border-blue-500 rounded-md drop-shadow-sm text-xs pl-2 p-1 mt-2')

    const inputed = ref('');
    const inputref = ref(null)

    onMounted(()=>{
        if(inputref.value.hasAttribute('autofocus')){
            inputref.value.focus();
        }
    })

</script>
<style >
    
</style>