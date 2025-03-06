<template>
    <div class="w-[80%]">
        <Headers tittle="Create Breeding" />
        <form @submit.prevent="handleSubmit">
            <InputFragment v-model="formData.id_vaksin" name="vaksin" type="dropdown" :datas="vaksinList" />
            <InputFragment v-model="formData.qty" name="qty"
                content="qty (fill in ML or DS for one chicken, if its had been done fill with 0!)" type="decimal" />
            <!-- <InputFragment
                v-model="vaksin"
                name="vaksin"
                type="multiple"
                :datas="vaksinList"
            /> -->
            <input value="active" type="text" hidden />

            <div class="w-full flex text-center justify-center">
                <FormButton name="Submit" custom=" text-center w-[80%] py-4 mt-4" />
            </div>
        </form>
    </div>
</template>
<script setup>
    import {
        router
    } from "@inertiajs/vue3";

    import InputFragment from "../../components/InputFragment.vue";
    import FormButton from "../../components/inputComponent/FormButton.vue";
    import Headers from "../../components/Headers.vue";
    import {
        computed,
        onMounted,
        ref
    } from "vue";
    import {
        mapGetters,
        useStore
    } from 'vuex';

    const props = defineProps({
        id: {
            type: String,
        },
        vaksin: {
            type: Array,
        },
        pen: {
            type: String,
        },
    });



    const vaksinList = computed(() =>
        props.vaksin.map(item => ({
            id: item.id,
            name: `${item.nama} (${item.hari} days)`
        })));

    const store = useStore();

    // const ayamList = computed(() =>
    //   props.ayam.map(item => ({
    //   id: item.code_Ayam,
    //   name: item.code_Ayam
    // })));

    const formData = ref({
        id_vaksin: '',
        qty: '',
    });
    
    const emit = defineEmits();

    const handleSubmit = () => {
        // Emit the form data to the parent component for processing
        emit('submitForm', formData.value);
    };

    // const handleSubmit = () => {
    //     console.log(props.pen);
    //     if(pen=='breeding'){
    //         router.post(`/user/breeding/vaccine/${props.id}`, formData.value,{
    //             onError: (errors) => {
    //                 const errorMessages = Object.values(errors).flat(); 
    //                 alert(errorMessages.join('\n'));
    //             }
    //         });
    //     }
    //     if(pen=='breeding'){
    //         router.post(`/user/commercial/vaccine/${props.id}`, formData.value,{
    //             onError: (errors) => {
    //                 const errorMessages = Object.values(errors).flat(); 
    //                 alert(errorMessages.join('\n'));
    //             }
    //         });
    //     }
    // };
</script>
<style></style>
