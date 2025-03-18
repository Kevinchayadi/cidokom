<template>
    <div class="w-[80%]">
        <Headers tittle="Hari ke-18 ( Candling )" />
        <form @submit.prevent="handleSubmit">
            
            <InputFragment
                v-model="infertile"
                name="infertile"
                content="infertile"
                type="number"
            />
            <InputFragment
                v-model="explode"
                name="explode"
                content="explode"
                type="number"
            />
            <Showdata
                name="hatcher"
                content="Hatcher"
                type="number"
                :value="hatcher"
            />

            <div class="w-full flex text-center justify-center">
                <FormButton
                    name="Submit"
                    custom=" text-center w-[80%] py-4 mt-4"
                    :disabled="loading"
                />
            </div>
        </form>
    </div>
</template>

<script setup>
import { computed, ref, watch } from "vue";
import { router } from "@inertiajs/vue3";

import InputFragment from "../../components/InputFragment.vue";
import FormButton from "../../components/inputComponent/FormButton.vue";
import Headers from "../../components/Headers.vue";
import Showdata from "../../components/showdata.vue";

const props = defineProps({
    hatcheryDetail:{
        type: Object,
        required: true,
    }
})
const id_hatchery = ref(props.hatcheryDetail.id_hatchery);
const infertile = ref("");
const explode = ref("");

const hatcher = computed(() => {
  return props.hatcheryDetail.total_setting - infertile.value - explode.value;
});
const loading = ref(false);
const handleSubmit = () => {
    loading.value = true;
    router.post("/user/hatchery/eightynInput", {
        id_hatchery: id_hatchery.value,
        infertile: infertile.value,
        explode: explode.value,
        hatcher: hatcher.value,
    }, {
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

<style></style>
