<template>
    <div v-if="type === 'dropdown'" :class="classes">
        <Label :name="name" :datas="datas" />
        
    </div>
    <div  :class="classes">
        <Label :name="name" />
        <Input :name="name" :type="type" :placeholder="placeholder" />
    </div>
</template>

<script setup>
import Input from "../components/Input.vue";
import Label from "../components/Label.vue";

const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    type: {
        type: String,
        default: "text",
    },
    placeholder: {
        type: String,
        default: "",
    },
    datas:{
        type: Array,
        default: null
    }
});

const classes = 'grid mx-8 my-2 p-2 '
</script>
<style></style>
