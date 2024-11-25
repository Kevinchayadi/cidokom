<template>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
        <div class="p-6 bg-white rounded shadow-md w-80">
            <h2 class="text-xl font-semibold text-center mb-4">Upload File</h2>
            <input
                type="file"
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                @change="handleFileUpload"
                ref="fileInput"
            />
            <button
                class="w-full mt-4 px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300"
                @click="uploadFile"
            >
                Upload
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";
import { router } from '@inertiajs/vue3';

const file = ref(null);

const handleFileUpload = (event) => {
    file.value = event.target.files[0];
};

const uploadFile = () => {
    if (!file.value) {
        alert("Please select a file before uploading.");
        return;
    }

    const formData = new FormData();
    formData.append("file", file.value);

    // Inertia doesn't natively support FormData for `post` without configuration
    router.post('/uploadcommercial', formData, {
        forceFormData: true, // Ensures Inertia treats the payload as FormData
        onFinish: () => {
            alert(`File "${file.value.name}" has been uploaded successfully!`);
        },
        onError: (errors) => {
            console.error(errors);
            alert("Failed to upload the file. Please try again.");
        }
    });
};


const handleKeyUp = (event) => {
    if (event.key === "Enter") {
        uploadFile();
    }
};

onMounted(() => {
    window.addEventListener("keyup", handleKeyUp);
});

onBeforeUnmount(() => {
    window.removeEventListener("keyup", handleKeyUp);
});
</script>



<style>
/* Optional: Customize your styles here */
</style>
