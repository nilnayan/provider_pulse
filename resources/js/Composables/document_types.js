import { ref } from "vue"
import axios from "axios"
import { useRouter } from "vue-router"
import config from '@/config';
axios.defaults.baseURL = config.apiUrl;
export default function useDocumentType() {
    const documents_types = ref([]);
    const errors = ref({});
    const router = useRouter();

    const getDocumentTypes= async (page) => {
        const response = await axios.get(`document_types?page=${page}`);
        documents_types.value = response.data;
    }

    const getDocumentType = async (id) => {
        const response = await axios.get("document_types/" + id);
        documents_types.value = response.data.data;
    }


    const storeDocumentType = async (data) => {
        try {
            await axios.post("document_types", data);
            await router.push({name: "DocumentTypeIndex"});

        } catch (error) {
            if (error.response.status === 422) {
                errors.value = error.response.data.errors;
            }
        }
    }

    const updateDocumentType = async (id) => {
        try {
            await axios.put("document_types/" + id, documents_types.value);
            await router.push({name: "DocumentTypeIndex"});
        } catch (error) {
            if (error.response.status === 422) {
                errors.value = error.response.data.errors;
            }
        }
    }
    const destroyDocumentType = async (id) => {
        
        try {
            if (!window.confirm("Delete document?"))
                return;

            const response = await axios.delete("document_types/" + id);
            if (response) {
                await getDocumentTypes();
            }

        } catch (error) {
            if (error.response.status === 422) {
                errors.value = error.response.data.errors;
            }
        }
    }

    return {
        documents_types,
        storeDocumentType,
        getDocumentType,
        getDocumentTypes,
        updateDocumentType,
        errors,
        destroyDocumentType,
    }
}