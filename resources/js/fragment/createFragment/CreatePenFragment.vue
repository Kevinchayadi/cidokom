<template>
    <div class="w-[80%]">
        <Headers tittle="Buat Pen" />
        <form @submit.prevent="handleSubmit">
            <InputFragment v-model="form.id_kandang" name="id_kandang" content="code kandang" type="dropdown" :datas="kandanglist" />
            <InputFragment v-model="form.code_pen" name="code_pen" content="code pen" type="string" />

            <div class="w-full flex text-center justify-center">
                <FormButton name="Submit" custom="text-center w-[80%] py-4 mt-4" />
            </div>
        </form>
    </div>
</template>

<script setup>
import { computed, reactive } from 'vue';
import Headers from '../../components/Headers.vue';
import FormButton from '../../components/inputComponent/FormButton.vue';
import InputFragment from '../../components/InputFragment.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    kandang: {
        type: Array,
        required: true
    }
});

const kandanglist = computed(() =>
    props.kandang.map(item => ({
        id: item.id,
        name: item.nama_kandang
    }))
);

const form = reactive({
    id_kandang: '',
    code_pen: ''
});

const handleSubmit = () => {
    router.post('/user/pen/create', { ...form });
};
</script>

<style scoped>
/* Add styles if necessary */
</style>
