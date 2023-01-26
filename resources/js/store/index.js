import { createStore } from 'vuex';
import { __getCookieByName } from '@/composables'



const store = createStore({
	state: {
		isLoading: false,
		componentKey: 0,
		token : __getCookieByName('apitoken') || null,
		user: localStorage.getItem('user') || null,
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
		updateCookieToken(state, payload){
			state.cookie_token = payload; 
		}
	},

	actions: {
		setLoading(context, payload){
			context.commit('updateLoadingStatus', payload)
		},

		setToken(context, payload){
			// localStorage.setItem('token', payload);
			__setCookie('apitoen', payload, "120MIN");
			context.commit('updateToken', payload);
		},
		removeToken(context){
			localStorage.removeItem('token');
			context.commit('updateToken', 0);
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
		setCookieToken(context, payload){
			context.commit('updateCookieToken', payload);
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
		getCookieToken(state){
			return state.cookie_token;
		}
	}
});


export default store