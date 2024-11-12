<template>
    <Sidebarnew>

        <BreedingMainTable />
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
    }
})
onMounted(()=>{
    console.log(props.auth.user.name)
})

</script>

<style>

</style>