<template>

    <Sidebarnew title="Dashboard">
        <Vaksin  :vaksin="vaksin"/>
    </Sidebarnew>

  
</template>

<script setup>
import Sidebarnew from '../../layout/sidebarnew.vue';
import { watch } from 'vue';
import Vaksin from '../../fragment/Admin/Operational/vaksin.vue';

const props = defineProps({
    vaksin:{
        type: Array,
    },
    flash: {
        type: Object,
        default: () => ({})
    }
})
const emit = defineEmits(['updateFlash']);

watch(() => props.flash.success, (newValue) => {
    if (newValue) {
        alert(newValue);
        emit('updateFlash', null); // Emit event untuk mengatur flash.success menjadi null
        window.location.reload();
        // this.$forceUpdate();
    }
});



</script>