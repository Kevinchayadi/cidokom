<template>
    <div class="w-[80%]">
        <Headers tittle="Add Feed" />
        <form @submit.prevent="handleSubmit" class=" max-h-[65vh] overflow-y-auto">
            <InputFragment
                v-model="formData.qty"
                name="qty"
                content="qty (in kilograms)"
                type="decimal"
                label="black"
            />
            <InputFragment
                v-model="formData.harga"
                name="harga"
                content="total(price)"
                type="decimal"
                label="black"
            />

            <div class="w-full flex text-center justify-center">
                <FormButton
                    name="Submit"
                    custom="text-center w-[80%] py-4 mt-4"
                    :disabled="loading"
                />
            </div>
        </form>
    </div>
</template>

<script setup>
import {
    computed,
    onMounted,
    ref
} from "vue";
import {
    router
} from "@inertiajs/vue3";
import InputFragment from "../../components/InputFragment.vue";
import FormButton from "../../components/inputComponent/FormButton.vue";
import Headers from "../../components/Headers.vue";
const loading = ref(false);
// Form data model
const formData = ref({
    qty: '',
    harga: '', // Corrected field name
});
const props = defineProps({
    id:{
        type: Number,
    }
})

// onMounted(() => {
//   console.log(props.id)
// });

const handleSubmit = () => {

    // if (formData.value.harga !== formData.value.harga_confirmation) {
    //     alert('hargas do not match!');
    //     return;
    // }

    loading.value = true;
    router.put(`/admin/addPakan/${props.id}`, formData.value, {
        onError: (errors) => {
            let errorMessage = "";
            if (errors.error) {
                alert(errors.error);
            }
            Object.values(errors).forEach((errorArray) => {
                if (Array.isArray(errorArray)) {
                    errorMessage += errorArray.join("\n") + "\n"; // Gabungkan jika array
                } else {
                    errorMessage += String(errorArray) +
                    "\n"; // Konversi ke string jika bukan array
                }
            });
            alert(errorMessage);
            loading.value = false; 

        }, 
            onSuccess: () => {
            loading.value = false; 
        },
    });
};
</script>

<style scoped></style>
