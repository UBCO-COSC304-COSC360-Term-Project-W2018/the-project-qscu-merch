$(document).ready(function () {
    var modal = document.getElementById('reviewModal');
    var btn = document.getElementById("writeReviewButton");
    var span = document.getElementsByClassName("close")[0];
    btn.onclick = function () {
        modal.style.display = "block";
    };
    span.onclick = function () {
        modal.style.display = "none";
    };
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});
// $(document).ready(function () {
//
//     // Get the modal
//     var reviewModal = document.getElementById('reviewModal');
//     // var commentModal = document.getElementById('commentModal');
//
//     // Get the button that opens the modal
//     var writeReviewButton = document.getElementById("writeReviewButton");
//     // var writeCommentButton = document.getElementById("writeCommentButton");
//
//     // Get the <span> element that closes the modal
//     var span = document.getElementsByClassName("close")[0];
//
//     // When the user clicks the button, open the modal
//     writeReviewButton.onclick = function () {
//         reviewModal.style.display = "block";
//     };
//
//     // writeCommentButton.onclick= function (){
//     //     commentModal.style.display = "block"
//     // };
//
//     // When the user clicks on <span> (x), close the modal
//     span.onclick = function () {
//         // commentModal.style.display = "none";
//         reviewModal.style.display = "none";
//     };
//
//     // When the user clicks anywhere outside of the modal, close it
//     window.onclick = function (event) {
//         if (event.target == reviewModal) {
//             // commentModal.style.display = "none";
//             reviewModal.style.display = "none";
//         }
//     }
// });
// Get the modal
// Get the button that opens the modal
// Get the <span> element that closes the modal
// When the user clicks the button, open the modal
// When the user clicks on <span> (x), close the modal
// When the user clicks anywhere outside of the modal, close it
