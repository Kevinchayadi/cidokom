<template>
    <Sidebarnew title="hatchery">
        <HatcheryMainTable :hatchery="hatchery" />
    </Sidebarnew>

</template>

<script setup>
import HatcheryMainTable from '../../fragment/Admin/Main/hatcheryMainTable.vue';
import Sidebarnew from '../../layout/sidebarnew.vue';
const props = defineProps({
    hatchery:{
        type: Array,
    }
})

</script>

<style>

</style>