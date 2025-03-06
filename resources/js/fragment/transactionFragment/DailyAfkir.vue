<template>
    <div class="w-[80%]">
        <Headers tittle="Breeding daily report" />
        <form @submit.prevent="handleSubmit">
            <InputFragment
                v-model="feedName"
                name="feedName"
                content="Feed name"
                type="dropdown"
                :datas="pakanList"
            />
            <InputFragment
                v-model="feedMale"
                name="feedMale"
                content="Feed Male (in Kilograms)"
                type="number"
            />
            <InputFragment
                v-model="feedFemale"
                name="feedFemale"
                content="Feed Female (in Kilograms)"
                type="number"
            />
            <InputFragment
                v-model="male_die"
                name="male_die"
                content="Male Die"
                type="number"
            />
            <InputFragment
                v-model="female_die"
                name="female_die"
                content="Female Die"
                type="number"
            />
            <InputFragment
                v-model="male_sale"
                name="male_sale"
                content="Male Sale"
                type="number"
            />
            <InputFragment
                v-model="female_sale"
                name="female_sale"
                content="Female Sale"
                type="number"
            />
            <InputFragment
                v-model="idDestination"
                name="idDestination"
                content="pen Destination"
                type="dropdown"
                :datas="penList"
            />
            <InputFragment
                v-model="maleOut"
                name="maleOut"
                content="Male Out"
                type="number"
            />
            <InputFragment
                v-model="femaleOut"
                name="femaleOut"
                content="Female Out"
                type="number"
            />
            <!-- The rest of your existing inputs remain unchanged -->
            <input name="admin" type="hidden" value="admin_name" />

            <div class="w-full flex text-center justify-center">
                <FormButton
                    name="Submit"
                    custom="text-center w-[80%] py-4 mt-4"
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

// Define props
const props = defineProps({
    id: {
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
        name: item.code_pen,
    }))
);

const store = useStore();

const feedName = ref(0);
const feedMale = ref(0);
const feedFemale = ref(0);
const male_die = ref(0);
const female_die = ref(0);
const male_sale = ref(0);
const female_sale = ref(0);
const idDestination = ref("");
const maleOut = ref(0);
const femaleOut = ref(0);

// Handle form submission
const handleSubmit = () => {
    router.post(
        `/user/afkir/input/${props.id}`,
        {
            feedName: feedName.value,
            // id_breeding: props.id_breeding,
            feed_male: feedMale.value,
            feed_female: feedFemale.value,
            male_die: male_die.value,
            female_die: female_die.value,
            male_sale: male_sale.value,
            female_sale: female_sale.value,
            id_destination: idDestination.value,
            male_out: maleOut.value,
            female_out: femaleOut.value,
            inputBy: store.getters.user.name,
        },
        {
            onError: (errors) => {
                const errorMessages = Object.values(errors).flat();
                alert(errorMessages.join("\n"));
            },
        }
    );
};
</script>

<style></style>
