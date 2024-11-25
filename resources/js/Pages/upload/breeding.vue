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
            <div v-if="preview" class="mt-4">
                <img :src="preview" alt="Preview" class="w-full h-auto rounded shadow-sm" />
            </div>
            <button
                class="w-full mt-4 px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300"
                @click="uploadFile"
            >
                Upload
            </button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            file: null,
            preview: null, // Menyimpan URL pratinjau
        };
    },
    methods: {
        handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.file = file;

                // Menggunakan FileReader untuk menghasilkan pratinjau
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.preview = e.target.result; // URL gambar dari FileReader
                };
                reader.readAsDataURL(file);
            }
        },
        uploadFile() {
            if (this.file) {
                console.log("File uploaded:", this.file.name);
                alert(`File "${this.file.name}" has been uploaded!`);
                // Logika untuk mengunggah file ke server
            } else {
                alert("Please select a file before uploading.");
            }
        },
    },
};
</script>

<style>
/* Optional: Customize your styles here */
</style>
