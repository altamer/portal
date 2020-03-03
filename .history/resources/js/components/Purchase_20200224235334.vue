<template>


        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    
            Purchase component   

<div class="container">
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-header">Upload File</div>

                <div class="card-body">
                     

                        <div class="row mb-4">
                          <div class="col-md-3" id="imgmain" v-if="image">
                              <img :src="image" class="img-responsive" height="70" width="90">
                           </div>
                          <div class="col-md-9">
                              <input type="file" v-on:change="onImageChange" id="imginput" class="form-control">
                          </div>
                          
                       </div>

                       <div class="row mb-4">
                             <div class="col-md-12">
                             <button class="btn btn-success btn-block" @click="uploadImage">Upload Image</button>
                             </div>
                          </div>  
                          <div v-if="success != ''" class="alert alert-success" role="alert">
                          {{success}}
                        </div> 
                </div>
            </div>
        </div>
    </div>
                </div>                
            </div>
        </div>
    </template>

<script>
    export default {
        data(){
            return {
                image: '',
                success: ''
            }
        },
        methods: {
            onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
                this.success = '';
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            uploadImage(){
                let currentObj = this;
                axios.post(axios.defaults.baseURL + '/image/store',{image: this.image}).then(response => {
                    
                    

                    document.getElementById("imginput").value = "";
                    currentObj.success = response.data.success;
                    setTimeout(function(){ currentObj.success = ""; }, 3000);
                   
                })
            }
        }
    }
</script>




