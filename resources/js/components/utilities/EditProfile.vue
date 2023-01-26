<template>
	<section>
		<div class="modal fade" id="editProfileModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		  	<form class="form-group user_password_change" @submit.prevent="editPassword($event)">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h1 class="modal-title fs-5" id="editProfileModalLabel">Change Password</h1>
			        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			      </div>
			      <div class="modal-body">
			        <!-- <form class="form-group user_edit" @submit.prevent="editSubmit($event)"> -->
		                <input type="text" class="form-control my-1" name="password" placeholder="Password" value="">
		                <input type="text" class="form-control my-1" name="c_password" placeholder="Password Again" value="">
		            <!-- </form> -->
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
			        <button type="submit" class="btn btn-primary"  data-bs-dismiss="modal">Save Password</button>
			      </div>
			    </div>
		    </form>
		  </div>
		</div>
		<EmailVerifyModal />
	</section>
</template>

<script>
	import { ref, reactive } from 'vue';
	import { useStore } from 'vuex';
    import { useRouter } from "vue-router";
    import { callApi, __notify} from '@/composables';
    import EmailVerifyModal from '@/components/utilities/EmailVerify.vue';
	export default{ 
		name: "Edit Profile Modal",
		components: {
			EmailVerifyModal,
		},
		setup(){
			//
			const showEmailVerify = () => {
				const modalDiv = document.querySelector('#emailVeifryModal');
                const myModal = new bootstrap.Modal(modalDiv)
                myModal.show();
			};

			const editPassword = async () => {
				const passowrds = Object.fromEntries(new FormData(document.querySelector('.user_password_change')).entries());
				//const req = await callApi('post', '/api/updatepassword', passowrds);
				// if (req.status == 200) {
				// 	sendVerifyCode();
				// 	showEmailVerify();
				// 	console.log(req);
				// }else{
				// 	console.log(req);
				// }
				sendVerifyCode();
				showEmailVerify();
			}

			const sendVerifyCode = async() => {
				const req = await callApi('get', '/api/sendotpmail');
				console.log(req);
			}

			return {
				editPassword,
				showEmailVerify,
			}
		}
	}
</script>