<template>
    <div class="w-[80%]">
        <Headers tittle="Create Breeding" />
        <form @submit.prevent="handleSubmit">
            <InputFragment v-model="pen" name="pen" type="dropdown" :datas="penList" />
            <InputFragment
                v-model="ayamJantan"
                name="ayamJantan"
                content="male Chicken"
                type="dropdown"
                :datas="ayamList"
            />
            <InputFragment
                v-model="ayamBetina"
                name="ayamBetina"
                content="Female Chicken"
                type="dropdown"
                :datas="ayamList"
            />
            <InputFragment
                v-model="qtyJantan"
                name="qtyJantan"
                content="quantity male chicken"
                type="number"
            />
            <InputFragment
                v-model="qtyBetina"
                name="qtyBetina"
                content="quantity female chicken"
                type="number"
            />
            <InputFragment
                v-model="umur"
                name="umur"
                content="age (in days)"
                type="number"
            />
            <InputFragment
                v-model="cost"
                name="cost"
                content="price (fill with 0, if its from our chick in)"
                type="number"
            />
            <!-- <InputFragment
                v-model="vaksin"
                name="vaksin"
                type="multiple"
                :datas="vaksinList"
            /> -->
            <input value="active" type="text" hidden />

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
import { router } from "@inertiajs/vue3";

import InputFragment from "../../components/InputFragment.vue";
import FormButton from "../../components/inputComponent/FormButton.vue";
import Headers from "../../components/Headers.vue";
import { computed, onMounted, ref } from "vue";
import { mapGetters, useStore } from 'vuex';

const props = defineProps({
    pen: {
        type: Array,
    },
    ayam: {
        type: Array,
    },
    auth: {
        type: Object,
    },
});

const vaksinList = computed(() => [
    { id: 1, name: "Vaccine A" },
    { id: 2, name: "Vaccine B" },
    { id: 3, name: "Vaccine C" }
]);

const penList = computed(() =>
  props.pen.map(item => ({
  id: item.id,
  name: `(${item.kandang.nama_kandang}) ${item.code_pen}`
})));

const store = useStore();

const ayamList = computed(() =>
  props.ayam.map(item => ({
  id: item.code_Ayam,
  name: item.code_Ayam
})));

const pen = ref("");
const ayamJantan = ref("");
const ayamBetina = ref("");
const qtyJantan = ref(0);
const qtyBetina = ref(0);
const umur = ref(0);
const cost = ref(0);
const vaksin = ref([]);

const handleSubmit = () => {
    
    router.post("/user/breeding/create", {
        id_pen: pen.value,
        code_ayam_jantan: ayamJantan.value,
        code_ayam_betina: ayamBetina.value,
        jumlah_jantan: qtyJantan.value,
        jumlah_betina: qtyBetina.value,
        age: umur.value,
        cost_Total_induk: cost.value,
        vaksin: vaksin.value,
        inputBy : store.getters.user.name
    },{
        onError: (errors) => {
            const errorMessages = Object.values(errors).flat(); 
            alert(errorMessages.join('\n'));
        }
    });
};
</script>
<style></style>
