<template>
    <div class="w-full d-flex">
      <div>
        <div><Headers :tittle="tittle" /> </div>
        <FormButton name="Buat Jenis Ayam Baru" @click="createForm" class="text-sm mb-2"/>
      </div>
      
      <table class="w-full">
        <tbody>
          <tr v-for="data in ayamlist" :key="data.id" class="w-full border-b border-b-white">
            <td class="text-sm text-center md:text-xl  font-bold  text-primary-text-light py-2">{{ data.name }}</td>

          </tr>
        </tbody>
      </table>
    </div>
      
    </template>
  <script setup>
  import { router } from '@inertiajs/vue3';
  import FormButton from '../../components/inputComponent/FormButton.vue';
  import { computed } from 'vue';
import Headers from '../../components/Headers.vue';
  
  // Menerima props dari komponen induk
  const props = defineProps({
    tittle:{
      type:String,
      default: 'ayam List'
    },
    ayam: {
      type: Array,
      default: () => [],

    }
  });

  
  // Computed property untuk memproses data dari props
  const ayamlist = computed(() =>
  props.ayam.map(item => ({
    id: item.id,
    name: item.code_Ayam
  }))
);
  

  
  
  // Fungsi untuk membuka form tambah kandang
  const createForm = () => {
    router.get('/user/ayam/create')
  };
  
  </script>
    