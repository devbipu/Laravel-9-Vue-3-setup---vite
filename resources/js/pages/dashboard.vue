<template>
	<div class="container">
        <div class="row mt-4">
            <div class="col-sm-3">
                <div class="col-md-12 bg-light rounded shadow-sm">
                    <ProfileCard />
                </div>
            </div>
            <div class="col-sm-9">
                <div class="col-sm-12 bg-light p-3 rounded shadow-sm">
                    <h4>Welcome to your dashboard</h4>
                    <div class="my-3">
                        <FileUploader />
                    </div>
                    <div class="mt-2">
                        <GalleryColumn/>
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
    import ProfileCard from '@/components/ProfileCard.vue';
    import FileUploader from '@/components/FileUploader.vue';

	export default defineComponent({
        components: {
            GalleryColumn,
            ProfileCard,
            FileUploader
        },
		setup(){
            const router = useRouter();
            const store = useStore();
            const user = reactive(JSON.parse(store.getters.getUser));


            // return of components
			return{
                user,
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
</style>