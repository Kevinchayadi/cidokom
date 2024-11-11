<template>
    <SideBarUser>
        <CreateHatchery :pen="pen" :machine="machine"/>
    </SideBarUser>
</template>

<script setup>
import SideBarUser from '../../layout/SideBarUser.vue'
import CreateHatchery from '../../fragment/transactionFragment/CreateHatchery.vue'
import { usePage } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const props =defineProps({
    pen:{
        type:Array
    },
    machine:{
        type:Array
    }
})
// const errors = usePage().props.errors;

// onMounted(() => {
//     console.log(errors);
//     if (errors && Object.keys(errors).length > 0) {

    
//     alert(errors.error); // Menampilkan pesan error dalam alert
// }
// });
</script>

<style>

</style>