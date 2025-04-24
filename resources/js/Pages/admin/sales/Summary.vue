<template>

    <Sidebarnew title="Dashboard">
        <SummarySales :dailySales="dailySales" :recentCust="recentCust" :passiveCust="passiveCust"  />
    </Sidebarnew>


</template>

<script setup>
    import {
        onMounted
    } from 'vue';
    import Sidebarnew from '../../../layout/sidebarnew.vue';
    import {
        useStore
    } from 'vuex';
import SummarySales from '../../../fragment/Admin/Sales/SummarySales.vue';

    const props = defineProps({
        dailySales: {
            type: Array,
            required: true
        },
        recentCust: {
            type: Array,
            required: true
        },
        passiveCust: {
            type: Number,
            required: true
        },

    })
    const store = useStore();
    onMounted(() => {
        // console.log(props.recentCust)
        // console.log(props.passiveCust)

        if (!localStorage.getItem('page_refreshed')) {
            localStorage.setItem('page_refreshed', true);
            window.location.reload();
            window.location.reload(true);
        }
        if (!store.getters.user) {
            // console.log('test')
            window.location.reload();
            window.location.reload(true);
        }
    });
</script>
