<template>
    <div class="w-[80%]">
        <Headers tittle="Commerce daily report" />
        <form @submit.prevent="handleSubmit">
            <InputFragment
                v-model="depreciation_die"
                name="depreciation_die"
                content="ayam yang mati"
                type="number"
            />
            <InputFragment
                v-model="depreciation_afkir"
                name="depreciation_afkir"
                content="ayam yang afkir"
                type="number"
            />
            <InputFragment
                v-model="depreciation_panen"
                name="depreciation_panen"
                content="ayam yang keluar/panen"
                type="number"
            />
            <InputFragment
                v-model="feed"
                name="feed"
                content="jumlah makan"
                type="number"
            />
            <InputFragment
                v-model="feed_name"
                name="feed_name"
                content="nama pakan"
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

const props = defineProps({
    id_commercial: {
        type: String,
        required: true,
    },
    feed: {
        type: Array,
        required: true,
    },
});

const FeedList = computed(() =>
    props.feed.map(item => ({
        id: item.id,
        name: item.nama_pakan
    }))
);
// Define the state for each input
const id_commercial = ref(props.id_commercial);
const depreciation_die = ref(0);
const depreciation_afkir = ref(0);
const depreciation_panen = ref(0);
const feed = ref(0);
const feed_name = ref('GF-11');

// Handle form submission
const handleSubmit = () => {
    router.post("/user/commercial/input", {
        id_commercial: id_commercial.value,
        depreciation_die: depreciation_die.value,
        depreciation_afkir: depreciation_afkir.value,
        depreciation_panen: depreciation_panen.value,
        feed: feed.value,
        feed_name: feed_name.value,
    });
};
</script>

<style></style>
