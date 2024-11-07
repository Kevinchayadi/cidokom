<!-- App.vue -->
<template>

    <Sidebarnew/>
    <!-- <BreedingHeaderTable /> -->
  
</template>

<script setup>
import { onMounted } from 'vue';
import Sidebarnew from '../../layout/sidebarnew.vue';
const props = defineProps({
    auth: {
        type: Object,
        required: true
    }
})
onMounted(()=>{
    console.log(props.auth.user.name)
})
// import BreedingHeaderTable from '../fragment/Admin/breedingHeaderTable.vue';




</script>