<template>
    <div class="w-[80%]">
        <Headers tittle="Breeding daily report" />
        <form @submit.prevent="handleSubmit">
            <InputFragment
                v-model="femaleDie"
                name="femaleDie"
                content="female die"
                type="number"
            />
            <InputFragment
                v-model="femaleReject"
                name="femaleReject"
                content="female reject"
                type="number"
            />
            <InputFragment
                v-model="maleDie"
                name="maleDie"
                content="male die"
                type="number"
            />
            <InputFragment
                v-model="maleReject"
                name="maleReject"
                content="male reject"
                type="number"
            />
            <InputFragment
                v-model="move"
                name="move"
                content="Move to"
                type="dropdown"
                :datas="penList"
            />
            <InputFragment
                v-model="maleMove"
                name="maleMove"
                content="male move"
                type="number"
            />
            <InputFragment
                v-model="femaleMove"
                name="femaleMove"
                content="female move"
                type="number"
            />
            <InputFragment
                v-model="eggMorning"
                name="eggMorning"
                content="morning egg"
                type="number"
            />
            <InputFragment
                v-model="eggAfternoon"
                name="eggAfternoon"
                content="afternoon egg"
                type="number"
            />
            <InputFragment
                v-model="broken"
                name="broken"
                content="broken egg"
                type="number"
            />
            <InputFragment
                v-model="abnormal"
                name="abnormal"
                content="abnormal egg"
                type="number"
            />
            <InputFragment
                v-model="sale"
                name="sale"
                content="sale egg"
                type="number"
            />
            <InputFragment
                v-model="feed"
                name="feed"
                content="total feed(in Kilograms)"
                type="number"
            />
            <InputFragment
                v-model="feedName"
                name="feedName"
                content="Feed name"
                type="dropdown"
                :datas="pakanList"
            />

            <input name="admin" type="hidden" value="admin_name" />

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
import { computed, onMounted, ref } from "vue";
import { router } from "@inertiajs/vue3";

import InputFragment from "../../components/InputFragment.vue";
import FormButton from "../../components/inputComponent/FormButton.vue";
import Headers from "../../components/Headers.vue";
import { useStore } from "vuex";

// Define the state for each input
const props = defineProps({
    id_breeding: {
        type: String,
        required: true
    },
    pakan:{
        type: Array,
        required: true
    },
    pen: {
        type: Array,
    },
})
const pakanList = computed(() =>
  props.pakan.map(item => ({
  id: item.nama_pakan,
  name: item.nama_pakan
})));
const penList = computed(() =>
  props.pen.map(item => ({
  id: item.id,
  name: `(${item.kandang.nama_kandang}) ${item.code_pen}`
})));
const store = useStore();

const femaleDie = ref(0);
const femaleReject = ref(0);
const maleDie = ref(0);
const move = ref(0);
const maleReject = ref(0);
const maleMove = ref(0);
const femaleMove = ref(0);
const eggMorning = ref(0);
const eggAfternoon = ref(0);
const broken = ref(0);
const abnormal = ref(0);
const sale = ref(0)
const feed = ref(0);
const feedName = ref('');
const total_egg = computed(() => {
  return eggMorning.value + eggAfternoon.value - broken.value - abnormal.value - sale.value;
});
// Handle form submission
const handleSubmit = () => {
    router.post("/user/breeding/input", {
        id_breeding: props.id_breeding,
        female_die: femaleDie.value,
        female_reject: femaleReject.value,
        male_die: maleDie.value,
        male_reject: maleReject.value,
        egg_morning: eggMorning.value,
        egg_afternoon: eggAfternoon.value,
        broken: broken.value,
        abnormal: abnormal.value,
        sale: sale.value,
        total_egg: total_egg.value,
        move_to: move.value,
        total_female_move: femaleMove.value,
        total_male_move: maleMove.value,
        feed: feed.value,
        feed_name: feedName.value,
        inputBy: store.getters.user.name
 
    }).then(response => {
        // Jika berhasil, Anda bisa menangani respons sukses di sini
        console.log("Data berhasil dikirim:", response);
        alert("Data berhasil dikirim!");
    })
    .catch(error => {
        // Jika ada error, tampilkan alert
        if (error.response && error.response.data.error) {
            alert(error.response.data.error); // Menampilkan error yang diterima dari server
        } else {
            alert("Terjadi kesalahan saat mengirim data. Silakan coba lagi."); // Menangani error umum
        }
    });
};
</script>

<style></style>
