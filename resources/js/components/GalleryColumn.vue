<template>
	<div class="row g-3" :key="re_render">
		<div class="col-md-3" v-for="img in images">
	        <div class="gallery_img_wrapper">
	            <div class="gallery_tools_wrap">
	                <div class="gallery_tools_inner">
	                    <input type="checkbox" class="form-check-input" :img_id="img.id">
	                    <span class="tools_triger">
	                        <img src="/assets/28-info-outline.webp" width="30" @click="gToolShow">
	                    </span>
	                </div>
	                <div class="tools">
	                    <div class="list-group">
	                        <button type="button" class="list-group-item list-group-item-action">Info</button>
	                        <button type="button" class="list-group-item list-group-item-action" @click="deleteFile(img.id)">Delete</button>
	                        <button type="button" class="list-group-item list-group-item-action">Download</button>
	                        <button type="button" class="list-group-item list-group-item-action">Copy Link</button>
	                    </div>
	                </div>
	            </div>
	            <video v-if="img.file_extesion == 'mp4' " class="w-100" :src="img.view_path" controls></video>
	            <img v-else :src="img.view_path" class="w-100">
	            <div class="mt-1">
	                <h6 class="mb-0">{{img.orginal_name}}</h6>
	                <span class="text-muted">{{ (img.file_size / (1024 * 1024)).toFixed(2) }} MB</span>
	            </div>
	        </div>
	    </div>
	</div>
</template>

<script>
	import { ref, defineComponent } from 'vue';
	import { callApi, callApi__CFR  } from '@/composables';
    import { useStore } from 'vuex';
	export default defineComponent({
		name: "Gallery-Single",
		props: {
		    asyncData: {
		      type: Object,
		      required: true
		    },
		  },
		setup(props){
			const re_render = ref(0);
			const store = useStore();
            const gToolShow = (e) => {
                e.target.parentNode.parentNode.parentNode.classList.toggle('show_tools');
            }

            const deleteFile =  async (id) => {
            	const res = await callApi__CFR('post', '/api/deletefile', {fileId: id});
            }
            return {
            	gToolShow,
            	deleteFile,
            	re_render,
            	images: props.asyncData,
            }
		}
	});
</script>

<style scoped>
	 .gallery_img_wrapper {
        border: 1px solid #ddd;
        background: white;
        padding: 4px;
        border-radius: 3px;
        position: relative;
        overflow: hidden;
    }

    .gallery_tools_wrap .gallery_tools_inner {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }
    .gallery_tools_wrap {
        position: absolute;
        width: 95%;
        z-index: 1;
    }
    .gallery_tools_wrap input[type="checkbox"]{
        width: 1.4em;
        height: 1.4em;
        margin-top: 0;
        cursor: pointer;
    }
    span.tools_triger {
        cursor: pointer;
    }
    .gallery_tools_wrap .tools {
        background: white;
        border-radius: 8px;
        width: 90%;
        margin: auto;
        display: none;
    }
    .gallery_tools_wrap .tools .list-group-item {
        padding: 4px 15px;
    }
    .gallery_tools_wrap.show_tools .tools{
        display: block;
    }
    .gallery_tools_wrap.show_tools .tools_triger {background: #21ff98;border-radius: 5px;}
</style>