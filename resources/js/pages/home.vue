<template>
	<div class="container mt-4 bg-light p-3 rounded shadow-sm">
        <h4>Welcome to your home page</h4>
    </div>
</template>

<script>
    import { useRouter } from "vue-router"
	export default{
		setup(){
            const router = useRouter();
		}
	}
</script>