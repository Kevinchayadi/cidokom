<template>
    <div :class="classes">
        <div v-if="datas" v-for="data in datas" :key="data.id" class="flex items-center">
            <input
                type="checkbox"
                :id="data.id"
                :value="data.id"
                v-model="internalSelectedOptions"
                class="mr-2"
            />
            <label :for="data.id">{{ data.name }}</label>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue';

const props = defineProps({
    datas: {
        type: Array,
        required: true,
    },
    modelValue: {
        type: Array,
        default: () => [],
    }
});

const emit = defineEmits(['update:modelValue']);
const internalSelectedOptions = ref([...props.modelValue]);

onMounted(() => {
    const defaultOptions = [1, 3]; // Set the IDs of the options you want to check by default

    // Tambahkan setiap defaultOption jika belum ada di internalSelectedOptions
    defaultOptions.forEach((option) => {
        if (!internalSelectedOptions.value.includes(option)) {
            internalSelectedOptions.value.push(option);
        }
    });
});

const classes = ref(
    'bg-gray-100 border-b border-black outline-none w-full focus:border border-blue-500 rounded-md drop-shadow-sm text-xs md:text-base pl-2 p-1 mt-2'
);

watch(() => internalSelectedOptions.value.length, (newLength) => {
    try {
        if (newLength !== props.modelValue.length) {
            emit('update:modelValue', [...internalSelectedOptions.value]);
        }
    } catch (error) {
        console.error("Error in update:modelValue emit:", error);
    }
});

watch(
    () => props.modelValue.length,
    (newLength) => {
        if (newLength !== internalSelectedOptions.value.length) {
            internalSelectedOptions.value = [...props.modelValue];
        }
    },
    { immediate: true }
);

</script>


<style scoped>
</style>
