<template>

    <Sidebarnew title="Dashboard" >
        <Pen :pen="pen"/>
    </Sidebarnew>
  
</template>

<script setup>
import Sidebarnew from '../../layout/sidebarnew.vue';

import Pen from '../../fragment/Admin/Operational/Pen.vue';

const props = defineProps({
    pen:{
        type: Array,
    }
})
</script>