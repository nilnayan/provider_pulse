import { ref } from "vue"
import axios from "axios"
import { useRouter } from "vue-router"
import config from '@/config';
axios.defaults.baseURL = config.apiUrl;
export default function useDocuments() {
    const documents = ref([]);
    const errors = ref({});
    const router = useRouter();
    const document_type_lists = ref([]);

    const getDocuments = async (id,page) => {
        const response = await axios.get("documents/" + id+`?page=${page}`);
        documents.value = response.data;
    }

    const storeDocuments = async (form, files,userId,allow_format) => {
        const formData = new FormData();
         if (!files) {
            errors.value.document = 'The upload doc field is required';
            return false;
        }else{
            errors.value.document = ''; 
        }
        if (!form.access_level_id) {
            errors.value.access_level_id_error= 'The access level field is required';
            return false;
        }else{
            errors.value.access_level_id_error= '';
        }
        if (!form.document_type_id) {
            errors.value.document_type_error= 'The document type field is required';
            return false;
        }else{
            errors.value.document_type_error= '';
        }
        
        const extension = files[0].name.split('.').pop();
        const conExt = extension.toLowerCase();
        let extensions = allow_format;
        if (extensions.indexOf(conExt) !== -1) {
            formData.append("files", files[0]);
            formData.append("access_level_id", form.access_level_id);
            formData.append("user_id", userId);
            formData.append("document_type_id",form.document_type_id);
            formData.append('file_size', files[0].size);
             try {
                const response = await axios.post("documents", formData);
                if (response) {
                    await router.push({
                        name: "DocumentsIndex"
                    });
                }
            } catch (error) {
                if (error.response.status === 422) {
                    errors.value = error.response.data.errors;
                }
            } 
        }
    }

    const destroyDocument = async (id,userId) => {
        
        try {
            if (!window.confirm("Delete document?"))
                return;

            const response = await axios.delete("documents/" + id);
            if (response) {
                await getDocuments(userId);
            }

        } catch (error) {
            if (error.response.status === 422) {
                errors.value = error.response.data.errors;
            }
        }
    }

    const getDocumentTypeList = async () => {
        const response = await axios.get("/get_document_types");
        document_type_lists.value = response.data.data;
    }
    return {
        documents,
        storeDocuments,
        getDocuments,
        errors,
        destroyDocument,
        document_type_lists,
        getDocumentTypeList,
    }
}