<template>
	<div class="container">
        <div class="row justify-content-center">
            <div class="bg-light col-sm-6 mt-4 p-4 rounded shadow-sm">
                <h3>Login</h3>
                <form @submit.prevent="login">
                    <div class="form-group py-2">
                        <label for="email">Email Address:</label>
                        <input type="email" class="form-control" id="email" v-model="form.email">
                    </div>
                    <div class="form-group  py-2">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" v-model="form.password">
                    </div>
                    <button type="submit" class="btn btn-primary mt-2 px-4">Login</button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    import { reactive, ref } from 'vue'
    import { useRouter } from "vue-router"
    import { useStore } from 'vuex'
    import { callApi, __notify } from '@/composables'
    export default{
        setup(){
            const router = useRouter()
            const store = useStore()
            const error = ref('');
            let form = reactive({
                email: '',
                password: ''
            });

            const login = async () => {
                const res = await callApi('post','/api/login', form)
                if(res.data.success){
                    const userReq = await callApi('get','/api/user')
                    if(userReq.status == 200){
                        __notify('Login Successfull', '', 'success')
                        store.dispatch('setToken', res.data.data.token);
                        store.dispatch('setUser',  JSON.stringify(userReq.data));
                        router.push({name:'Dashboard'})
                    }else{
                        __notify('User Not found', '', 'warning')
                    }
                }else{                    
                    __notify('Opps Something went wrong', '', 'error')
                    setTimeout(()=> {
                     error.value = ''
                    }, 5000)
                }
            };
            
            return{
                form,
                login,
            }
        }
    }
</script>
