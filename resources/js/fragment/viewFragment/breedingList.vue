<template>
  <div class="w-full d-flex">
    <Headers tittle="Breeding List" />
    <FormButton name="Create New Breeder" @click="createForm" class="text-sm mb-2"/>
    <table class="w-full">
      <tbody>
        <tr v-for="data in breedingList" :key="data.id" class="w-full border-b text-primary-text-light border-b-white">
          <td class="p-3">{{ data.name }}</td>
          <td class="text-right">
            <!-- Periksa apakah ada relasi hatcheryDetails dan aksesnya -->
            <button v-if="data.isTime" :class="buttonClasses" @click="afkirALL(data.id)">afkir All</button>
            <button v-if="data.isTrue" :class="buttonClasses" @click="vaccine(data.id)">Add Vaccine</button>
            <button v-if="data.isInputed" :class="buttonClasses" @click="input(data.id)">Daily Input</button>
            <!-- <button v-if="data.isInputed" :class="buttonClasses" @click="input(data.id)">Daily Input</button> -->
            <button v-else :class="buttonClasses" @click="move(data.id)">move</button>
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
import Headers from '../../components/Headers.vue';

  const props = defineProps({
    breeding: {
      type: Array,
      required: true
    }
  });

  const breedingList = computed(() =>
  props.breeding.map(item => ({
    id: item.id_breeding,
    name: item.id_breeding,
    isInputed: !item.isInputed, // Jika ada detail yang dibuat hari ini, tampilkan tombol
    isTrue: !item.isTrue
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
    // console.log(`Edit button clicked for 3 days condition, hatchery with ID: ${id}`)
    router.get(`/user/breeding/input/${id}`);
  };
  const afkirALL = (id) => {
    // console.log(`Edit button clicked for 3 days condition, hatchery with ID: ${id}`)
    router.get(`/user/breeding/afkir/${id}`);
  };
  const move = (id) => {
    // console.log(`Edit button clicked for 3 days condition, hatchery with ID: ${id}`)
    // console.log(`Edit button clicked for 3 days condition, hatchery with ID: ${id}`)
    router.get(`/user/breeding/move/${id}`);
  };
  const vaccine = (id) => {
    router.get(`/user/breeding/vaccine/${id}`);
  };
  

  const buttonClasses = 'border border-black min-w-[120px] p-2 mt-1 mx-1 rounded-2xl bg-primary hover:bg-primary-dark text-primary-text-light mb-2';
  </script>
  
  <style>
  /* Tambahkan styling sesuai kebutuhan */
  </style>
  