<html>
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>ImgurDemo</title>
    </head>
    <body>
        <div id="app">                  
            <div class="form-group">
                <input type="hidden" name="_token" value="{{csrf_token()}}" v-model="token">
            </div>                
            <div class="form-group">
                <input id="file_img_tmp" accept="image/*" name="file_img_tmp" type="file" v-on:change="onFileChange">
                <span>選擇檔案後會自動上傳檔案，並將自動填入主圖片連結</span>
            </div>
            <div class="form-group">
                <input type="text" size="200" class="form-control author-photo-url" id="photo_url" v-model="photoUrl">
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/vue@2.5.13/dist/vue.js"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>


        <script>
        var app = new Vue({
            el: "#app",   
            data: {        
                token:'{{csrf_token()}}',
                photoUrl:''
            },
            methods: {
                onFileChange(event) {
                    let formData = new FormData()
                    let imagefile = document.querySelector('#file_img_tmp')
                    formData.append('file', imagefile.files[0])
                    
                    axios.post("{{env('APP_URL')}}/imgur/upload", formData)
                            .then(response => {
                                this.photoUrl = response.data.url
                                document.querySelector('#file_img_tmp').value = ''
                            })
                            .catch(error => {
                                alert(error.response.data.msg)
                            });
                }
            }
        });
        </script>



    </body>
</html>
