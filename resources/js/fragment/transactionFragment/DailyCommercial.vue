<template>
    <div class="w-[80%]">
        <Headers :tittle="`Commerce daily (${name})`" />
        <div class="flex w-full justify-around my-5 lg:text-xl text-lg">
            <h2 class=" text-yellow-300 font-bold">Chicken : {{ chicken.total }} Pcs</h2>

        </div>
        <form @submit.prevent="handleSubmit">
            <div v-if="store.getters.user.role_id == 6">
                <InputFragment
                    v-model="date"
                    name="date"
                    content="changes date (default Today)"
                    type="dropdown"
                    
                    :datas="dateList"
                />
            </div>
            <InputFragment
                v-model="depreciation_die"
                name="depreciation_die"
                content="die"
                type="number"
            />
            <InputFragment
                v-model="depreciation_panen"
                name="depreciation_panen"
                content="harvest(sold)"
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
                v-model="feed"
                name="feed"
                content="feed (in kilograms)"
                type="decimal"
            />
            <InputFragment
                v-model="feed_name"
                name="feed_name"
                content="Feed name"
                type="dropdown"
                :datas="FeedList"
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
import { computed, ref } from "vue";
import { router } from "@inertiajs/vue3";

import InputFragment from "../../components/InputFragment.vue";
import FormButton from "../../components/inputComponent/FormButton.vue";
import Headers from "../../components/Headers.vue";
import { useStore } from "vuex";

const props = defineProps({
    id_commercial: {
        type: String,
        required: true,
    },
    feed: {
        type: Array,
        required: true,
    },
    pen: {
        type: Array,
        default: () => [],
    },
    name:{
        type:String
    },
    chicken:{
        type:Array
    }
});
const store = useStore();

const FeedList = computed(() =>
    props.feed.map((item) => ({
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

// Define the state for each input
const id_commercial = ref(props.id_commercial);
const date = ref(null);
const depreciation_die = ref(0);
const depreciation_afkir = ref(0);
const depreciation_panen = ref(0);
const move = ref(0);
const femaleMove = ref(0);
const maleMove = ref(0);
const feed = ref(0);
const feed_name = ref("");
const loading = ref(false);

const dateList = ref([]);
const today = new Date()
const monthNames = [
  'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
  'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
]
for (let i = 0; i < 3; i++) {
  const d = new Date(today)
  d.setDate(d.getDate() - i)

  const year = d.getFullYear()
  const month = String(d.getMonth() + 1).padStart(2, '0')
  const day = String(d.getDate()).padStart(2, '0')

  const fullDate = `${year}-${month}-${day}`
  const readableDate = `${day} ${monthNames[d.getMonth()]}`

  dateList.value.push({
    id: fullDate,
    name: readableDate
  })
}

// Handle form submission
const handleSubmit = () => {
    loading.value = true;
    router.post("/user/commercial/input", {
        date: date.value,
        id_commercial: id_commercial.value,
            depreciation_die: depreciation_die.value,
            depreciation_afkir: depreciation_afkir.value,
            depreciation_panen: depreciation_panen.value,
            move_to: move.value,
            total_female_move: femaleMove.value,
            total_male_move: maleMove.value,
            feed: feed.value,
            feed_name: feed_name.value,
            inputBy: store.getters.user.name,
     
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
</script>

<style></style>
