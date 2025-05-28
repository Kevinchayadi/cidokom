<template>
    <div class="w-[80%]">
        <Headers tittle="Add Admin" />
        <form
            @submit.prevent="handleSubmit"
            class="max-h-[65vh] overflow-y-auto"
        >
        <InputFragment
                v-model="form.depreciation_die"
                name="depreciation_die"
                content="die"
                type="number"
                label="black"
                />
            <InputFragment
                v-model="form.depreciation_panen"
                name="depreciation_panen"
                content="harvest(sold)"
                type="number"
                label="black"
                />
            <InputFragment
                v-model="form.feed"
                name="feed"
                content="feed (in kilograms)"
                type="decimal"
                label="black"
                />
            <InputFragment
                v-model="form.feed_name"
                name="feed_name"
                content="Feed name"
                type="dropdown"
                :datas="pakanList"
                label="black"
                />

            <div class="w-full flex text-center justify-center">
                <FormButton
                    name="Submit"
                    custom="text-center w-[80%] py-4 mt-4"
                    :disabled="loading"
                />
            </div>
        </form>
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from "vue";
import { router } from "@inertiajs/vue3";
import Headers from "../../../components/Headers.vue";
import InputFragment from "../../../components/InputFragment.vue";
import FormButton from "../../../components/inputComponent/FormButton.vue";

const props = defineProps({
    data: {
        type: Object,
    },
});

// Form data model
const form = ref({
    id:null,
    depreciation_die: null,
    depreciation_panen: null,
    feed: null,
    feed_name: null,
});
const loading = ref(false);
const pakan = ref([]);
onMounted(async () => {
    try {
        const response = await axios.get("/admin/getpakan"); // Ganti URL sesuai endpoint kamu
        form.value = {
            id:props.data.id,
            depreciation_die: props.data.depreciation_die || 0,
            depreciation_panen: props.data.depreciation_panen || 0,
            feed: props.data.feed || 0,
            feed_name: props.data.feed_name || "",
        };
        pakan.value = response.data;
    } catch (error) {
        console.error("Gagal mengambil data pakan:", error);
    }
});

const pakanList = computed(() =>
    pakan.value.map((item) => ({
        id: item.nama_pakan,
        name: item.nama_pakan,
    }))
);

const handleSubmit = () => {

    loading.value = true;
    router.put("/admin/commercialadjustment", formData.value, {
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
    });
};
</script>

<style scoped></style>
