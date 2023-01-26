import store from '@/store'
import Swal from 'sweetalert2'
export async function callApi(method, url, data){
	store.dispatch('setLoading', true)
	try{
		const req = await axios({
			method: method,
			url: url,
			data: data
		});
		store.dispatch('setLoading', false)
		return req;
	}catch (err){
		store.dispatch('setLoading', false)
		return err.response
	}
}

export async function callApi__CFR(method, url, data){
	store.dispatch('setLoading', true)
	store.dispatch('setupComponentKey', 1);
	try{
		const req = await axios({
			method: method,
			url: url,
			data: data
		});
		store.dispatch('setLoading', false)
		return req;
	}catch (err){
		store.dispatch('setLoading', false)
		return err.response
	}
}


export function __notify(title='',  desc='', type='success'){
	// const Toast = swal.mixin({
	// 	toast: true,
	// 	position: 'top-end',
	// 	showConfirmButton: false,
	// 	timer: 3000,
	// 	timerProgressBar: true,
	// 	didOpen: (toast) => {
	// 		toast.addEventListener('mouseenter', swal.stopTimer)
	// 		toast.addEventListener('mouseleave', swal.resumeTimer)
	// 	}
	// })
	Swal.fire({
		toast: true,
		showConfirmButton: false,
		timer: 3000,
		icon: type,
		title: title,
		text: desc,
		timerProgressBar: true,
		position: 'top-end',
		didOpen: (toast) => {
			toast.addEventListener('mouseenter', Swal.stopTimer)
			toast.addEventListener('mouseleave', Swal.resumeTimer)
		}
	})
}
