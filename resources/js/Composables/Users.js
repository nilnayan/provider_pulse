import { ref } from "vue"
import axios from "axios"
import { useRouter } from "vue-router"
import config from '@/config';

//axios.defaults.baseURL = 'http://localhost/api/v1/';
axios.defaults.baseURL = config.apiUrl;
export default function useUsers() {
    const users = ref([]);
    const user = ref([]);
    const errors = ref({});
    const router = useRouter();
    const imgError = ref({});
    
    const getUsers = async (page) => {
        const response = await axios.get(`users?page=${page}`);
        users.value = response.data;
    }

    const getUser = async (id) => {
        const response = await axios.get("users/" + id);
        user.value = response.data.data;
    }

    const storeUser = async (data) => {
        try {
            const response = await axios.post("users", data);
            await router.push({name: "UserIndex"});

        } catch (error) {
            // alert(error.response.status);
            if (error.response.status === 422) {
                errors.value = error.response.data.errors;
            }
        }
    }

    const updateUser = async (id,filedata) => {
        try {
            await axios.put("users/" + id, user.value);
            if(filedata!==undefined){
             submitFile(id,filedata);
             if(imgError.value && imgError.value==='success'){
                await router.push({name: "UserIndex"});
              }
            }else{
                    await router.push({name: "UserIndex"});
            }
        } catch (error) {
            if (error.response.status === 422) {
                errors.value = error.response.data.errors;
            }
        }
    }

    const submitFile = async (id,filedata) =>{
        const file = filedata;
        const formData = new FormData(); 
        if(file!==undefined){
            // Get the file extension
            const extension = file.name.split('.').pop();
            const conExt = extension.toLowerCase();
            let extensions = ["jpg", "jpeg", "gif", "png"];
            if (extensions.indexOf(conExt) !== -1) {
                formData.append('photo', file);
                axios.post("photo-upload/"+id, formData).then(response => {});
                imgError.value='success';
            }else{
                imgError.value='error';
                errors.value.photo='Please upload file having extensions .jpeg/.jpg/.png/.gif/.bmp only.';
            }
             
        }
        
      }
    const removeUserImg = async (id) =>{
        try {
            
            await axios.delete("photo-delete/" + id );

        } catch (error) {
            if (error.response.status === 422) {
                errors.value = error.response.data.errors;
            }
        } 
    }
    const destroyUser = async (id) => {
        try {
            if (!window.confirm("Delete user?"))
                return;

            await axios.delete("users/" + id);
            await getUsers();

        } catch (error) {
            if (error.response.status === 422) {
                errors.value = error.response.data.errors;
            }
        }
    }

    return {
        user,
        users,
        getUser,
        getUsers,
        storeUser,
        updateUser,
        destroyUser,
        errors,
        imgError,
        removeUserImg,
    }
}