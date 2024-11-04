<template >
    <SideBarUser>
        <CreatePenFragment :kandang="kandang" />
    </SideBarUser>
</template>
<script setup>
import CreatePenFragment from '../../fragment/createFragment/CreatePenFragment.vue';
import SideBarUser from '../../layout/SideBarUser.vue';

const props = defineProps({
    kandang:{
        type: Array,
        required: true
    }
})

</script>
<style >
    
</style>