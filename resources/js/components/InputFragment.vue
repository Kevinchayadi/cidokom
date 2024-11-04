<template>
    <div v-if="type === 'dropdown'" :class="classes">
        <Label :name="name" :content="content"  />
        <DropDown :name="name" :datas="datas" v-model="internalValue" />
    </div>
    <div v-else-if="type === 'textArea'" :class="classes">
        <Label :name="name" :content="content" />
        <TextArea :name="name" :placeholder="placeholder" v-model="internalValue" />
    </div>
    <div v-else :class="classes">
        <Label :name="name" :content="content" />
        <Input :name="name" :type="type" :placeholder="placeholder" v-model="internalValue"/>
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
    placeholder: {
        type: String,
    },
    datas: {
        type: Array,
        default: [],
    },
    content:{
        type: String,
        default: null,
    },
    modelValue: {
        type: [String, Number],
        default: ""
    }
});

const emit = defineEmits(["update:modelValue"]);


const internalValue = ref(props.modelValue);

// Watch for changes to internalValue and emit them to the parent
watch(internalValue, (newVal) => {
    emit("update:modelValue", newVal);
});

// Watch for changes from the parent to sync with internalValue
watch(() => props.modelValue, (newVal) => {
    internalValue.value = newVal;
});

const classes = "my-4";
</script>
<style></style>
