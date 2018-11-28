$(document).ready(function () {

    console.log("in javascript file");

    // Get the reviewModal
    var reviewModal = document.getElementById("reviewModal");
    // var commentModal = document.getElementById("commentModal");

    // Get the button that opens the reviewModal
    var reviewButton = document.getElementById("writeReviewButton");
    // var commentButton = document.getElementById("writeCommentButton");

    // Get the <spanReview> element that closes the reviewModal
    var spanReview = document.getElementsByClassName("closeReview")[0];
    var spanComment = document.getElementsByClassName("closeComment")[0];

    console.log(reviewButton);

    // When the user clicks the button, open the reviewModal
    // commentButton.onclick = function () {
    //     commentModal.style.display = "block";
    // };
    reviewButton.onclick = function () {
        reviewModal.style.display = "block";
    };


    // When the user clicks on <spanReview> (x), close the reviewModal
    spanReview.onclick = function () {
        reviewModal.style.display = "none";

    };

    spanComment.onclick = function () {
        commentModal.style.display = "none";

    };

    // When the user clicks anywhere outside of the reviewModal, close it
    window.onclick = function (event) {
        if (event.target == reviewModal) {
            reviewModal.style.display = "none";
        }
        if (event.target == commentModal) {
            commentModal.style.display = "none";
        }
    }})

    // $("#writeReviewButton").click(function(){
    //     $("#reviewModal").reviewModal({backdrop: true});
    // });}
