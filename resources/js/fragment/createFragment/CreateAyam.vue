<template>
    <div class="w-[80%]">
        <Headers tittle="Buat Ayam" />
        <form @submit.prevent="handleSubmit">
            <InputFragment v-model="form.code_ayam" name="code_ayam" content="Kode Ayam" type="text" />

            <InputFragment v-model="form.strain_male" name="strain_male" content="Induk Jantan" type="dropdown" :datas="ayamlist" />

            <InputFragment v-model="form.strain_female" name="strain_female" content="Induk Betina" type="dropdown" :datas="ayamlist" />

            <div class="w-full flex text-center justify-center">
                <FormButton name="Submit" custom="text-center w-[80%] py-4 mt-4" />
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
        ref
    } from "vue";

    const props = defineProps({
        ayam: {
            type: Array,
            required: true,
        }
    });
    const ayamlist = computed(() =>
  props.ayam.map(item => ({
    id: item.code_Ayam,
    name: item.code_Ayam
  }))
);

    const form = ref({
        code_ayam: '',
        strain_male: '',
        strain_female: ''
    });
    const handleSubmit = () => {
        router.post('/user/ayam/create', form.value);
    };
</script>
<style></style>
