<template>
    <div v-if="type === 'dropdown'" :class="classes">
        <Label :name="name" :content="content"  />
        <DropDown :name="name" :datas="datas" v-model="internalValue" />
    </div>
    <div v-else-if="type === 'textArea'" :class="classes">
        <Label :name="name" :content="content" />
        <TextArea :name="name" :placeholder="placeholder" v-model="internalValue" />
    </div>
    <div v-else-if="type === 'multipleCB'" :class="classes">
        <Label :name="name" :content="content" />
        <Multiple :name="name" :datas="datas" v-model="internalValue" />
    </div>
    <div v-else-if="type === 'multipleDP'" :class="classes">
        <Label :name="name" :content="content" />
        <MulipleSelected :name="name" :datas="datas" v-model="internalValue" />
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
import Multiple from "./other component/multiple.vue";
import MulipleSelected from "./other component/mulipleSelected.vue";

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
        default: () => [],
    },
    content:{
        type: String,
        default: null,
    },
    modelValue: {
        type: [String, Number, Array]
    }
});

const emit = defineEmits(["update:modelValue"]);


const internalValue = ref(Array.isArray(props.modelValue) ? [...props.modelValue] : props.modelValue);

watch(internalValue, (newVal) => {
    // console.log(internalValue)
    const isDifferent = Array.isArray(newVal)
        ? JSON.stringify(newVal) !== JSON.stringify(props.modelValue)
        : newVal !== props.modelValue;

    if (isDifferent) {
        emit("update:modelValue", newVal);
    }
});


watch(() => props.modelValue, (newVal) => {
    const isDifferent = Array.isArray(newVal)
        ? JSON.stringify(newVal) !== JSON.stringify(internalValue.value)
        : newVal !== internalValue.value;

    if (isDifferent) {
        internalValue.value = Array.isArray(newVal) ? [...newVal] : newVal;
    }
});

const classes = "my-4";
</script>
<style></style>
