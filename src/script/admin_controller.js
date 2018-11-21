let page = 0;

window.onload = function () {


    let rbProductName = $("#rbProductName");
    let rbProductCategory = $("#rbProductCategory");
    let rbUserName = $("#rbUserName");
    let rbEmail = $("#rbUserEmail");
    let rbPostTitle = $("#rbPostTitle");
    let rbPost = $("#rbPost");
    let productList = $("#productList");
    let userList = $("#userList");
    let postList = $("#postList");



    $("#btnProducts").on('click', function () {
        if (page != 0) {
            changePanel("productList");
        }
    });

    $("#btnUsers").on('click', function () {
        if (page != 1) {
            changePanel("userList");

        }

    });

    $("#btnPosts").on('click', function () {
        if (page != 2) {
            changePanel("postList");

        }
    });

    $("#btnAdminJunk").on('click', function () {


    });

    function changePanel(nextPage) {
        switch (nextPage) {
            case "productList": {
                page = 0;
                break;
            }
            case "userList": {
                page = 1;
                break;
            }
            case "postList": {
                page = 2;
                break;
            }
        }
        if (page === 0) {
            productList.show();
            searchProduct(true);
        } else {
            productList.hide();
            searchProduct(false);
        }

        if (page === 1) {
            userList.show();
            searchUserRB(true);
        } else {
            userList.hide();
            searchUserRB(false);
        }

        if (page === 2) {
            postList.show();
            searchPostRB(true);
        } else {
            postList.hide();
            searchPostRB(false);
        }
    }

    function searchProduct(enable) {
        rbProductName.prop('disabled', !enable);
        rbProductName.prop('checked', enable);
        rbProductCategory.prop('disabled', !enable);
        rbProductCategory.prop('checked', false);
    }

    function searchUserRB(enable) {
        rbUserName.prop('disabled', !enable);
        rbUserName.prop('checked', enable);
        rbEmail.prop('disabled', !enable);
        rbEmail.prop('checked', false);
    }

    function searchPostRB(enable) {
        rbPostTitle.prop('disabled', !enable);
        rbPostTitle.prop('checked', enable);
        rbPost.prop('disabled', !enable);
        rbPost.prop('checked', false);
    }
}

function getProductList() {
    var results = $.get("/src/action/getProductList.php?searchInput=p&searchType=productName&buildType=grouped");
    results.done(function (data) {
        console.log(data);

    });
    results.fail(function (jqXHR) {
        console.log("Error: " + jqXHR.status);
    });
    results.always(function () {
        console.log("done");
    });
}


function buidProductItem(json) {
    let table = $("<table class='productlist'>");
    let row = $("<tr></tr>");
    for (let i = 0; i < 4; i++) {
        let pname = $("<td class='productName' colspan='2'></td>");
        let pprice = $("<td class='productPrice'></td>");
        let pquantity = $("<td class='productQuantity'></td>");
    }
}
;


//
// <table class="productItem">
//     <tr>
//     <td class="productName" colspan="2">
//     <span>product name</span>
// </td>
// <td class="productPrice">
//     <span>Price</span>
//     </td>
//     <td class="productQuantity">
//     <span>Quantity</span>
//     </td>
//     </tr>
//     <tr>
//     <td rowspan="3" class="productImage">
//     <img src="">
//     </td>
//     <td class="productSize">
//     <span>Small</span>
//     </td>
//     <td class="productPrice">
//     <span>1.3</span>
//     </td>
//     <td class="productQuantity">
//     <span>4</span>
//     </td>
//     </tr>
//     <tr>
//     <td class="productSize">
//     <span>Medium</span>
//     </td>
//     <td class="productPrice">
//     <span>1.3</span>
//     </td>
//     <td class="productQuantity">
//     <span>4</span>
//     </td>
//     </tr>
//     <tr>
//     <td class="productSize">
//     <span>Large</span>
//     </td>
//     <td class="productPrice">
//     <span>1.3</span>
//     </td>
//     <td class="productQuantity">
//     <span>4</span>
//     </td>
//     </tr>
//     <tr>
//     <td>
//     <button>Edit</button>
//     </td>
//     <td class="productSize">
//     <span>Extra Large</span>
// </td>
// <td class="productPrice">
//     <span>1.3</span>
//     </td>
//     <td class="productQuantity">
//     <span>4</span>
//     </td>
//     </tr>
//     </table>