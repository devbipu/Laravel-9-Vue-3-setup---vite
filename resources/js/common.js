export default{
	methods: {
		__notify(type, title='', desc=''){
			const Toast = this.$swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				didOpen: (toast) => {
					toast.addEventListener('mouseenter', this.$swal.stopTimer)
					toast.addEventListener('mouseleave', this.$swal.resumeTimer)
				}
			})
			Toast.fire({
			  icon: type,
			  title: title,
			  text: desc,
			  position: 'top-end'
			})
		},
		__updateLoader(val){
			this.$store.dispatch('setLoading', val)
		}
	}
}