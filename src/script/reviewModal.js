$(document).ready(function () {


    if($('#commentModal').length){
        var commentModal = document.getElementById("commentModal");
        var commentButton = document.getElementById("writeCommentButton");
        var spanComment = document.getElementsByClassName("closeComment")[0];

        // When the user clicks the button, open the reviewModal
            commentButton.onclick = function () {
            commentModal.style.display = "block";
        };

        spanComment.onclick = function () {
            commentModal.style.display = "none";

        };

    }
});


// Get the reviewModal
    var reviewModal = document.getElementById("reviewModal");

    // Get the button that opens the reviewModal
    var reviewButton = document.getElementById("writeReviewButton");

    // Get the <spanReview> element that closes the reviewModal
    var spanReview = document.getElementsByClassName("closeReview")[0];


    reviewButton.onclick = function () {
        reviewModal.style.display = "block";
    };


    // When the user clicks on <spanReview> (x), close the reviewModal
    spanReview.onclick = function () {
        reviewModal.style.display = "none";

    };


    // When the user clicks anywhere outside of the reviewModal, close it
    window.onclick = function (event) {
        if (event.target == reviewModal) {
            reviewModal.style.display = "none";
        }
        if (event.target == commentModal) {
            commentModal.style.display = "none";
        }
    }

    // $("#writeReviewButton").click(function(){
    //     $("#reviewModal").reviewModal({backdrop: true});
    // });
});