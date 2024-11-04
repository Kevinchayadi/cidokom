<template>
    <div class="w-full d-flex">
      <div>
        <div><Headers :tittle="tittle" /> </div>
        <FormButton name="create new pen" @click="createForm" class="text-sm mb-2"/>
      </div>
      
      <table class="w-full">
        <tbody>
          <tr v-for="data in penList" :key="data.id" class="w-full border-b border-b-white">
            <td class="text-sm text-center md:text-xl  font-bold  text-primary-text-light py-2"> {{ data.name }}</td>

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
      default: 'Pen List'
    },
    pen: {
      type: Array,
      default: () => [],

    }
  });

  
  // Computed property untuk memproses data dari props
  const penList = computed(() =>
  props.pen.map(item => ({
  id: item.id,
  name: `(${item.kandang.nama_kandang}) ${item.code_pen}`
})));
  

  
  
  // Fungsi untuk membuka form tambah kandang
  const createForm = () => {
    console.log('Add new button clicked');
    router.get('/user/pen/create')
  };
  
  </script>
    