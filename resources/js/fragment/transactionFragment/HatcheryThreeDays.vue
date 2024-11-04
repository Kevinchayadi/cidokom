<template>
    <div class="w-[80%]">
        <Headers tittle="hari ke-3" />
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
                content="pecah"
                type="number"
            />
            <Showdata
                name="hatchability"
                content="sisa telur"
                type="number"
                :value="hatcher"
            />
            <input name="admin" type="string" value="active" hidden />

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

const handleSubmit = () => {
    router.post("/user/hatchery/threeInput", {
        id_hatchery: id_hatchery.value,
        infertile: infertile.value,
        explode: explode.value,
        hatcher: hatcher.value,
    });
};
</script>

<style></style>
