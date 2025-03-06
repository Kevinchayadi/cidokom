<template>

    <Sidebarnew title="Dashboard">
        <AfkirTable :afkir="afkir"/>
    </Sidebarnew>
  
</template>

<script setup>
import Sidebarnew from '../../layout/sidebarnew.vue';
import AfkirTable from '../../fragment/Admin/Main/afkirTable.vue';
const props = defineProps({
    afkir: {
        type: Object,
        required: true
    },
})

</script>