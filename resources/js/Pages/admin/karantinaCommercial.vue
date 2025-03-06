<template>

    <Sidebarnew title="Dashboard">
        <KarantinaCMR :afkir="afkir"/>
    </Sidebarnew>
  
</template>

<script setup>
import Sidebarnew from '../../layout/sidebarnew.vue';

import KarantinaCMR from '../../fragment/Admin/Main/KarantinaCMR.vue';
const props = defineProps({
    afkir: {
        type: Object,
        required: true
    },
})

</script>