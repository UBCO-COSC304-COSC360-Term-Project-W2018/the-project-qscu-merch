
$(document).ready(function () {

    // Get the modal
    var commentModal = document.getElementById('commentModal');

    // Get the button that opens the modal
    var writeCommentButton = document.getElementById("writeCommentButton");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];


    writeCommentButton.onclick= function (){
        commentModal.style.display = "block"
    };

    // When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        commentModal.style.display = "none";
    };

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == commentModal) {
            commentModal.style.display = "none";
        }
    }
});