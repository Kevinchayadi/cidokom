<template>
    <div :class="classes">
        <select
            ref="selectElementRef"
            class="js-example-basic-multiple w-full"
            name="states[]"
            multiple="multiple"
        >
            <option
                v-for="data in datas"
                :key="data.id"
                :value="data.id"
            >
                {{ data.name }}
            </option> 
        </select>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, watch } from "vue";

const props = defineProps({
    datas: {
        type: Array,
        required: true,
    },
    modelValue: {
        type: Array,
        default: () => [],
    },
});

const emit = defineEmits(["update:modelValue"]);

const selectElementRef = ref(null);
const internalSelectedOptions = ref([...props.modelValue]);

onMounted(() => {
    const selectElement = selectElementRef.value;

    // Inisialisasi Select2
    $(selectElement).select2();

    // Set nilai awal Select2
    $(selectElement).val(internalSelectedOptions.value).trigger("change");

    // Sinkronkan Select2 dengan internalSelectedOptions
    $(selectElement).on("change", (event) => {
        const selectedValues = $(event.target).val(); // Dapatkan nilai yang dipilih
        console.log("Selected Values:", selectedValues); // Log nilai yang dipilih

        // Sinkronkan dengan internalSelectedOptions
        internalSelectedOptions.value = selectedValues;
        emit("update:modelValue", internalSelectedOptions.value);
    });
});

onBeforeUnmount(() => {
    // Hapus instans Select2 sebelum komponen dihancurkan
    $(selectElementRef.value).select2("destroy");
});

watch(() => props.modelValue, (newValue) => {
    if (JSON.stringify(newValue) !== JSON.stringify(internalSelectedOptions.value)) {
        internalSelectedOptions.value = [...newValue];
        $(selectElementRef.value).val(newValue).trigger("change");
    }
});

const classes = ref(
    "outline-none w-full focus:border border-blue-500 rounded-md drop-shadow-sm text-xs md:text-base"
);
</script>

<style scoped>
</style>
