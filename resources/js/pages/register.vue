<template>
	 <div>
        <div class="row justify-content-center">
            <div class="bg-light col-sm-6 mt-4 p-4 rounded shadow-sm">

                <h2>Register</h2>
                <p class="text-danger" v-for="error in errors" :key="error">
                    <span v-for="err in error" :key="err">{{ err }}</span>
                </p>
                <form @submit.prevent="register">
                    <div class="form-group py-2">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" v-model="form.name">
                    </div>
                    <div class="form-group py-2">
                        <label for="email">Email Address:</label>
                        <input type="email" class="form-control" id="email" v-model="form.email">
                    </div>

                    <div class="form-group py-2">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" v-model="form.password">
                    </div>
                    <div class="form-group py-2">
                        <label for="c_password">Confirm Password:</label>
                        <input type="password" class="form-control" id="c_password" v-model="form.c_password">
                    </div>

                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import { reactive,ref } from 'vue'
    import { useRouter } from "vue-router"
    import { useStore } from 'vuex'
    import { callApi, __notify } from '@/composables'
    export default{
        setup(){
            const router = useRouter()
            const store = useStore()
            let form = reactive({
                name :'',
                email: '',
                password: '',
                c_password: '',
            });
            let errors = ref([])
            const register = async() =>{
                const regReq = await callApi('post', '/api/register', form);
                    if(regReq.data.success){
                        __notify('Congrats');
                        router.push({name:'Login'})
                    }else{
                        errors.value = regReq.data.message
                        __notify('Opps', '', 'error')
                        setTimeout(() => {
                            errors.value = ''
                        }, 3000)
                    }
            }
            return{
                form,
                register,
                errors,
                router
            }
        }
    }
</script>