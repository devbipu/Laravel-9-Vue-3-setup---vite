<template>
	<div class="modal fade" id="emailVeifryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="emailVeifryModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	  	<form class="form-group user_password_change" @submit.prevent="editPassword($event)">
		    <div class="modal-content">
		      <div class="modal-header">
		      	<div>
		        	<h1 class="modal-title fs-5" id="emailVeifryModalLabel">Verify Email</h1>
		      		<p class="mb-0">Please check your Email</p>
		      	</div>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      </div>
		      <div class="modal-body">
	                <input v-model.number="clietOptCode" type="number" class="form-control my-1" placeholder="Your OTP Code">
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
		        <button type="submit" class="btn btn-primary"  data-bs-dismiss="modal" @click="showEmailVerify();">Save Password</button>
		      </div>
		    </div>
	    </form>
	  </div>
	</div>
</template>

<script>
	import { ref } from 'vue';
	import { useStore } from "vuex";
    import { callApi, __notify } from '@/composables'
 	export default{ 
		name: "Edit Profile Modal",
		setup(){
			const store = useStore();
			const clietOptCode = ref(Number); 
			const showEmailVerify = async() => {
				console.log(typeof clietOptCode.value);
				let datas = store.getters.getTempPassForChange;
				datas['verify_otp'] = clietOptCode.value;
				const req = await callApi('post', '/api/updatepassword', datas);
				if (req.data.success) {
					__notify("Password Change Successfully")
				}else{
					__notify('Opps', 'Password Not Changed', 'error');
				}
				// const modalDiv = document.querySelector('#emailVeifryModal');
                //const myModal = new bootstrap.Modal(modalDiv)
                // myModal.dispose();
			};
			const editPassword = () => {
				console.log("closed");
			}
			return {
				showEmailVerify,
				editPassword,
				clietOptCode
			}
		}
	}
</script>