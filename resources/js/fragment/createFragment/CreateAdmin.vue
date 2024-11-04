<template>
    <div class="w-[80%]">
        <Headers tittle="Add Admin" />
        <form @submit.prevent="handleSubmit">
            <InputFragment
                name="namaAdmin"
                content="Nama Admin"
                type="string"
            />
            <InputFragment name="username" type="string" />
            <InputFragment name="password" type="string" />

            <div class="w-full flex text-center justify-center">
                <FormButton
                    name="Submit"
                    custom=" text-center w-[80%] py-4 mt-4"
                />
            </div>
        </form>
    </div>
</template>
<script setup>
import { Inertia } from "@inertiajs/inertia";

import InputFragment from "../../components/InputFragment.vue";
    import FormButton from "../../components/inputComponent/FormButton.vue";
    import Headers from "../../components/Headers.vue";

const handleSubmit = () => {
    Inertia.post("/", {

    });
};
</script>
<style></style>
