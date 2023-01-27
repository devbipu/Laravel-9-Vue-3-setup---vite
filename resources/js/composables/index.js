import store from '@/store'
import Swal from 'sweetalert2'
import { useCookies } from "vue3-cookies";
const { cookies  } = useCookies();
// const appStore = useStore()
// const token = store.getters('getToken');

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


export function __getCookie(name){
	let data = cookies.get(name); //Accept token name and return data if exits 
	return data
}
export function __setCookie({name = null, token, expire=null}){
	token = store.getters.getToken != null ? store.getters.getToken : token;
	cookies.set(name , token, expire); //token, ksfskdf2445, 1MIN
	return "success";
}

export function __removeCookie(name){
	cookies.remove(name);
}