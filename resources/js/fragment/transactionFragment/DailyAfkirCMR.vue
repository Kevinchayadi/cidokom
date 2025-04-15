<template>
    <div class="w-[80%]">
        <Headers tittle="Breeding daily report" />
        <form @submit.prevent="handleSubmit">
            <div v-if="store.getters.user.role_id == 6">
                <InputFragment
                    v-model="date"
                    name="date"
                    content="changes date (default Today)"
                    type="dropdown"
                    
                    :datas="dateList"
                />
            </div>
            <InputFragment
                v-model="feedMale"
                name="feedMale"
                content="Feed  (in Kilograms)"
                type="number"
            />
            <InputFragment
                v-model="idDestination"
                name="idDestination"
                content="ID Destination"
                type="dropdown"
                :datas="penList"
            />
            <InputFragment
                v-model="maleOut"
                name="maleOut"
                content="Out"
                type="number"
            />
            <!-- The rest of your existing inputs remain unchanged -->
            <input name="admin" type="hidden" value="admin_name" />

            <div class="w-full flex text-center justify-center">
                <FormButton
                    name="Submit"
                    custom="text-center w-[80%] py-4 mt-4"
                    :disabled="loading"
                />
            </div>
        </form>
    </div>
</template>

<script setup>
import { computed, ref } from "vue";
import { router } from "@inertiajs/vue3";
import InputFragment from "../../components/InputFragment.vue";
import FormButton from "../../components/inputComponent/FormButton.vue";
import Headers from "../../components/Headers.vue";
import { useStore } from "vuex";

// Define props
const props = defineProps({
    id_breeding: {
        type: String,
        required: true
    },
    pakan: {
        type: Array,
        required: true
    },
    pen: {
        type: Array,
    },
});

const pakanList = computed(() =>
  props.pakan.map(item => ({
      id: item.nama_pakan,
      name: item.nama_pakan
  }))
);

const penList = computed(() =>
  props.pen.map(item => ({
      id: item.id,
      name: item.code_pen
  }))
);

const store = useStore();

const dateList = ref([]);
const today = new Date()
const monthNames = [
  'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
  'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
]
for (let i = 0; i < 3; i++) {
  const d = new Date(today)
  d.setDate(d.getDate() - i)

  const year = d.getFullYear()
  const month = String(d.getMonth() + 1).padStart(2, '0')
  const day = String(d.getDate()).padStart(2, '0')

  const fullDate = `${year}-${month}-${day}`
  const readableDate = `${day} ${monthNames[d.getMonth()]}`

  dateList.value.push({
    id: fullDate,
    name: readableDate
  })
}

const date = ref(null);
const feedMale = ref(0);
const feedFemale = ref(0);
const idDestination = ref('');
const maleOut = ref(0);
const femaleOut = ref(0);
const loading = ref(false);
// Handle form submission
const handleSubmit = () => {
    loading.value = true;
    router.post("/user/breeding/input", {
        id_breeding: props.id_breeding,
        feed_male: feedMale.value,
        feed_female: feedFemale.value,
        id_destination: idDestination.value,
        male_out: maleOut.value,
        female_out: femaleOut.value,
        inputBy: store.getters.user.name
    }).then(response => {
        console.log("Data berhasil dikirim:", response);
        alert("Data berhasil dikirim!");
        loading.value = false;
    })
    .catch(error => {
        if (error.response && error.response.data.error) {
            alert(error.response.data.error);
        } else {
            alert("Terjadi kesalahan saat mengirim data. Silakan coba lagi.");
        }
        loading.value = false;
    });
};
</script>

<style></style>