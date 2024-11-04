<template>
    <div>
        <Label :name="name" :content="content" />
        <Input :name="name" :type="type" :value="value " disabled />
    </div>
</template>

<script setup>
import Input from "./inputComponent/Input.vue";
import Label from "./inputComponent/Label.vue";
import TextArea from "./inputComponent//TextArea.vue";
import DropDown from "./DropDown.vue";
import { ref, watch } from "vue";

const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    type: {
        type: String,
        default: "text",
    },
    value: {
        type: [String, Number],
    },
    datas: {
        type: Array,
        default: [],
    },
    content:{
        type: String,
        default: null,
    },

});

</script>
<style></style>
