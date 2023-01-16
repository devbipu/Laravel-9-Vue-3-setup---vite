<script setup>
	import Spinner from '@/components/Spinner.vue'
</script>
<template>
	<section>
		<Spinner />
		<header class="container bg-light box_shadow_100 rounded">
			<nav class="navbar navbar-expand-lg">
			  <div class="container-fluid">
			    <a class="navbar-brand" href="#">DevBipu</a>
			    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
			      <span class="navbar-toggler-icon"></span>
			    </button>
			    <div class="collapse navbar-collapse" id="navbarNavDropdown">
			      <ul class="navbar-nav">
			        <li class="nav-item">
			        	<router-link class="nav-link" to="/">Home</router-link>
			        </li>
			        <li class="nav-item">
			        	<router-link class="nav-link" to="/about">About </router-link>
			        </li>
			        <li class="nav-item" v-if="$store.getters.getToken == 0 ">
			        	<router-link class="nav-link" to="/login">Login</router-link>
			        </li>
			        <li class="nav-item" v-if="$store.getters.getToken == 0 ">
			        	<router-link class="nav-link" to="/register">Register</router-link>
			        </li>
			        <li class="nav-item" v-else>
			        	<router-link class="nav-link" :to="{name: 'Dashboard'}">Dashboard</router-link>
			        </li>
			      </ul>
			    </div>
			  </div>
			</nav>
		</header>
		<main>
			<router-view v-slot="{ Component, route }"  :key="$store.getters.getCompKey">
			  <transition :name="route.meta.transitionName || 'fade'" mode="out-in">
			    <component :is="Component" :key="$route.path"/>
			  </transition>
			</router-view>
		</main>
	</section>
</template>

<script>
	// import { computed } from 'vue';
    import { useStore } from 'vuex';
	export default{
		setup(){
			const store = useStore();
			const loginToken = function() {
				// return true;
				console.log(store.getters.getToken)
				return store.getters.getToken == 0 ? false : true ;
			};
			console.log("recompiled")
			return {
				loginToken,
				//store
			}
		}
	}
</script>

<style>
	main{
		padding: 20px;
	}
	.box_shadow_100{
		box-shadow: 0 0.125rem 0.55rem rgb(0 0 0 / 21%)
	}
	.active{
		font-weight: 500 !important;
		color: black !important;
		text-decoration: underline !important;
	}
	/* Router animation */
	.fade-leave-to, .fade-enter-form{
        opacity: .1;
	}
	.fade-leave-active, .fade-enter-active{
		transition: opacity .2s;
	}

</style>