<template>
	<div>
		<div class="toast-container position-fixed top-0 end-0 p-3">
		  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
		    <div class="toast-header">
		      <strong class="me-auto">{{title}}</strong>
		      <small>11 mins ago</small>
		      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
		    </div>
		    <div class="toast-body">
		      {{desc}}
		    </div>
		  </div>
		</div>
	</div>
</template>

<script>
	export default{
		name: "Toast",
		data(){
			return {
				title: 'dummy',
				desc: '',
			}
		},
		methods: {
			__nofity(t, d ){
				console.log(t, d)
				console.log(this.title)
				this.title = t;
				this.desc = d;


				const toastLiveExample = document.getElementById('liveToast')
				const toast = new bootstrap.Toast(toastLiveExample)
				toast.show();
			}
		},
		emits: ['checkem']
	}
</script>