<template>
    <SideBarUser>
        <AddVaksin :id="id" :vaksin="vaksin" :pen="pen" @submitForm="handleFormSubmit" />
    </SideBarUser>
    
</template>

<script setup>
import SideBarUser from '../../layout/SideBarUser.vue';
import DailyBreeding from '../../fragment/transactionFragment/DailyBreeding.vue'
import { onMounted } from 'vue';
import AddVaksin from '../../fragment/transactionFragment/AddVaksin.vue';
import {
        router
    } from "@inertiajs/vue3";


const props = defineProps({
    id: {
        type: String,
        required: true
    },
    vaksin:{
        type: Array,
        required: true
    },
    pen:{
        type:String,
        required: true
    }
    
})

const handleFormSubmit = (formData) => {
    router.post(`/user/breeding/vaccine/${props.id}`, formData, {
            onError: (errors) => {
                const errorMessages = Object.values(errors).flat();
                alert(errorMessages.join('\n'));
            }})
};

onMounted(() => {
  console.log(props.vaksin)
});


</script>

<style>

</style>