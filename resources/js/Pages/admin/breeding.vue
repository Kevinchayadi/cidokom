<template>
    <Sidebarnew title="breeding">

        <BreedingMainTable :breeding="breeding"/>
    </Sidebarnew>
</template>

<script setup>
import { onMounted } from 'vue';
import BreedingMainTable from '../../fragment/Admin/breedingMainTable.vue';
import Sidebarnew from '../../layout/sidebarnew.vue';
const props = defineProps({
    auth: {
        type: Object,
        required: true
    },
    breeding:{
        type: Array,
    }
})
// onMounted(()=>{
//     console.log(props.breeding)
// })

</script>

<style>

</style>