<template>


    <select id="inputSelect" :name="name" v-model="selectedOption" :class="classes">

        <option disabled value="">Please select an option</option>
        <option v-if="datas" v-for="data in datas" :key="data.id" :value="data.id">
            {{ data.name }}
        </option>
    </select>

</template>

<script setup>
    import {
        ref,
        watch
    } from 'vue';

    const props = defineProps({
        datas: {
            type: Array,
            required: true,
        },
        name: {
            type: String,

        },
        modelValue: {
            type: [String, Number],
            default: ''
        }
    })
    const selectedOption = ref('');
    const emit = defineEmits(['update:modelValue']);


    const classes = ref(
        'bg-gray-100 border-b border-black outline-none w-full focus:border border-blue-500 rounded-md drop-shadow-sm text-xs md:text-base pl-2 p-1 mt-2'
    )

    watch(selectedOption, (newVal) => {
        emit('update:modelValue', newVal);
    });

    // Sync with changes from the parent component
    watch(() => props.modelValue, (newVal) => {
      selectedOption.value = newVal;
    });



    
</script>

<style scoped>

</style>
