<template>
    <Sidebarnew title="Dashboard">
        <admin :admins="admins" :role="role" />
    </Sidebarnew>
</template>

<script setup>
import Sidebarnew from "../../layout/sidebarnew.vue";
import admin from "../../fragment/Admin/Operational/admin.vue";
import { onMounted, watch } from "vue";

const props = defineProps({
    admins: {
        type: Array,
    },
    role: {
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
        }
    }
);
</script>
