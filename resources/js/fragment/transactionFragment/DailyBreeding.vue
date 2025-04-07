<template>
    <div class="w-[80%]">
        <Headers :tittle="`Breeding Daily (${props.name})`" />
        <div class="flex w-full justify-around my-5 lg:text-xl text-lg">
            <h2 class=" text-yellow-300 font-bold">Male Chicken : {{ chicken.male }} Pcs</h2>
            <h2 class=" text-yellow-300 font-bold" >Female Chicken : {{ chicken.female }} Pcs</h2>

        </div>
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
                content="female sale"
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
                content="male sale"
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
                type="decimal"
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
                    :disabled="loading"
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
        required: true,
    },
    pakan: {
        type: Array,
        required: true,
    },
    pen: {
        type: Array,
    },
    name: {
        type: String,
    },
    chicken:{
        type: Array,
    }
});
const pakanList = computed(() =>
    props.pakan.map((item) => ({
        id: item.nama_pakan,
        name: item.nama_pakan,
    }))
);
const penList = computed(() =>
    props.pen.map((item) => ({
        id: item.id,
        name: `(${item.kandang.nama_kandang}) ${item.code_pen}`,
    }))
);
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
const sale = ref(0);
const feed = ref(0);
const feedName = ref("");
const total_egg = computed(() => {
    return (
        eggMorning.value +
        eggAfternoon.value -
        broken.value -
        abnormal.value -
        sale.value
    );
});
const loading = ref(false);
// Handle form submission
const handleSubmit = () => {
    if (total_egg.value < 0) {
        alert(
            "Total broken, abnormal and sale egg is bigger than current total!!"
        );
        return;
    } else {
        loading.value = true;

        router.post(
            "/user/breeding/input",
            {
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
                inputBy: store.getters.user.name,
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
    }
};
</script>

<style></style>
