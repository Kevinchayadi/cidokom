<template>
    <div class="w-[80%]">
        <Headers tittle="hari ke-21" />
        <form @submit.prevent="handleSubmit">
            <InputFragment
                v-model="deadInEgg"
                name="dead_in_egg"
                content="mati dalam telur"
                type="number"
            /><Showdata
                name="hatchability"
                content="sisa telur"
                type="number"
                :value="hatchability"
            />
            <InputFragment
                v-model="doc_afkir"
                name="doc_afkir"
                content="Doc afkir"
                type="number"
            />
            <Showdata
                name="saleable"
                content="siap Jual"
                type="number"
                :value="saleable"
            />
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
import {  computed, ref, watch } from "vue";
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
const id_hatchery = ref(props.hatcheryDetail.id_hatchery)
const doc_afkir = ref(0);

const deadInEgg = ref(0);

const hatchability = computed(() => {
  return props.hatcheryDetail.hatcher - deadInEgg.value ;
});
const saleable = computed(() => {
  return hatchability.value - doc_afkir.value;
});

const handleSubmit = () => {
    router.post("/user/hatchery/finalInput", {
        id_hatchery:id_hatchery.value,
        dead_in_egg: deadInEgg.value,
        hatchability: hatchability.value,
        doc_afkir: doc_afkir.value,
        saleable: saleable.value,
    });
};
</script>

<style></style>
