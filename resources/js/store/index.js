import { createStore } from 'vuex';
import { __getCookie, __removeCookie, __setCookie } from '@/composables'



const store = createStore({
	state: {
		isLoading: false,
		componentKey: 0,
		token : __getCookie('apitoken') || null,
		user: localStorage.getItem('user') || null,
		tempPassForChange: null,
	},

	mutations: {
		updateToken(state, payload){
			state.token = payload;
		},
		updateUser(state, payload){
			state.user = payload;
		},
		updateLoadingStatus(state, payload){
			state.isLoading = payload;
		},
		updateComponentKey(state, payload){
			state.componentKey += payload;
		},
		updateTempPass(state, payload){
			state.tempPassForChange = payload;
		}
	},

	actions: {
		setLoading(context, payload){
			context.commit('updateLoadingStatus', payload)
		},

		setToken(context, payload){
			// localStorage.setItem('token', payload);
			__setCookie({name:'apitoken', token: payload.token, expire: `${payload.session}MIN`});
			context.commit('updateToken', payload);
		},
		removeToken(context){
			__removeCookie('apitoken');
			context.commit('updateToken', null);
		},
		setUser(context, payload){
			localStorage.setItem('user', payload);
			context.commit('updateUser', payload);
		},
		removeUser(context){
			localStorage.removeItem('user');
			context.commit('updateUser', null);
		},
		setupComponentKey(context, payload){
			context.commit('updateComponentKey', payload);
		},
		setTempPassForChange(context, payload){
			context.commit('updateTempPass', payload);
		}
	},

	getters: {
		getToken: (state) => {
			return state.token;
		},
		getUser(state){
			return state.user
		},
		loadingStatus(state){
			return state.isLoading
		},
		getCompKey(state){
			return state.componentKey;
		},
		getTempPassForChange(state){
			return state.tempPassForChange;
		}
	}
});


export default store
