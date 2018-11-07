$(function(){
    // $('#image-cropper').cropit({ imageState: { src: { imageSrc } } });
    // $('#image-cropper').cropit();

//     $('#image-cropper').cropit();\
// \
//     $('#form-perfil').submit(function(event) {\
//         var imageData = $('#image-cropper').cropit('export');\
//         $('.image-thumbnail').val(imageData);\
//     });\
// \
//     $('.imagen-logo').click(function(event) {\
//         $('.cropit-preview-image').attr('src', '');\
//         $('.image-thumbnail').val('');\
//     })\

    var imagesPreview = function(input, img) {
        var image = $(img);
        if (input.files) {
            var filesAmount = input.files.length;
            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    image.cropper('destroy');
                    image.attr('src', this.result);
                    image.cropper({
                        aspectRatio: 1 / 1,
                        cropBoxResizable: false,
                        crop: function(e) {
                            var imageData = image.cropper('getCroppedCanvas').toDataURL();
                            $('.image-thumbnail').val(imageData);
                        },
                    });
                }

                reader.readAsDataURL(input.files[i]);
            }
        }
    };

    $('.imagen-logo').on('change', function(event) {
        imagesPreview(this, '.show-image');
    });
})
