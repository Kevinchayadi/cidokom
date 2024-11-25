<template>
    <div class="w-[80%]">
        <Headers tittle="Commerce daily report" />
        <form @submit.prevent="handleSubmit">
            <InputFragment
                v-model="depreciation_die"
                name="depreciation_die"
                content="die"
                type="number"
            />
            <InputFragment
                v-model="depreciation_afkir"
                name="depreciation_afkir"
                content="afkir"
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
                type="number"
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
        default:()=>[]
    },
});
const store = useStore();

const FeedList = computed(() =>
    props.feed.map(item => ({
        id: item.id,
        name: item.nama_pakan
    }))
);
const penList = computed(() =>
  props.pen.map(item => ({
  id: item.id,
  name: `(${item.kandang.nama_kandang}) ${item.code_pen}`
})));

// Define the state for each input
const id_commercial = ref(props.id_commercial);
const depreciation_die = ref(0);
const depreciation_afkir = ref(0);
const depreciation_panen = ref(0);
const move = ref(0);
const femaleMove = ref(0);
const maleMove = ref(0);
const feed = ref(0);
const feed_name = ref('');

// Handle form submission
const handleSubmit = () => {
    router.post("/user/commercial/input", {
        id_commercial: id_commercial.value,
        depreciation_die: depreciation_die.value,
        depreciation_afkir: depreciation_afkir.value,
        depreciation_panen: depreciation_panen.value,
        move_to: move.value,
        total_female_move: femaleMove.value,
        total_male_move: maleMove.value,
        feed: feed.value,
        feed_name: feed_name.value,
        inputBy : store.getters.user.name
    });
};
</script>

<style></style>
