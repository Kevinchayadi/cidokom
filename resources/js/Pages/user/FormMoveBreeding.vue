<template>
    <SideBarUser>
        <MoveForm :pen="pen" @submitForm="handleFormSubmit" :name="name" :chicken="chicken"/>
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
import MoveForm from '../../fragment/transactionFragment/moveForm.vue';

const props = defineProps({
    id: {
        type: Number,
        required: true
    },
    pen:{
        type:String,
        required: true
    },
    name:{
        type:String,
    },
    chicken:{
        type: Array,
    }

    
})

const handleFormSubmit = (formData) => {
    router.post(`/user/breeding/move/${props.id}`, formData, {
            onError: (errors) => {
                const errorMessages = Object.values(errors).flat();
                alert(errorMessages.join('\n'));
            }})
};

// onMounted(() => {
//   console.log(props.vaksin)
// });


</script>

<style>

</style>