<template>
	<div class="container mt-4 bg-light p-3 rounded shadow-sm">
        <h4>Welcome to your home page</h4>
        <section class="vertualList">
        	<div class="listWrap" v-bind="containerProps">
        		<div v-bind="wrapperProps">
        			<div class="list_item" v-for="(data, i) in list" :key="i" style="height: 40px">
	        			<p>{{data.data}}</p>
	        		</div>
        		</div>
        	</div>
        </section>
    </div>
</template>

<script>
	import { ref, reactive } from "vue";
    import { useRouter } from "vue-router"
	import { useVirtualList, useInfiniteScroll  } from '@vueuse/core'
    import { callApi, __notify } from '@/composables';
	export default{
		name: "Home",
		setup(){
            const router = useRouter();
            const data = ref (Array.from (Array (60).keys(), () => 'Lorem ipsum') );
            const { list, containerProps, wrapperProps } = useVirtualList(data/*Array of list to be looped*/, {
		      itemHeight: 40,
		      overscan: 5
		    });

		    useInfiniteScroll(
		    	containerProps.ref,
		    	() => {
		    		//Do action here 
		    		data.value.push(...Array.from (Array (60).keys(), () => "Lorem More "))
		    	},
		    	{ distance: 3 }
		    )
            return {
            	list, containerProps, wrapperProps
            }
		}
	}
</script>

<style>
	.listWrap {
	    width: 75%;
	    border: 1px solid black;
	    padding: 16px;
	    max-height: 500px;
/*		height: 100vh;*/
	}

	.list_item {
	    border: 1px solid #ddd;
	    margin: 8px 0px;
	    padding: 5px 10px;
	}

	.list_item h4{
	    margin: 0
	}
</style>