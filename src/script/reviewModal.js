$(document).ready(function () {

    var productNum = $("#reviewPNO").val();
    var userId = $("#reviewUID").val();
    var utcDate = new Date().toJSON().slice(0, 10).replace(/-/g, '/');


    $("#reviewSubmitButton").on('click', function (e) {

        $("reviewSubmitButton").attr("disabled", "disabled");
        e.preventDefault();
        var ratingField = document.getElementsByClassName("ratingInput");
        var reviewField = document.getElementsByClassName("reviewInput");
        // $sql = "INSERT INTO Reviews( uid, pNo, size, rating, comment, date, isEnabled) VALUES (?, ?, ?, ?, ?, ?, 1)";

        $.ajax({
            url: "action/setReview.php",
            method: "post",
            data: "pNo=" + userId + "&" +
                "pNo=" + productNum + "&" +
                "rating=" + $(ratingField).val() + "&" +
                "review=" + $(reviewField).val() + "&" +
                "date=" + $(utcDate).val(), //TODO: is this date format okay? @jasper
            // "size="+NULL + "&" + TODO: Is size a thing?
            beforeSend: function () {

                $("#statusHolder").html("<p>Sending...</p>");
                $("#statusHolder").addClass("loading");

            },
            success: function (res) {

                console.log(res);
                $("#statusHolder").removeClass("loading");
                var results = JSON.parse(res);
                if (results.status == "success") {
                    $("#statusHolder").addClass("success");
                    $("#statusHolder").html("<p>Your review has been posted!</p>");
                } else {
                    $("#statusHolder").addClass("fail");
                    $("#statusHolder").html("<p>Error, your review was not posted :( </p>");
                    $("reviewSubmitButton").removeAttr("disabled");
                }

            }
        });
        return false;
    });


    // Get the reviewModal
    var reviewModal = document.getElementById("reviewModal");
    // var commentModal = document.getElementById("commentModal");

    // Get the button that opens the reviewModal
    var reviewButton = document.getElementById("writeReviewButton");
    // var commentButton = document.getElementById("writeCommentButton");

    // Get the <spanReview> element that closes the reviewModal
    var spanReview = document.getElementsByClassName("closeReview")[0];
    // var spanComment = document.getElementsByClassName("closeComment")[0];

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

    // spanComment.onclick = function () {
    //     commentModal.style.display = "none";
    //
    // };

    // When the user clicks anywhere outside of the reviewModal, close it
    window.onclick = function (event) {
        if (event.target == reviewModal) {
            reviewModal.style.display = "none";
        }
        // if (event.target == commentModal) {
        //     commentModal.style.display = "none";
        // }
    }
});