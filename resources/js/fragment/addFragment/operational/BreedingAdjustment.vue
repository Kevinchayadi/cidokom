<template>
    <div class="w-[80%]">
        <Headers tittle="Add Admin" />
        <form
            @submit.prevent="handleSubmit"
            class="max-h-[65vh] overflow-y-auto"
        >
            <InputFragment
                v-model="form.female_die"
                name="femaleDie"
                content="female die"
                type="number"
                label="black"
                />
            <InputFragment
                v-model="form.female_reject"
                name="femaleReject"
                content="female sale"
                type="number"
                label="black"
                />
            <InputFragment
                v-model="form.male_die"
                name="maleDie"
                content="male die"
                type="number"
                label="black"
                />
            <InputFragment
                v-model="form.male_reject"
                name="maleReject"
                content="male sale"
                type="number"
                label="black"
                />
            <InputFragment
                v-model="form.egg_morning"
                name="eggMorning"
                content="morning egg"
                type="number"
                label="black"
                />
            <InputFragment
                v-model="form.egg_afternoon"
                name="eggAfternoon"
                content="afternoon egg"
                type="number"
                label="black"
                />
            <InputFragment
                v-model="form.broken"
                name="broken"
                content="broken egg"
                type="number"
                label="black"
                />
            <InputFragment
                v-model="form.abnormal"
                name="abnormal"
                content="abnormal egg"
                type="number"
                label="black"
                />
            <InputFragment
                v-model="form.sale"
                name="sale"
                content="sale egg"
                type="number"
                label="black"
                />
            <InputFragment
                v-model="form.feed"
                name="feed"
                content="total feed (in Kilograms)"
                type="decimal"
                label="black"
                />
            <InputFragment
                v-model="form.feed_name"
                name="feedName"
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
    id: null,
    date: null,
    female_die: null,
    female_reject: null,
    male_die: null,
    male_reject: null,
    egg_morning: null,
    egg_afternoon: null,
    broken: null,
    abnormal: null,
    sale: null,
    feed: null,
    feed_name: null,
    total_egg:null
});


const loading = ref(false);
const pakan = ref([]);
onMounted(async () => {
    try {
        const response = await axios.get("/admin/getpakan"); // Ganti URL sesuai endpoint kamu
        pakan.value = response.data;
        form.value = {
            id: props.data.id,
            date: props.data.created_at || "",
            female_die: props.data.female_die || 0,
            female_reject: props.data.female_reject || 0,
            male_die: props.data.male_die || 0,
            male_reject: props.data.male_reject || 0,
            egg_morning: props.data.egg_morning || 0,
            egg_afternoon: props.data.egg_afternoon || 0,
            broken: props.data.broken || 0,
            abnormal: props.data.abnormal || 0,
            sale: props.data.sale || 0,
            feed: props.data.feed || 0,
            feed_name: props.data.feed_name || "",
        };
    } catch (error) {
        console.error("Gagal mengambil data pakan:", error);
    }
    console.log("form: ",form.value);
});
const totalEgg = computed(() => {
    return (
        (form.value.egg_morning || 0) +
        (form.value.egg_afternoon || 0) -
        (form.value.broken || 0) -
        (form.value.abnormal || 0) -
        (form.value.sale || 0)
    );
});

const pakanList = computed(() =>
    pakan.value.map((item) => ({
        id: item.nama_pakan,
        name: item.nama_pakan,
    }))
);

const handleSubmit = () => {
    form.value.total_egg = totalEgg
    if(form.value.total_egg<0){
        alert(
            "Total broken, abnormal and sale egg is bigger than current total!!"
        );
        return;
    }
    console.log(form.value.total_egg)
    loading.value = true;

    router.put("/admin/breedingadjustment", form.value, {
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
