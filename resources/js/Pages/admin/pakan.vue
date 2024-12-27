<template>

    <Sidebarnew title="Dashboard">
        <Pakan  :pakan="pakan"/>
    </Sidebarnew>

  
</template>

<script setup>
import Sidebarnew from '../../layout/sidebarnew.vue';
import Dashboard from '../../fragment/Admin/dashboard.vue';
import Pakan from '../../fragment/Admin/pakan.vue';

const props = defineProps({
    pakan:{
        type: Array,
    }
})



</script>