<template>
    <div class="w-full d-flex">
        <Headers tittle="Hatchery List" />
        <FormButton name="add new" @click="createForm" class="text-sm mb-2" />
        <table class="w-full">
            <tbody>
                <tr v-for="data in hatchery" :key="data.id_hatchery" class="w-full border-b border-b-white text-primary-text-light">
                    <td>{{ data.id_hatchery }}</td>
                    <td class="text-right">
                        <div v-if="data.hatchery_details?.[0]?.infertile === null">
                            <button :class="buttonClasses" @click="eightydays(data.id_hatchery)">input (18 Days)</button>
                        </div>
                        <div v-else-if="data.hatchery_details?.[0]?.saleable === null">
                            <button :class="buttonClasses" @click="twentyonedays(data.id_hatchery)">input (21 Days)</button>
                        </div>
                        <div v-else="data.hatchery_details?.[0]?.saleable === null">
                            <button :class="buttonClasses" @click="moveTo(data.id_hatchery)">moveTo</button>
                        </div>
                    
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
</template>


<script setup>
    import {
        computed,
        onMounted
    } from 'vue';
    import FormButton from '../../components/inputComponent/FormButton.vue';
    import {
        router
    } from '@inertiajs/vue3';
import Headers from '../../components/Headers.vue';

    const props = defineProps({
        hatchery: {
            type: Array,
            required: true
        }
    });
//     onMounted(()=>
//         console.log(props.hatchery[0].id_hatchery)
//   )


    const createForm = () => {
        router.get('/user/hatchery/create')
    }
    const threedays = (id) => {
        router.get(`/user/hatchery/threeInput/${id}`)
    };

    const eightydays = (id) => {
        router.get(`/user/hatchery/eightynInput/${id}`)
    };

    const twentyonedays = (id) => {
        router.get(`/user/hatchery/finalInput/${id}`)
    };
    const moveTo = (id) => {
        router.get(`/user/hatchery/move/${id}`)
    };

    const buttonClasses =
        'border border-black min-w-[120px] p-2 rounded-2xl bg-primary hover:bg-primary-dark text-primary-text-light mb-2';
</script>

<style>
    /* Tambahkan styling sesuai kebutuhan */
</style>
