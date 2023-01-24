<template>
	<div class="drag_wrapper">
        <div class="drag-area" draggable 
	        @drop.prevent="onDrop($event)"
	        @dragover.prevent="onDropOver($event)"
	        @dragleave.prevent="onDragLeave($event)" 
        >
            <div id="dragHeader">Drag & Drop to Upload Image</div>
            <!-- <span>OR</span> -->
            <!-- <button id="fileOpener"  @click="fileOperByClick()">Browse Image</button> -->
            <input type="file" id="dragFiles" hidden>
        </div>
    </div>
</template>


<script>
	
    import { ref, reactive, defineComponent } from 'vue';
    import { useRouter } from "vue-router"
    import { useStore } from "vuex"
    import { callApi, __notify } from '@/composables'
	export default{ 
		name: "FileUploader",
		setup(){
            const router = useRouter();
            const store = useStore();
			const droppedFile = ref([]);
            const fileOperByClick = () => {
                document.querySelector("#dragFiles").click()
            }
            const onDragStart= (e) => {
                document.querySelector(".drag-area").classList.add("active");
                document.querySelector("#dragHeader").textContent = "Release to Upload File";
            }
            const onDragLeave = (e) => {
                console.log('drag out');
                document.querySelector(".drag-area").classList.remove("active");
                document.querySelector("#dragHeader").textContent = "Drag & Drop to Upload File";
            }
            const onDropOver = (e) => {
                document.querySelector(".drag-area").classList.add("active");
                document.querySelector("#dragHeader").textContent = "Release to Upload File";
            }
            const onDrop = (e) => {
                const files = e.dataTransfer.files;
                
                for (var i = 0; i < files.length; i++) {
                   droppedFile.value.push(files[i]);
                }
                droppedFile.value.forEach((el) => {
                    let datas = new FormData()
                    datas.append('img', el);
                    axios.post('/api/imgupload', datas).then((res) => {
                        store.dispatch('setupComponentKey', 1);
                        __notify("Upload Successfull")
                    }).catch((er) => {
                        __notify("Something went wrong", '', 'error')
                    })
                })
            }
            return {
            	onDragStart, onDragLeave, onDropOver, onDrop
            }
		}
	}
</script>

<style scoped>
	.drag_wrapper{
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 300px;
      background: #24c5a1e0;
      border-radius: 15px;
    }
    .drag-area {
        border: 2px dashed #000000;
        height: 250px;
        width: calc(100% - 50px);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }
    .drag-area.active{
      border: 2px solid #fff;
      background: rgb(1 2 2 / 17%);
    }
    .drag-area .icon{
      font-size: 100px;
      color: #fff;
    }
    .drag-area #dragHeader{
      font-size: 18px;
      font-weight: 500;
      color: #fff;
    }
    .drag-area span{
      font-size: 14px;
      font-weight: 500;
      color: #fff;
      margin: 10px 0 15px 0;
    }
    .drag-area button{
      padding: 10px 25px;
      font-size: 15px;
      font-weight: 500;
      border: none;
      outline: none;
      background: #fff;
      color: #5256ad;
      border-radius: 5px;
      cursor: pointer;
    }
    .drag-area img{
      height: 100%;
      width: 100%;
      object-fit: cover;
      border-radius: 15px;
    }
</style>