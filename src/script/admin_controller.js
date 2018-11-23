let page = 0;
let searchType = "userEmail";
let showAddProduct = false;


$(document).ready(function () {
    let rbProductName = $("#rbProductName");
    let rbProductCategory = $("#rbProductCategory");
    let newProduct = $("#newProduct");

    let rbUserName = $("#rbUserName");
    let rbEmail = $("#rbUserEmail");

    let rbPostTitle = $("#rbPostTitle");
    let rbPost = $("#rbPost");
    let productList = $("#productList");

    let userList = $("#userList");
    let postList = $("#postList");


    $("#btnProducts").on('click', function () {
        if (page != 0) {
            getProductList();
            changePanel("productList");
        }
    });

    $("#btnUsers").on('click', function () {
        if (page != 1) {
            getUserList();
            changePanel("userList");

        }

    });

    $("#btnPosts").on('click', function () {
        if (page != 2) {
            changePanel("postList");

        }
    });

    $("#addProduct").on('click', function () {
        if (page === 0) {
            if (showAddProduct) {
                newProduct.hide();
                $("#addProduct").html("Add Product");
                $("#formResetBtn").click();
                showAddProduct = false;
            } else {
                newProduct.show();
                $("#addProduct").html("Cancel");
                showAddProduct = true;
            }
        }
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
            newProduct.hide();
            $("#addProduct").html("Add Product");
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

    getProductList();

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


});

function onChangeStatus(uid) {
    let statusBtn = $("."+uid+"ChangeStatus");
    let banBtn = $("."+uid+"BanUser");
    let adminBtn = $("."+uid+"AdminUser");

    if(statusBtn.data('status')){
        banBtn.prop('disabled', true);
        adminBtn.prop('disabled', true);
        statusBtn.text('Change Status');
        statusBtn.data('status', false);
    }else {
        adminBtn.prop('disabled', false);
        banBtn.prop('disabled', false);
        statusBtn.text('Cancel');
        statusBtn.data('status', true);
    }

}
function onSendRecovery(uid) {

}
function onCopyRecovery(uid) {

}

function onRemoveImage(uid) {
    uid=11;
    //This doest work
    //TODO fix this
    let obj = {'image':'remove', 'userid': uid};

    $.post('action/editUser.php', JSON.stringify(obj))
        .done(function (data) {

        }).fail(function (jqXHR) {

    })

}
function onBanUser(uid) {

}
function onAdminUser(uid) {

}

function getUserList(search = "") {
    let results = $.get('/src/action/getUserList.php?searchInput=' + search + '&searchType=' + searchType);
    results.done(function (data) {
        console.log(data);
        let userTable = $("#userContent");

        userTable.empty();
        data.forEach(function (value, index, array) {
            let item = buildUserItem(array[index]);
            userTable.append(item);
        })
    })
    results.fail(function (jqXHR) {
        console.log("Error: " + jqXHR.status);
    })

}


function buildUserItem(json) {
    let table = $('<table></table>');

    let row = $('<tr></tr>');

    let image = $('<td class="'+ json.userid + 'ProfileImage" rowspan="2" colspan="2"><img class="'+json.userid+'ProfileImage" src="data:' + json.contentType + ';base64,' + json.profilePic + '" alt="User Profile Image"></td>');
    let name = $('<td>Name:</td><td colspan="2">'+json.firstName +' ' +json.lastName + '</td>')
    let email = $('<td>Email:</td><td>'+json.userEmail+'</td>')

    row.append(image);
    row.append(name);
    row.append(email);

    table.append(row);

    row = $('<tr></tr>');

    let text = 'enabled';
    if(json.isAdmin && json.isBanned){
        text = "user is inVaild"
    //    TODO fix invalid user
    }else if(json.isBanned){
        text = "Banned";
    }else if(json.isAdmin){
        text = "Admin"
    }

    let stat = $('<td>Account Status:</td><td><span class="'+json.userid+'UserStatus">'+text+'</span></td>');
    let cells1 = $('<td><button class="'+json.userid+'ChangeStatus" data-status="false" onclick="onChangeStatus('+json.userid+')">Change Status</button></td>');
    let cells2 = $('<td><button class="'+json.userid+'SendRecovery" onclick="onSendRecovery('+json.userid+')">Send Recovery Email</button></td>');
    let cells3 = $('<td><button class="'+json.userid+'CopyRecovery" onclick="onCopyRecovery('+json.userid+')">Copy Recovery Token</button></td>');


    row.append(stat);
    row.append(cells1);
    row.append(cells2);
    row.append(cells3);

    table.append(row);

    row = $('<tr></tr>');

    cells1 = $('<td colspan="2"> <button onclick="onRemoveImage('+json.userid+')">Remove Image</button></td>');
    text =(json.isBanned)? 'unban': 'ban';
    cells2 = $('<td><button class="'+json.userid+'BanUser" onclick="onBanUser('+json.userid+')" disabled>'+text+'</button></td>');
    text = (json.isAdmin)? 'Remove Admin':'Enable Admin';
    cells3 = $('<td><button class="'+json.userid+'AdminUser" onclick="onAdminUser('+json.userid+')" disabled>'+text+'</button></td>');

    //TODO finish me
    let cells4 = $('<td><form method="get" action=""><button>View Users Order History</button></form></td>');

    let cells5 = $('<td><form method="get" action=""><button>View Users Reviews</button></form></td>');
    let cells6 = $('<td><form method="get" action=""><button>View Users Comments</button></form></td>');

    row.append(cells1);
    row.append(cells2);
    row.append(cells3);
    row.append(cells4);
    row.append(cells5);
    row.append(cells6);

    table.append(row);
    return table;
}




















function getProductList(search = "") {
    let results = $.get('/src/action/getProductList.php?searchInput=' + search + '&searchType=' + searchType + '&buildType=grouped');
    results.done(function (data) {
        let productTable = $("#productContent");

        productTable.empty();
        data.forEach(function (value, index, array) {
            let item = buildProductItem(fixJsonBecausePhp(array[index]));
            productTable.append(item);
        })

    });
    results.fail(function (jqXHR) {
        console.log("Error: " + jqXHR.status);
    });
    results.always(function () {
        console.log("done");
    });
}


function fixJsonBecausePhp(json) {
    //i also dont feel like fixed the problem so im going to write shit ass legacy code.
    if(json.single){
        let obj ={
            "productSize":"",
            "productPrice":"",
            "productQuantity":""
        }
        json.medium = obj;
        json.large = obj;
        json.xl = obj;
        json.small = json.single;

    }
    return json;
}

function buildProductItem(json) {



    let table = $("<table class='productItem'>");
    let row = $("<tr></tr>");

    let pname = $("<td class='productName'><span>" + json.productName + "</span></td>");
    let psize = $("<td class='productSize'><span>Size</span></td>");
    let price = $("<td class='productPrice'><span>Price</span></td>");
    let quantity = $("<td class='productQuantity'><span>Quantity</span></td>");

    row.append(pname);
    row.append(psize);
    row.append(price);
    row.append(quantity);

    table.append(row);
    row = $("<tr></tr>");

    let image = $('<td rowspan="3" class="productImage"><img src="data:' + json.productContentType + ';base64,' + json.productImage + '" alt="product Image" ></td>');
    let size = $('<td class="productSize"><span>' + json.small.productSize + '</span></td>');
    price = $('<td class="productPrice"><span>' + json.small.productPrice + '</span> </td>');
    quantity = $('<td class="productQuantity"><span>' + json.small.productQuantity + '</span> </td>');

    row.append(image);
    row.append(size);
    row.append(price);
    row.append(quantity);

    table.append(row);
    row = $("<tr></tr>");

    size = $('<td class="productSize"><span>' + json.medium.productSize + '</span></td>');
    price = $('<td class="productPrice"><span>' + json.medium.productPrice + '</span></td>');
    quantity = $('<td class="productQuantity"><span>' + json.medium.productQuantity + '</span></td>');

    row.append(size);
    row.append(price);
    row.append(quantity);

    table.append(row);
    row = $("<tr></tr>");

    size = $('<td class="productSize"><span>' + json.large.productSize + '</span></td>');
    price = $('<td class="productPrice"><span>' + json.large.productPrice + '</span></td>');
    quantity = $('<td class="productQuantity"><span>' + json.large.productQuantity + '</span></td>');

    row.append(size);
    row.append(price);
    row.append(quantity);

    table.append(row);
    row = $("<tr></tr>");

    let btnEdit = $('<td><form action="editProduct.php?pno=' + json.productNumber + '"><input type="submit" value="Edit Product" /></form></td>');

    size = $('<td class="productSize"><span>' + json.xl.productSize + '</span></td>');
    price = $('<td class="productPrice"><span>' + json.xl.productPrice + '</span></td>');
    quantity = $('<td class="productQuantity"><span>' + json.xl.productQuantity + '</span></td>');

    row.append(btnEdit);
    row.append(size);
    row.append(price);
    row.append(quantity);

    table.append(row);
    return table;

}