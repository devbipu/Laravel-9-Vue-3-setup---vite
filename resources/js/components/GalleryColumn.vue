<template>
	<div>
		<div class="my-4" v-if="allImages">
			<button class="btn btn-sm btn-danger" @click="bulkDeletes()">Delete Selected Item</button> &nbsp;
		</div>
		<div class="row g-3" :key="re_render">
			<div class="col-md-3" v-for="img in allImages">
		        <div class="gallery_img_wrapper">
		            <div class="gallery_tools_wrap">
		                <div class="gallery_tools_inner">
		                    <input type="checkbox" class="form-check-input" v-model="fileIds" :value="img.id">
		                    <span class="tools_triger">
		                        <img src="/assets/28-info-outline.webp" width="30" @click="gToolShow">
		                    </span>
		                </div>
		                <div class="tools">
		                    <div class="list-group">
		                        <button type="button" class="list-group-item list-group-item-action d-none">Info</button>
		                        <button type="button" class="list-group-item list-group-item-action" @click="deleteFile(img.id)">Delete</button>
		                        <a :href="img.view_path" class="list-group-item list-group-item-action" download>Download</a>
		                        <button type="button" class="list-group-item list-group-item-action" @click="copyImgLink(img.view_path)">Copy Link</button>
		                    </div>
		                </div>
		            </div>
		            <video v-if="img.file_extesion == 'mp4' " class="w-100" :src="img.view_path" controls></video>
		            <img v-else :src="img.view_path" class="w-100 images">
		            <div class="mt-1">
		                <h6 class="mb-0">{{img.orginal_name}}</h6>
		                <span class="text-muted">{{ (img.file_size / (1024 * 1024)).toFixed(2) }} MB</span>
		            </div>
		        </div>
		    </div>
		</div>
	</div>
</template>

<script>
	import { ref, computed, defineComponent } from 'vue';
	import { callApi, callApi__CFR, __notify  } from '@/composables';
    import { useStore } from 'vuex';
    import { useClipboard } from '@vueuse/core'
	export default defineComponent({
		name: "Gallery-Single",
		setup(props){
			const re_render = ref(0);
			const store = useStore();
			const fileIds = ref([]);
            const allImages = ref(null);
            const gToolShow = (e) => {
                e.target.parentNode.parentNode.parentNode.classList.toggle('show_tools');
            }
            //Get images
            const  getImages = async () => {
                const res  = await callApi('get', '/api/getimages');
                allImages.value = res.data.images
            }
            getImages();
            const deleteFile =  async (id) => {
            	const res = await callApi__CFR('post', '/api/deletefile', {fileId: id});
            	if (res.status) {
            		__notify("File Deleted Successfully")
            	}else{
            		__notify("File Not Deleted", '', 'error')
            	}
            }
            //Bulk delete
            const bulkDeletes = async () => {
            	const res = await callApi__CFR('post', '/api/bulkdeletes', {ids: fileIds.value});
            	if (res.status) {
            		__notify("File Deleted Successfully")
            	}else{
            		__notify("File Not Deleted", '', 'error')
            	}
            };

            //Download Images
            const downReq = async(event, id) => {
                const req = await callApi('get', `/api/filedownload/${id}`);
                if (req.status == 200) {
                    console.log(req.data);
                    const url = window.URL.createObjectURL(new Blob([req.data.downloadLink]));
                      const link = document.createElement('a');
                      link.href = req.data.downloadLink;
                      link.setAttribute('download', req.data.downloadLink);
                      document.body.appendChild(link);
                      link.click();
                }
            }

            const copyImgLink = (url) => {
                navigator.clipboard.writeText(window.location.host + url)
                __notify("Link Copyed");
            }
            // const source = ref()

            return {
            	gToolShow,
            	allImages,
            	deleteFile,
            	re_render,
            	fileIds,
            	bulkDeletes,
                downReq,
                copyImgLink
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
            min-height: 245px;
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

    .gallery_img_wrapper img.images{
    	height: 200px;
    	object-fit: contain;
    }
</style>