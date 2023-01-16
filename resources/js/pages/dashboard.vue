<template>
	<div class="container">
        <div class="row mt-4">
            <div class="col-sm-3">
                <div class="col-md-12 bg-light rounded shadow-sm">
                    <div class="card">
                        <div class="card_background_img"></div>
                        <div class="card_profile_img" :style="`background-image:url(${user.avatar ? user.avatar.view_path : null})`"></div>
                        <div class="user_details">
                            <h3>{{user.name}}</h3>
                            <p>{{user.email}}</p>
                        </div>
                        <div class="card_count">
                            <div class="count">
                                <div class="fans">
                                    <h3>2.4M</h3>
                                    <p>Fans</p>
                                </div>
                                <div class="following">
                                    <h3>202</h3>
                                    <p>Followings</p>
                                </div>
                                <div class="post">
                                    <h3>552</h3>
                                    <p>Posts</p>
                                </div>
                            </div>
                             <div class="btn_cs" @click="logout()">Logout</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-9">
                <div class="col-sm-12 bg-light p-3 rounded shadow-sm">
                    <h4>Welcome to your dashboard</h4>
                    <div>
                       <!--  <form @submit.prevent="formHandler" enctype="multipart/form-data">
                            <table class="table table-border">
                                <thead>
                                    <tr>
                                        <th>File</th>
                                        <th>Fize Size</th>
                                        <th>Uploaded</th>
                                        <th>Upload Remain</th>
                                        <th>Upload Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="file" class="form-control" name="userAvarter" @change="inputHandler">
                                        </td>
                                        <td>{{imgInfo.fileSize}}</td>
                                        <td>{{imgInfo.uploaded}}</td>
                                        <td>{{imgInfo.uploadRemain}}</td>
                                        <td>{{imgInfo.uploadStatus}}</td>
                                        <td><button class="btn btn-primary" type="submit">Upload</button></td>
                                    </tr>
                                </tbody>
                            </table>                        
                        </form> -->
                    </div>
                    <div class="my-3">
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
                    </div>
                    <div class="mt-2">
                        <GalleryColumn v-if="allImages" :async-data="allImages"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { ref, reactive, defineComponent } from 'vue';
    import { useRouter } from "vue-router"
    import { useStore } from "vuex"
    import { callApi, __notify } from '@/composables'
    import GalleryColumn from '@/components/GalleryColumn.vue'


	export default defineComponent({
        components: {
            GalleryColumn,
        },
		setup(){
            const router = useRouter();
            const store = useStore();
            const user = reactive(JSON.parse(store.getters.getUser));
            const imgInfo = reactive({
                fileSize: null,
                uploaded: null,
                uploadRemain: null,
                uploadStatus: false,
            })
            const image = ref('');
            const avtImg = ref('');
            const allImages = ref(null);
            const dropped_file = ref([]);



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
                   dropped_file.value.push(files[i]);
                }
                // console.log(dropped_file.value);
                dropped_file.value.forEach((el) => {
                    let datas = new FormData()
                    datas.append('img', el);
                    axios.post('/api/imgupload', datas).then((res) => {
                        store.dispatch('setupComponentKey', 1);
                        console.log(res);
                    }).catch((er) => {
                        console.log(er)
                    })
                })
            }




            const logout = async() => {
                axios.post('/api/logout', {id: user.id}).then((res) => {
                    console.log(res);
                    store.dispatch('removeToken')
                    store.dispatch('removeUser')
                    router.push({name: 'Login'})
                })
            }
            //file upload
            const inputHandler = (e) => {
                image.value = e.target.files[0];
                imgInfo.fileSize = (e.target.files[0].size / (1024 * 1024)).toFixed(2) + " MB";
                //console.log(image.value)
            }

            const formHandler = async (e) => {
                let datas = new FormData();
                datas.append('img', image.value);
                let postConfig = {
                    headers: {'content-type': "mulitpart/form-data"},
                    onUploadProgress: (progress) => {
                        imgInfo.uploaded = (progress.loaded / (1024 * 1024)).toFixed(2) + " MB";
                        imgInfo.uploadRemain = ((progress.total - progress.loaded) / (1024 * 1024)).toFixed(2) + " MB"; 
                    }
                }
                store.dispatch('setLoading', true)
                axios.post ('/api/imgupload', datas, postConfig).then((uploadStatus) => { 
                    store.dispatch('setupComponentKey', 1);
                    avtImg.value = uploadStatus.data.FileName;
                    imgInfo.uploadStatus = true;
                    store.dispatch('setLoading', false)
                    __notify('File Uploaded Successfully')
                    console.log(uploadStatus);
                }).catch((er) => {
                    __notify("File Not Uploaded", '', 'error')
                    store.dispatch('setLoading', false)
                    console.log(er);
                })
            }

            //Get images
            const  getImages = async () => {
                const res  = await callApi('get', '/api/getimages');
                allImages.value = res.data.images
            }
            getImages();

            //drag files
            const dargInit = () => {
                console.log("onUpdated")
                //Get DOM Elements
                const dropArea = document.querySelector(".drag-area");
                const dragText = document.querySelector("#dragHeader");
                const button = document.querySelector("#fileOpener");
                const input = document.querySelector("#dragFiles");
                let file; 
                //on click open file selector
                console.log(dropArea);
                input.onchange = () => {
                  file = this.files[0];
                  dropArea.classList.add("active");
                  showImage(); 
                };

                //on drag over
                // dropArea.ondragover = (event) => {
                //   event.preventDefault();
                //   dropArea.classList.add("active");
                //   dragText.textContent = "Release to Upload File";
                // };

                //on drag leave
                // dropArea.ondragleave = () => {
                //   dropArea.classList.remove("active");
                //   dragText.textContent = "Drag & Drop to Upload File";
                // };

                // //on drop
                // dropArea.ondrop = (event) => {
                //   event.preventDefault();
                //   file = event.dataTransfer.files[0];
                //   showImage();
                // };


                //change the image to droped imagege
                const showImage = () => {
                  let fileType = file.type;
                  let validFiletypes = ["image/jpeg", "image/jpg", "image/png"];
                  
                  if(validFiletypes.includes(fileType)){
                    let fileReader = new FileReader();
                    fileReader.readAsDataURL(file);
                    fileReader.onload = ()=>{
                        let fileURL = fileReader.result;
                        let image = `<img src="${fileURL}" alt="image">`;
                        dropArea.innerHTML = image;
                        }
                    }
                  else{
                    alert("This is not an Image File!");
                    dropArea.classList.remove("active");
                    dragText.textContent = "Drag & Drop to Upload File";
                  }
                }
            }


            // return of components
			return{
				logout,
                store,
                user,
                formHandler,
                inputHandler,
                avtImg,
                imgInfo,
                allImages,
                fileOperByClick,
                onDragStart,
                onDragLeave,
                onDrop,
                onDropOver,
                dropped_file
			}
		}
	});
</script>

<style>
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


    /*  profile  */
    .card_profile_img {
        width: 120px;
        height: 120px;
        background-color: #868d9b;
        background: url("https://source.unsplash.com/7Sz71zuuW4k");
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        border: 2px solid #ffffff;
        border-radius: 120px;
        margin: 0 auto;
        margin-top: -60px;

    }
    .card_background_img {
        width: 100%;
        height: 180px;
        background-color: #e1e7ed;
        background: url("https://source.unsplash.com/9wg5jCEPBsw");
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
    }
    .user_details p {
        margin-bottom: 20px;
        margin-top: -5px;
    }
    .user_details {
        padding: 0 29px;
    }
    .user_details h3 {
        margin-top: 10px;
    }
    .card_count {
        padding: 30px;
        border-top: 1px solid #dde1e7;
    }
    .count {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
    }
    .count p {
        margin-top: -10px;
    }
    .btn_cs {
        padding: 16px;
        width: 100%;
        border: none;
        outline: none;
        border-radius: 4px;
        background-color: #24c5a1;
        color: #ffffff;
        cursor: pointer;
        text-align: center;
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
    }

</style>