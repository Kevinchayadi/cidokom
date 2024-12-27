<template>
  <div class="w-full d-flex">
    <div class="items-center justify-between ">
      <Header tittle="Commercial List" />
      <FormButton name="add new" @click="createForm" class="text-sm mb-2"/>
    </div>
    <table class="w-full">
      <tbody>
        <tr v-for="data in commercial" :key="data.id_commercial" class="w-full border-b border-b-white text-primary-text-light text-primary-text-light ">
          <td class="p-2 font-bold">{{ data.id_commercial }}</td>
          <td class="text-right">
            <!-- Periksa apakah ada relasi hatcheryDetails dan aksesnya -->
            <div >
              <button :class="buttonClasses" @click="input(data.id_commercial)">Daily Input</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  </template>
  
  
  <script setup>
import FormButton from '../../components/inputComponent/FormButton.vue';
import Header from '../../components/Headers.vue'
import { router } from '@inertiajs/vue3';

  const props = defineProps({
    commercial: {
      type: Array,
      required: true
    }
  });

  const createForm = () =>{
    router.get('/user/commercial/create')
  }

  
  const input = (id) => {
    router.get(`/user/commercial/input/${id}`)
  };
  

  const buttonClasses = 'border border-black min-w-[120px] p-2 rounded-2xl bg-primary hover:bg-primary-dark text-primary-text-light my-2';
  </script>
  
  <style>
  /* Tambahkan styling sesuai kebutuhan */
  </style>
  