<template>
    <div class="w-[80%]">
        <Headers tittle="Login" />
        <form @submit.prevent="handleSubmit">
            <InputFragment
                v-model="form.username"
                name="username"
                type="text"
                placeholder="example"
            />
            <InputFragment
                v-model="form.password"
                name="password"
                type="password"
                placeholder="*********"
            />
            <Checkbox
                v-model="form.remember"
                text="remember me"
                name="remember"
            />
            <div class="w-full flex text-center justify-center">
                <FormButton
                    name="LOGIN"
                    custom="text-center w-[80%] py-4 mt-4"
                />
            </div>
        </form>
    </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import InputFragment from "../components/InputFragment.vue";
import FormButton from "../components/inputComponent/FormButton.vue";
import Checkbox from "../components/inputComponent/Checkbox.vue";
import Headers from "../components/Headers.vue";


const form = useForm({
    username: '',
    password: '',
    remember: false
});

const handleSubmit = () => {
    form.post("/login",{
        onError: (errors) => {
            if (errors.error) {
                alert(errors.error);
            }
        }
    });
};
</script>

<style></style>
