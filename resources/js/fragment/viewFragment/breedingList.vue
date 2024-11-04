<template>
  <div class="w-full d-flex">
    <FormButton name="add new" @click="createForm" class="text-sm mb-2"/>
    <table class="w-full">
      <tbody>
        <tr v-for="data in breedingList" :key="data.id" class="w-full border-b border-b-white">
          <td>{{ data.name }}</td>
          <td class="text-right">
            <!-- Periksa apakah ada relasi hatcheryDetails dan aksesnya -->
            <div v-if="check(data.breedingDetails)">
              <button :class="buttonClasses" @click="input(data.id)">Daily Input</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    
  </div>
  </template>
  
  
  <script setup>
import { computed } from 'vue';
import FormButton from '../../components/inputComponent/FormButton.vue';
import { router } from '@inertiajs/vue3';

  const props = defineProps({
    breeding: {
      type: Array,
      required: true
    }
  });

  const breedingList = computed(() =>
  props.breeding.map(item => ({
    id: item.id_breeding,
    name: item.id_breeding
  }))
);

  const createForm = () =>{
    router.get('/user/breeding/create')
  }

  const check = (breedingDetails) => {
  if (!breedingDetails || breedingDetails.length === 0) return true; // Jika tidak ada data, tampilkan tombol

  const today = new Date(); // Mendapatkan tanggal hari ini

  // Mengecek apakah ada detail dengan createAt sama dengan hari ini
  return !breedingDetails.some(detail => {
    const createdDate = new Date(detail.createAt); 
    return (
      today.getFullYear() === createdDate.getFullYear() && // Tahun sama
      today.getMonth() === createdDate.getMonth() && // Bulan sama
      today.getDate() === createdDate.getDate() // Hari sama
    );
  });
};

  
  const input = (id) => {
    console.log(`Edit button clicked for 3 days condition, hatchery with ID: ${id}`)
    router.get(`/user/breeding/input/${id}`);
  };
  

  const buttonClasses = 'border border-black min-w-[120px] p-2 rounded-2xl bg-primary hover:bg-primary-dark text-primary-text-light mb-2';
  </script>
  
  <style>
  /* Tambahkan styling sesuai kebutuhan */
  </style>
  