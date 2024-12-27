<template>

    <Sidebarnew title="Dashboard" >
        <Kandang :kandang="kandang"/>
    </Sidebarnew>
  
</template>

<script setup>
import Sidebarnew from '../../layout/sidebarnew.vue';
import Dashboard from '../../fragment/Admin/dashboard.vue';
import Kandang from '../../fragment/Admin/kandang.vue';
const props = defineProps({
    kandang:{
        type: Array,
    }
})
</script>