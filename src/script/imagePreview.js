function readURL(input) {

    if (input.files && input.files[0]) {
        let reader = new FileReader();

        reader.onload = function(e) {
            $('#imagePreview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function resetPreview(){
    $('#imagePreview').attr('src', "");
}


$( document ).ready(function() {
    $("#uploadImage").change(function() {
        readURL(this);
    });
});

