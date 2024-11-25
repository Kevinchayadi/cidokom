<template>
    <div class="w-[80%]">
        <Headers tittle="Move to Commercial" />
        <form @submit.prevent="handleSubmit">
            <InputFragment
                v-model="id_pen"
                name="id_pen"
                content="code pen"
                type="dropdown"
                :datas="penList"
            />
            <InputFragment
                v-model="entryDate"
                name="entryDate"
                content="date move"
                type="date"
            />
            <Showdata
                name="entry_population"
                content="total population"
                type="number"
                :value="harchability"
            />
            <show
                v-model="hatchery.saleable"
                name="entry_population"
                content="total population"
                type="number"
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
import { router } from "@inertiajs/vue3";

import InputFragment from "../../components/InputFragment.vue";
import FormButton from "../../components/inputComponent/FormButton.vue";
import Headers from "../../components/Headers.vue";
import { computed, ref } from "vue";
import { useStore } from "vuex";
import Showdata from "../../components/showdata.vue";

const props = defineProps({
    hatchery:{
        type: Object,
        default: () => ({})
    },
    pen: {
        type: Array,
        default: []
    }
});
const store = useStore();

const penList = computed(() =>
  props.pen.map(item => ({
  id: item.id,
  name: `(${item.kandang.nama_kandang}) ${item.code_pen}`
})));

const id_pen = ref("");
const entryDate = ref("");
const entry_population = ref(props.hatchery.saleable);
const umur = ref(0);
const status = ref("active");

const handleSubmit = () => {
    router.post("/user/commercial/moved", {
        id_pen: id_pen.value,
        entryDate: entryDate.value,
        entry_population: entry_population.value,
        age: umur.value,
        inputBy : store.getters.user.name
    });
};
</script>
<style></style>
