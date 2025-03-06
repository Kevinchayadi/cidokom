<template>
    <Sidebarnew title="Dashboard">
        <Pakan :pakan="pakan" />
    </Sidebarnew>
</template>

<script setup>
import Sidebarnew from "../../layout/sidebarnew.vue";
import Pakan from "../../fragment/Admin/Operational/pakan.vue";
import { watch } from "vue";

const props = defineProps({
    pakan: {
        type: Array,
    },
    flash: {
        type: Object,
        default: () => ({}),
    },
});
const emit = defineEmits(["updateFlash"]);

watch(
    () => props.flash.success,
    (newValue) => {
        if (newValue) {
            alert(newValue);
            emit("updateFlash", null); // Emit event untuk mengatur flash.success menjadi null
            window.location.reload();
            // this.$forceUpdate();
        }
    }
);
</script>
