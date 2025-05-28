<template>
    <div class="w-[80%]">
        <Headers tittle="create Hatchery" />
        <form @submit.prevent="handleSubmit">
            
            <div>
                <div class="display flex gap-2">
                    <InputFragment
                    custom="my-0 mt-4"
                    v-model="start"
                    name="entryEgg"
                    content="Egg From(Date)"
                    type="date"
                    />
                    <InputFragment
                     custom="my-0 mt-4"
                    v-model="end"
                    name="endEgg"
                    content="Hatchery Date"
                    type="date"
                    />
                </div>
                <div class="display flex gap-2 my-0">
                    <InputFragment
                     custom="my-0 mt-4"
                        v-model="pen"
                        name="asal pen"
                        type="dropdown"
                        content="MAIN CAGE"
                        :datas="penList"
                    />
                    <InputFragment
                     custom="my-0 mt-4"
                        v-model="pen2"
                        name="another pen2"
                        type="dropdown"
                        content="other CAGE"
                        :datas="pen2List"
                    />
                </div>
                <p class="text-xs text-red-400 shadow-rose-600">If either cage is set to "All", eggs will automatically be taken from both the main and other cages!! </p>
                <div class="flex justify-center mt-2">
                    <button type="button" @click="handleGetEgg" class="px-4 border bg-blue-100 hover:bg-blue-200 rounded-full">GET EGG</button>
                </div>

            </div>


            <InputFragment
                v-model="hatcheryMachine"
                name="hatchery_machine"
                content="machine name"
                type="dropdown"
                :datas="machineList"
            />
            <InputFragment
                v-model="buyEgg"
                name="buyEgg"
                content="Buy Eggs"
                type="number"
            />
            <InputFragment
                v-model="price"
                name="price"
                content="Total Egg Price"
                type="number"
            />

            <Showdata
                v-model="totalSetting"
                name="total_setting"
                content="total setting"
                type="number"
                :value="totalSetting"
            />
            

            <input name="admin" value="active" type="text" hidden />

            <div class="w-full flex text-center justify-center">
                <FormButton
                    name="Submit"
                    custom=" text-center w-[80%] py-4 mt-4"
                    :disabled="totalSetting === 0 || loading"
                    
                    
                />
            </div>
        </form>
    </div>
</template>

<script setup>
import { computed, ref, watch } from "vue";
import { router } from "@inertiajs/vue3";

// Komponen-komponen yang diimpor
import InputFragment from "../../components/InputFragment.vue";
import FormButton from "../../components/inputComponent/FormButton.vue";
import Headers from "../../components/Headers.vue";
import Showdata from "../../components/showdata.vue";
import { useStore } from "vuex";

const props = defineProps({
    pen: {
        type: Array,
        default: () => [],
    },
    pen2: {
        type: Array,
        default: () => [],
    },
    machine: {
        type: Array,
        default: () => [],
    }
});

const store = useStore();

const penList = computed(() => [
  { id: 'ALL', name: 'ALL' },
  ...props.pen.map(item => ({
    id: item.indukan,
    name: `breeding cage ${item.indukan}`
  }))
]);

const pen2List = computed(() => [
    props.pen2.map(item => ({
    id: item.id_pen,
    name: `breeding cage ${item.id_pen}`
  }))
]);

const machineList = computed(() =>
  props.machine.map(item => ({
  id: item.id,
  name: item.machine_name
})));

const pen = ref("");
const pen2 = ref("");
const start = ref("");
const end = ref("");
const hatcheryMachine = ref("");
const currSetting = ref(0);
const anotherSetting = ref(0);
const buyEgg = ref(0);
const price = ref(0);
// const totalSetting = ref(0);

// watch(pen, async (newPenValue, oldPenValue) => {
//     if (newPenValue) {
//         try {
//             console.log(pen.value)
//             const response = await axios.get(`/user/getegg/${pen.value}`);
//             currSetting.value = response.data;
//             console.log("Selected data:", currSetting.value);
//         } catch (error) {
//             console.error("Error fetching data:", error);
//         }
//     } else {
//         // Reset totalSetting jika tidak ada pen yang dipilih
//         totalSetting.value = 0;
//     }
// });
// watch(pen2, async (newPenValue, oldPenValue) => {
//     if (newPenValue) {
//         try {
//             console.log(pen.value)
//             const response = await axios.get(`/user/anotheregg/${pen2.value}`);
//             anotherSetting.value = response.data;
//             console.log("Selected data:", totalSetting.value);
//         } catch (error) {
//             console.error("Error fetching data:", error);
//         }
//     } else {
//         // Reset totalSetting jika tidak ada pen yang dipilih
//         totalSetting.value = 0;
//     }
// });
const totalSetting = computed(() => {
  return currSetting.value + anotherSetting.value +buyEgg.value;
});


const loading = ref(false);

const handleSubmit = () => {
    loading.value = true;
    router.post(
    "/user/hatchery/create",
    {
        id_pen: pen.value,
        another_pen:pen2.value,
        start: start.value,
        end: end.value,
        id_machine: hatcheryMachine.value,
        total_setting: totalSetting.value,
        price: price.value,
        inputBy : store.getters.user.name
    },
    {
        onError: (errors) => {
            let errorMessage = "";
            if (errors.error) {
                alert(errors.error);
            }
            Object.values(errors).forEach((errorArray) => {
                if (Array.isArray(errorArray)) {
                    errorMessage += errorArray.join("\n") + "\n"; // Gabungkan jika array
                } else {
                    errorMessage += String(errorArray) + "\n"; // Konversi ke string jika bukan array
                }
            });
            alert(errorMessage); 
            loading.value = false;
        }, 
            onSuccess: () => {
            loading.value = false; 
        },
    }
);

};

const handleGetEgg = async () => {
    try {
        loading.value = true;
        // console.log(`id_pen:${pen.value}`)
        const response = await axios.post(`/user/getegg`,{
            id_pen: pen.value,
            another_pen:pen2.value,
            start: start.value,
            end: end.value
        });
        currSetting.value = response.data;
        console.log("GET EGG clicked, data:", currSetting.value);
    } catch (error) {
        console.error("Error in GET EGG:", error);
    } finally {
        loading.value = false;
    }
};
</script>

<style></style>
