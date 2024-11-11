<template>
    <div class="w-full d-flex">
      <div>
        <div><Headers tittle="Food List" /> </div>
        <!-- <FormButton name="create new Food" @click="createForm" class="text-sm mb-2"/> -->
      </div>
      
      <table class="w-full">
        <tbody>
          <tr v-for="data in pakanList" :key="data.id" class="w-full border-b border-b-white">
            <td class="text-sm text-center md:text-xl  font-bold  text-primary-text-light py-2"> {{ data.name }}</td>
            <td class="text-sm text-center md:text-xl  font-bold  text-primary-text-light py-2"> {{ data.qty }}</td>

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

    pakan: {
      type: Array,
      default: () => [],
    }
  });

  
  // Computed property untuk memproses data dari props
  const pakanList = computed(() =>
  props.pakan.map(item => ({
  id: item.id,
  name: item.nama_pakan,
  qty: item.qty + ' kg'
})));
  

  
  
  // Fungsi untuk membuka form tambah kandang
  const createForm = () => {
    console.log('Add new button clicked');
    router.get('/user/pen/create')
  };
  
  </script>
    