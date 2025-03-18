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
                :value="entry_population"
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
                    :disabled="loading"
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
import { computed, onMounted, ref, watch } from "vue";
import { useStore } from "vuex";
import Showdata from "../../components/showdata.vue";

const props = defineProps({
    hatchery:{
        type: Array,
        default: () => ({})
    },
    id:{
        type:String
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
// const useStore = useStore();

const id_pen = ref("");
const entryDate = ref("");
const entry_population = ref( null);
const umur = ref(0);
const status = ref("active");

onMounted(() => {
  // Pastikan bahwa props.hatchery.hatchery_details memiliki data sebelum mengaksesnya
  if (props.hatchery.hatchery_details && props.hatchery.hatchery_details.length > 0) {
    // console.log
    entry_population.value = props.hatchery.hatchery_details[0].saleable;
  }
});
const loading = ref(false);
const handleSubmit = () => {
    loading.value = true;
    router.post(`/user/commercial/moved/${props.id}`, {
        id_pen: id_pen.value,
        entryDate: entryDate.value,
        entry_population: entry_population.value,
        age: umur.value,
        inputBy : store.getters.user.name
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
// watch(id_pen, (newVal, oldVal) => {
//   if (newVal !== oldVal) {
//     console.log("entry_population berubah:", newVal);
//   }
// });
</script>
<style></style>
