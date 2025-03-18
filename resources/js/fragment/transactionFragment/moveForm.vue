<template>
    <div class="w-[80%]">
        <Headers tittle="Moving Cage" />
        <form @submit.prevent="handleSubmit">
            <InputFragment v-model="formData.move_to" name="pen" type="dropdown" :datas="penList" />
            <InputFragment v-model="formData.total_male_move" name="male"
                content="male chicken" type="number" />
            <InputFragment v-model="formData.total_female_move" name="female"
                content="female chicken" type="number" />

            <div class="w-full flex text-center justify-center">
                <FormButton name="Submit" custom=" text-center w-[80%] py-4 mt-4" :disabled="loading"/>
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



    const penList = computed(() =>
        props.pen.map(item => ({
            id: item.id,
            name: `${item.code_pen}`
        })));

    const store = useStore();

    // const ayamList = computed(() =>
    //   props.ayam.map(item => ({
    //   id: item.code_Ayam,
    //   name: item.code_Ayam
    // })));

    const formData = ref({
        move_to: '',
        total_female_move: '',
        total_male_move: '',
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
