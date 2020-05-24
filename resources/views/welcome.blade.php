<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
@if (Route::has('login'))
    <div class="top-right links">
        @auth
            <a href="{{ url('/home') }}">Home</a>
        @else
            <a href="{{ route('login') }}">Login</a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}">Register</a>
            @endif
        @endauth
    </div>
@endif

<div class="content" id="crop-demo">
    <section class="container">
        <div class="row text-center">
            <h2 class="col-md-12">Crop demo</h2>
            <div class="col-md-6 mx-auto">
                <div class="tools" v-if="cropElementIs('cats1') && crop_mode">
                    <button type="button" class="btn btn-danger" @click="cancelCrop">Cancel</button>
                    <button type="button" class="btn btn-primary" @click="saveCrop">Crop image</button>
                </div>
                <img src="{{ asset('images/cats1.jpg') }}" alt="catssss" @click="toggleCrop" id="cats1">
            </div>
            <div class="col-md-6 mx-auto">
                <div class="tools" v-if="cropElementIs('cats2') && crop_mode">
                    <button type="button" class="btn btn-danger" @click="cancelCrop">Cancel</button>
                    <button type="button" class="btn btn-primary" @click="saveCrop">Crop image</button>
                </div>
                <img src="{{ asset('images/cats2.jpg') }}" alt="catssss" @click="toggleCrop" id="cats2">
            </div>
        </div>
    </section>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script>
    imgUpdateRoute = "";
    let cropDemo = new Vue({
        el: '#crop-demo',
        data: {
            img_el: null, // image being cropped
            crop_el: null, // croppie object
            crop_mode: false // if something is being cropped
        },
        methods: {
            /**
             * toggle cropping of the clicked image
             *
             * @param event
             */
            toggleCrop(event) {
                // crop only one at a time
                if (this.crop_mode) {
                    return;
                }

                this.img_el = $(`#${event.target.id}`);

                // initialize the image to be cropped
                this.crop_el = this.img_el.croppie({
                    viewport: {width: 300, height: 300},
                    boundary: {width: 400, height: 400},
                    showZoomer: true,
                    enableResize: true,
                    enableOrientation: true,
                });

                this.crop_mode = true;

            },

            /**
             * Check image being cropped
             *
             * @param id
             * @returns {boolean}
             */
            cropElementIs(id) {
                return this.img_el ? (this.img_el.attr('id') === id) : false;
            },

            /**
             * Cancel cropping
             */
            cancelCrop() {
                this.crop_el.croppie('destroy');
                this.crop_mode = false;
            },

            /**
             * Save crop both on the client and server side
             */
            saveCrop() {
                // get cropped image as blob
                let result = this.crop_el.croppie('result', 'blob');

                result.then(function (blob) {
                    this.updateImageElement(blob);
                    this.updateImageOnServer(blob);
                }.bind(this));

                this.crop_el.croppie('destroy');
                this.crop_mode = false;
            },

            /**
             * Update image on the client side
             *
             * @param blob
             */
            updateImageElement(blob) {
                let src = URL.createObjectURL(blob);
                this.img_el.attr('src', src);
            },

            /**
             * Update image on the server side
             *
             * @param blob
             */
            updateImageOnServer(blob) {
                let formData = new FormData();

                formData.set('_method', 'PUT');

                // create image file and append to form data
                let imgFile = new File([blob], "image.png", {
                    type: 'image/png'
                });

                formData.append(this.img_el.attr('id'), imgFile);

                axios.post(imgUpdateRoute, formData).then(response => {
                    alert(response.data.message);
                }).catch(err => {
                    alert(err.response.data.message);
                });
            }
        }
    });
</script>
</body>
</html>
