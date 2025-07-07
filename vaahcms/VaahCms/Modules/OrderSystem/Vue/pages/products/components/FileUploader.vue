<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useProductStore } from '../../../stores/store-products'

const store = useProductStore();

const props = defineProps({
    uploadUrl: { type: String, required: true },
    max_file_size: { type: Number, default: 4000000 },
    file_type_accept: { type: String, default: 'image/*,application/pdf' },
    can_select_multiple: { type: Boolean, default: false } // 🔄 single file only
});

const emit = defineEmits(['child-event']);

const fileInput = ref(null);
const uploadStatus = ref('');
const uploadedFileNames = ref([]);

function triggerFileDialog() {
    fileInput.value?.click();
}

function handleManualSelect(e) {
    const file = e.target.files?.[0];
    if (file) {
        uploadFiles([file]);
    }
}

function handleDrop(e) {
    const file = e.dataTransfer.files?.[0];
    if (file) {
        uploadFiles([file]);
    }
}

async function uploadFiles(files) {
    uploadStatus.value = 'uploading';
    uploadedFileNames.value = [];
    store.upload_prescription = []; // clear previous uploads for single file

    const file = files[0];
    const formData = new FormData();
    formData.append('file', file);

    try {
        const response = await axios.post(props.uploadUrl, formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });

        if (response.data.success && response.data.file_url) {
            store.upload_prescription.push(response.data.file_url);
            emit('child-event', response.data.file_url);
            uploadedFileNames.value.push(file.name);
            uploadStatus.value = 'success';
        } else {
            uploadStatus.value = 'error';
            console.error('Upload failed:', response.data.message);
        }
    } catch (err) {
        uploadStatus.value = 'error';
        console.error('Upload error:', err);
    }

    // setTimeout(() => {
    //     uploadStatus.value = '';
    // }, 3000);
}

const formatSize = (bytes) => {
    if (bytes === 0) return '0 B';
    const k = 1024;
    const sizes = ['B', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return `${(bytes / Math.pow(k, i)).toFixed(2)} ${sizes[i]}`;
};
</script>

<template>
    <div
        class="text-gray-600 text-sm border-2 border-dashed border-gray-300 rounded-md p-6 text-center bg-gray-50 cursor-pointer w-full relative"
        @click="triggerFileDialog"
        @drop.prevent="handleDrop"
        @dragover.prevent
    >
        <p class="mb-1 font-semibold">Upload Prescription</p>
        <p class="text-xs text-gray-400">(Images or PDFs, max {{ formatSize(max_file_size) }})</p>

        <input
            type="file"
            ref="fileInput"
            :accept="file_type_accept"
            :multiple="false"
        class="hidden"
        @change="handleManualSelect"
        />

        <!-- Upload Feedback -->
        <div v-if="uploadStatus === 'uploading'" class="text-blue-500 mt-2">Uploading...</div>
        <div v-else-if="uploadStatus === 'success'" class="text-green-600 mt-2">
            Uploaded: {{ uploadedFileNames[0] }}
        </div>
        <div v-else-if="uploadStatus === 'error'" class="text-red-500 mt-2">Upload failed. Please try again.</div>
    </div>
</template>
