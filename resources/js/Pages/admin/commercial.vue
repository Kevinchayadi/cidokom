<template>
    <Sidebarnew title="commercial">

        <CommercialMainTable :commercial="commercial"/>
    </Sidebarnew>
</template>

<script setup>
    import CommercialMainTable from '../../fragment/Admin/Main/commercialMainTable.vue';
    import Sidebarnew from '../../layout/sidebarnew.vue';

    const props = defineProps({
        commercial: {
            type: Array,
            required: true
        }
    })
</script>

<style>

</style>
