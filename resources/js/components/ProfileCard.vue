<template>
	<div class="card">
		<div class="card_background_img">
            <div class="text-end">
                <button class="btn btn-sm text-right profile_edit_btn" @click="isProfileEdit = !isProfileEdit">Edit Profile</button>
            </div>  
        </div>
		<div v-if="isProfileEdit != true">
          <div class="card_profile_img" :style="`background-image:url(${user.avatar ? user.avatar.view_path : null})`"></div>
            <div class="user_details">
                <h3>{{user.name}}</h3>
                <p>{{user.email}}</p>
            </div>      
        </div>
        <div class="profile_edit_wrapper" v-else>
            <div class="card_profile_img" :style="`background-image:url(${user.avatar ? user.avatar.view_path : null})`"></div>
            <div class="user_details">
                <form class="form-group user_edit" @submit.prevent="editSubmit($event)">
                    <input type="text" class="form-control my-1" name="name" :value="user.name">
                    <input type="text" class="form-control my-1" name="email" :value="user.email">
                    <input type="submit" value="Save" class="btn btn-outline-primary btn-sm px-3"> &nbsp &nbsp
                    <button type="button" class="btn btn-sm btn-outline-secondary ml-1" @click="showPasswordEditModal()">Change Password</button>
                </form>
            </div>
        </div>
        <div>
            <EditProfileModal />
        </div>
		<div class="card_count">
			<!-- User Meta Data -->
			<div class="btn_cs" @click="logout()">Logout</div>
		</div>
	</div>
</template>

<script>
	import { ref, reactive } from 'vue';
	import { useStore } from 'vuex';
    import { useRouter } from "vue-router";
    import { callApi, callApi__CFR, __notify } from '@/composables';
    import EditProfileModal from '@/components/utilities/EditProfile.vue';
	export default{
		name: "ProfileCard",
        components: {
            EditProfileModal
        },
		setup(){
			const store = useStore();
            const router = useRouter();
            const user = reactive(JSON.parse(store.getters.getUser));
			const isProfileEdit = ref(false);
            const logout = async() => {
				let res = await callApi('post', '/api/logout', {id: user.id});
				if(res.status){
					store.dispatch('removeToken')
                    store.dispatch('removeUser')
                    router.push({name: 'Login'})
				}
            }

            const editSubmit = async(e) => {
                const form = document.querySelector('.user_edit');
                const data = Object.fromEntries(new FormData(form).entries());
                data['id'] = user.id;
                let req = await callApi__CFR('post', '/api/saveuserdata', data);
                if (req.status == 200) {
                    store.dispatch('setUser',  JSON.stringify(req.data));
                    __notify("Update Successfull")
                }
            } 
            const showEmailVerify = () => {
                const modalDiv = document.querySelector('#emailVeifryModal');
                const myModal = new bootstrap.Modal(modalDiv)
                myModal.show();
            };

            const showPasswordEditModal = () => {
                const modalDiv = document.querySelector('#editProfileModal');
                const myModal = new bootstrap.Modal(modalDiv)
                myModal.show();
            } 
            const hideModal = () => {
                const modalDiv = document.querySelector('#editProfileModal');
                const myModal = new bootstrap.Modal(modalDiv)
                myModal.hide();
                
            }
            return {
            	user,
            	logout,
                isProfileEdit,
                editSubmit,
                showPasswordEditModal,
                hideModal
            }
		}
	}
</script>

<style scoped>
	/*  profile  */
    .card_profile_img {
        width: 120px;
        height: 120px;
        background-color: #868d9b;
        background: url("https://source.unsplash.com/7Sz71zuuW4k");
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        border: 2px solid #ffffff;
        border-radius: 120px;
        margin: 0 auto;
        margin-top: -60px;

    }
    .card_background_img {
        width: 100%;
        height: 180px;
        background-color: #e1e7ed;
        background: url("https://source.unsplash.com/9wg5jCEPBsw");
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
    }
    .user_details p {
        margin-bottom: 20px;
        margin-top: -5px;
    }
    .user_details {
        padding: 0 29px;
    }
    .user_details h3 {
        margin-top: 10px;
    }
    .card_count {
        padding: 30px;
        border-top: 1px solid #dde1e7;
    }
    .count {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
    }
    .count p {
        margin-top: -10px;
    }
    .btn_cs {
        padding: 16px;
        width: 100%;
        border: none;
        outline: none;
        border-radius: 4px;
        background-color: #24c5a1;
        color: #ffffff;
        cursor: pointer;
        text-align: center;
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
    }
    .profile_edit_btn:hover{
        text-decoration: underline;
        color: var(--bs-link-color);
    }

    .profile_edit_wrapper {
        padding-bottom: 18px;
    }
</style>