<template>
    <div class="flex m-2 ">
        <input type="checkbox" v-model="proxyChecked" />
        <p class="text-xxs">{{ text }}</p>

    </div>
</template>

<script setup>
import { computed } from 'vue';

    const props = defineProps({
        checked:{
            type:Boolean
        },
        text:{
            type:String,
            default: 'Remember ME'
        }
    })

    const emit = defineEmits(['update:checked'])

    const proxyChecked = computed({
        get(){
            return props.checked
        },
        set(val){
            emit('update:checked', val)
        }
    })
</script>