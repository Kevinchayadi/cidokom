<template>
    <SideBarUser>
        <CreateBreeding  :pen="pen" :ayam="ayam" />
    </SideBarUser>
</template>

<script setup>
import SideBarUser from '../../layout/SideBarUser.vue'
import CreateBreeding from '../../fragment/transactionFragment/CreateBreeding.vue'
import { computed, onMounted, watch } from 'vue';
import { useStore } from 'vuex';

const props = defineProps({
    pen:{
        type: Array,
        required: true
    },
    ayam:{
        type: Array,
        required: true
    },
    auth:{
        type: Object,
        required: true
    }
})
// onMounted(()=>
//     console.log(props.pen),
//     console.log(props.auth)
//     )

// watch(user, (newValue) => {
//     console.log('User diperbarui:', newValue); // Log ketika user diperbarui
// });

    
</script>

<style>

</style>