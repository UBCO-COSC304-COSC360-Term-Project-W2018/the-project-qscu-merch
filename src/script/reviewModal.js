let productNum;
let date;
let isUser;

let comid;
let compd;

let timmer = setInterval(function () {
    if(productNum){
        getNewPosts(productNum);
    }
}, 5000);


function onWriteReview() {
    let reviewModal = $('#reviewModal');
    reviewModal.show();

    let spanReview = $('.closeReview')[0];

    spanReview.onclick = function () {
        reviewModal.hide();

    };

}

function onWriteComment(uid, pno) {
    comid = uid;
    compd = pno;

    let commentModal = $('#commentModal');
    commentModal.show();


    var spanComment = $('.closeComment')[0];

    spanComment.onclick = function () {
        commentModal.hide();

    };
}


function onCommentSubmit() {

    let commentStatus = $('#statusHolderComment');

    let commentInput = $("#commentInput").val().trim();


    if (comid && compd) {
        if (commentInput.length < 1) {
            commentStatus.html('<p>Comment field must not be empty</p>');
        } else {

            let commentSubmitButton = $('#commentSubmitButton');
            commentSubmitButton.attr("disabled", "disabled");

            let data = {
                'action': 'setComment',
                'userReviewInput': commentInput,
                'pno': compd,
                'uid': comid,
            };

            $.ajax({
                url: "action/setReview.php",
                method: "post",
                data: data,


                beforeSend: function () {

                    commentStatus.html("<p>Sending...</p>");
                    commentStatus.addClass("loading");

                },
                success: function (results) {
                    console.log(results);
                    commentStatus.removeClass("loading");
                    if (results.status == "success") {
                        commentStatus.addClass("success");
                        commentStatus.html("<p>Your review has been posted!</p>");
                        commentSubmitButton.removeAttr("disabled");
                        $("#commentInput").val('')
                    } else {
                        commentStatus.addClass("fail");
                        commentStatus.html('<p>' + results.msg + '</p>');
                        commentSubmitButton.removeAttr("disabled");
                    }

                }

            });


        }
    }
}

function onReviewSubmit() {


    let reviewSubmitButton = $("#reviewSubmitButton");
    let reviewStatus = $('#statusHolderReview');

    let commentInput = $("#reviewInput").val().trim();
    let ratingInput = $("#ratingInput").val();

    if (commentInput.length < 1 || 1 > ratingInput || ratingInput > 5) {
        let str = 'The following fields must not be empty ';
        str = (commentInput.length < 1) ? str + 'Product review,' : str;

        str = (1 > ratingInput || ratingInput > 5) ? str + ' Product rating ' : str;
        reviewStatus.html(str);

    } else {
        reviewSubmitButton.attr("disabled", "disabled");

        let data = {
            'action': 'setReview',
            'userRatingInput': ratingInput,
            'userReviewInput': commentInput,
            'pno': productNum,
        };

        $.ajax({
            url: "action/setReview.php",
            method: "post",
            data: data,

            beforeSend: function () {

                reviewStatus.html("<p>Sending...</p>");
                reviewStatus.addClass("loading");

            },
            success: function (results) {

                console.log("res is ");
                console.log(results)
                reviewStatus.removeClass("loading");
                if (results.status == "success") {
                    reviewStatus.addClass("success");
                    reviewStatus.html("<p>Your review has been posted!</p>");
                    reviewSubmitButton.removeAttr("disabled");
                } else {
                    reviewStatus.addClass("fail");
                    reviewStatus.html('<p>' + results.msg + '</p>');
                    reviewSubmitButton.removeAttr("disabled");
                }

            }
        });
    }
}

$(document).ready(function () {
    productNum = $("#reviewPNO").val();
    isUser = ($('#UserLoggedIn').length) ? true : false;


    loadReveiws(productNum);


    let commentModal = $('#commentModal');
    let reviewModal = $('#reviewModal');


    window.onclick = function (event) {

        if (event.target == reviewModal[0]) {
            reviewModal.hide();
        }
        if (event.target == commentModal[0]) {
            commentModal.hide();
        }
    }
    timmer
});


function loadReveiws(pno) {

    obj = {
        'action': 'loadAll',
        'pno': pno
    };

    $.post('action/getProductReview.php', JSON.stringify(obj))
        .done(function (data) {
            date = data[0];
            console.log(date)
            let reviewBlock = $('#reviewsContent');
            data.forEach(function (value, index, array) {
                if (index != 0) {
                    let review = buildReview(value);
                    reviewBlock.append(review)
                }
            });
        }).fail(function (jqXHR) {
        console.log(jqXHR)

    })
}

function getNewPosts(pno) {
    obj = {
        'action': 'loadNew',
        'date': date,
        'pno': pno
    };

    $.post('action/getProductReview.php', JSON.stringify(obj))
        .done(function (data) {
            let reviewBlock = $('#reviewsContent');
            console.log(data)

            data.rev.forEach(function (value, index, array) {
                reviewBlock.prepend(buildReview(value, false))
            });

            data.com.forEach(function (value, index, array) {
                $('#' + value.uid + '' + value.pno + 'ReviewComments').prepend(buildComment(value));
            })

            date = data.date;


        }).fail(function (xhr, status, error) {
        console.log('jqXHR');
    })

}

//add to  <section id="reviews">
function buildReview(json, withComment = true) {

    let rev = $('<div class="review"></div>');
    let pro = $('<p class="userProfile"></p>');

    pro.append($('<img src="data:' + json.contentType + ';base64,' + json.image + '" alt="Users Profile Picture" align="middle">'));
    pro.append($('<span> ' + json.fname + ' </span>'));
    pro.append($('<time datetime="' + json.data + '"> -' + json.date + '</time>'));

    if (isUser) {
        pro.append($('<button title="Add Comment" alt="Add Comment" class="pageButtons" onclick="onWriteComment(' + json.uid + ',' + json.pno + ')"><span class="fa fa-comments-o"></span></button>'));
    }
    rev.append(pro);

    pro = $('<p class="userRating"></p>');
    for (let i = 0; i < 5; i++) {
        if (i <= json.rating) {
            pro.append('<span class="fa fa-star checked"></span>');
        } else {
            pro.append('<span class="fa fa-star"></span>');
        }
    }

    rev.append(pro);

    rev.append($('<p class="reviewTitle">' + json.fname + ' says:</p>'));
    rev.append('<p class="reviewDescription">' + json.comment + '</p>');

    let comments = $('<div class="comments" id ="' + json.uid + '' + json.pno + 'ReviewComments' + '"></div>');

    if (withComment) {
        console.log(json);
        json.posts.forEach(function (val, index, array) {
            let temp1 = buildComment(val)
            comments.append(temp1)
        })
    }

    rev.append(comments);
    return rev;
}

function buildComment(json) {
    let comment = $('<div class="comment">');
    comment.append('<p class="userProfile"><img src="data:' + json.contentType + ';base64,' + json.image + '" alt="Users profile picture" align="middle">' + json.fname + ' <time datetime="' + json.date + '">- ' + json.date + '</time></p>');
    comment.append('<p class="reviewDescription">' + json.comment + '</p>');

    return comment;
}




