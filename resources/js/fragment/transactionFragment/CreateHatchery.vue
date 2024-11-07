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
                :datas="hatcheryMachineOptions"
            />

            <InputFragment
                v-model="totalSetting"
                name="total_setting"
                content="total setting"
                type="number"
            />
            

            <input name="admin" value="active" type="text" hidden />

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
import { computed, ref } from "vue";
import { router } from "@inertiajs/vue3";

// Komponen-komponen yang diimpor
import InputFragment from "../../components/InputFragment.vue";
import FormButton from "../../components/inputComponent/FormButton.vue";
import Headers from "../../components/Headers.vue";

const props = defineProps({
    pen: {
        type: Array,
        default: () => [],
    },
});

const penList = computed(() =>
  props.pen.map(item => ({
  id: item.id,
  name: `(${item.kandang.nama_kandang}) ${item.code_pen}`
})));
const pen = ref("");
const hatcheryMachine = ref("");
const totalSetting = ref(0);

const hatcheryMachineOptions = ref([
    {
        id: "Machine 1",
        name: "Machine 1",
    },
    {
        id: "Machine 2",
        name: "Machine 2",
    },
    {
        id: "Machine 3",
        name: "Machine 3",
    },
]);

const handleSubmit = () => {
    router.post(
    "/user/hatchery/create",
    {
        id_pen: pen.value,
        id_machine: hatcheryMachine.value,
        total_setting: totalSetting.value,
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
