<template>
  <div class="w-full d-flex">
    <div class="items-center justify-between ">
      <Header tittle="Commercial List" />
      <FormButton name="Create New Commercial" @click="createForm" class="text-sm mb-2"/>
    </div>
    <table class="w-full">
      <tbody>
        <tr v-for="data in commercial" :key="data.id_commercial" class="w-full border-b border-b-white text-primary-text-light text-primary-text-light ">
          <td class="p-2 font-bold">{{ data.id_commercial }}</td>
          <td class="text-right">
            <!-- Periksa apakah ada relasi hatcheryDetails dan aksesnya -->
            <div >
              <button v-if="data.isTime" :class="buttonClasses" @click="saleAll(data.id_commercial)">Sale All</button>
              <button v-if="!data.isTrue" :class="buttonClasses" @click="vaccine(data.id_commercial)">Add Vaccine</button>
              <button v-if="!data.isInputed" :class="buttonClasses" @click="input(data.id_commercial)">Daily Input</button>
              <button v-else :class="buttonClasses" @click="move(data.id_commercial)">move</button>
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
  const saleAll = (id) => {
    router.get(`/user/commercial/sale/${id}`)
  };
  const move = (id) => {
    router.get(`/user/commercial/move/${id}`)
  };
  const vaccine = (id) => {
    console.log(`Edit button clicked for 3 days condition, hatchery with ID: ${id}`)
    router.get(`/user/commercial/vaccine/${id}`);
  };
  

  const buttonClasses = 'border border-black min-w-[120px] p-2 rounded-2xl bg-primary hover:bg-primary-dark text-primary-text-light my-2';
  </script>
  
  <style>
  /* Tambahkan styling sesuai kebutuhan */
  </style>
  