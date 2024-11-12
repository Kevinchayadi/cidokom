<template>
    <div class="w-[80%]">
        <Headers tittle="create Hatchery" />
        <form @submit.prevent="handleSubmit">
            <InputFragment
                v-model="pen"
                name="asal pen"
                type="dropdown"
                content="code pen"
                :datas="penList"
            />

            <InputFragment
                v-model="hatcheryMachine"
                name="hatchery_machine"
                content="machine name"
                type="dropdown"
                :datas="machineList"
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
                    :disabled="totalSetting === 0"
                    
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
    machine: {
        type: Array,
        default: () => [],
    }
});

const store = useStore();

const penList = computed(() =>
  props.pen.map(item => ({
  id: item.id,
  name: `(${item.kandang.nama_kandang}) ${item.code_pen}`
})));

const machineList = computed(() =>
  props.machine.map(item => ({
  id: item.id,
  name: item.machine_name
})));

const pen = ref("");
const hatcheryMachine = ref("");
const totalSetting = ref(0);

watch(pen, async (newPenValue, oldPenValue) => {
    if (newPenValue) {
        try {
            console.log(pen.value)
            const response = await axios.get(`/user/getegg/${pen.value}`);
            totalSetting.value = response.data;
            console.log("Selected data:", totalSetting.value);
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    } else {
        // Reset totalSetting jika tidak ada pen yang dipilih
        totalSetting.value = 0;
    }
});



const handleSubmit = () => {
    router.post(
    "/user/hatchery/create",
    {
        id_pen: pen.value,
        id_machine: hatcheryMachine.value,
        total_setting: totalSetting.value,
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
        }
    }
);

};
</script>

<style></style>
