<template>

    <Sidebarnew title="Dashboard">
        <KarantinaBRD :afkir="afkir"/>
    </Sidebarnew>
  
</template>

<script setup>
import Sidebarnew from '../../layout/sidebarnew.vue';

import KarantinaBRD from '../../fragment/Admin/Main/KarantinaBRD.vue';
const props = defineProps({
    afkir: {
        type: Object,
        required: true
    },
})

</script>