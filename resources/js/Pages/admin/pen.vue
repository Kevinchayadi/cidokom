<template>

    <Sidebarnew title="Dashboard" >
        <Pen :pen="pen"/>
    </Sidebarnew>
  
</template>

<script setup>
import Sidebarnew from '../../layout/sidebarnew.vue';
import Dashboard from '../../fragment/Admin/dashboard.vue';
import Pen from '../../fragment/Admin/Pen.vue';

const props = defineProps({
    pen:{
        type: Array,
    }
})
</script>