<template>
    <div class="w-[80%]">
        <Headers tittle="Create New Machine" />
        <form @submit.prevent="handleSubmit">
            <InputFragment v-model="form.machine_name" name="machine_name" content="code machine" type="text" />
            <InputFragment v-model="form.kapasitas" name="kapasitas" content="machine capacity" type="number" />
            <!-- <InputFragment v-model="form.jenis_kandang" content="Jenis kandang" type="dropdown" :datas="jenisKandang" /> -->

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
import { ref } from "vue";

    const jenisKandang = [
    { id: "breeding", name: "breeding" },
    { id: "commerce", name: "commercial" },
    { id: "afkir", name: "afkir" },
];  
    const form = ref({
        machine_name: '',
        kapasitas:0,
        // jenis_kandang: ''
    })

    const handleSubmit = () => {
        router.post("/user/machine/create", form.value);
    };
</script>
<style></style>
