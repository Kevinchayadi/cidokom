<template>
    <div class="w-[80%]">
        <Headers tittle="Add Pakan" />
        <form @submit.prevent="handleSubmit">
            <InputFragment name="namaPakan" content="nama pakan" type="dropDown" data="" />
            <InputFragment name="qty" content="quantity" type="number" />
            <InputFragment name="Harga" type="number" />

            <div class="w-full flex text-center justify-center">
                <FormButton name="LOGIN" custom=" text-center w-[80%] py-4 mt-4" />
            </div>
        </form>
    </div>
</template>
<script setup>
    import {
        Inertia
    } from "@inertiajs/inertia";

    import InputFragment from "../../components/InputFragment.vue";
    import FormButton from "../../components/inputComponent/FormButton.vue";
    import Headers from "../../components/Headers.vue";

    const handleSubmit = () => {
        Inertia.post("/", {

        });
    };
</script>
<style></style>
