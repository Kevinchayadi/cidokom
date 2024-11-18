<template>
  <div class="w-full d-flex">
    <FormButton name="add new" @click="createForm" class="text-sm mb-2"/>
    
    <table class="w-full">
      <tbody>
        <tr v-for="data in kandanglist" :key="data.id" class="w-full border-b border-b-white">
          <td class="text-sm md:text-xl font-bold  text-primary-text-light">{{ data.name }}</td>
          <td class="text-right">
            <div>
              <FormButton name="Detail Pen" @click="detail(data.id)" class="text-xs mb-2"/>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
    
  </template>
<script setup>
import { router } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import FormButton from '../../components/inputComponent/FormButton.vue';
import { computed } from 'vue';

// Menerima props dari komponen induk
const props = defineProps({
  kandang: {
    type: Array,
    default: () => [],
    required: true
  }
});

// Computed property untuk memproses data dari props
const kandanglist = computed(() =>
  props.kandang.map(item => ({
    id: item.id,
    name: item.nama_kandang
  }))
);


const detail = (id) => {
  console.log(`Detail button clicked for Kandang with ID: ${id}`);
  router.get(`/user/pen/${id}`)

};


// Fungsi untuk membuka form tambah kandang
const createForm = () => {
  console.log('Add new button clicked');
  router.get('/user/farm/create')
};

</script>
  