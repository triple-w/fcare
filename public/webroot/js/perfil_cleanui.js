$(function(){
    // $('#image-cropper').cropit({ imageState: { src: { imageSrc } } });
    // $('#image-cropper').cropit();

    $('#image-cropper').cropit();

    $('#form-perfil').submit(function(event) {
        var imageData = $('#image-cropper').cropit('export');
        $('.image-thumbnail').val(imageData);
    });

    $('.imagen-logo').click(function(event) {
        $('.cropit-preview-image').attr('src', '');
        $('.image-thumbnail').val('');
    })

})
