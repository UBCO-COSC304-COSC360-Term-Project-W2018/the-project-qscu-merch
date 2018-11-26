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
    let table = $('<table class="userTable"></table>');
    // <table class="userTable">

    let row = $('<tr></tr>');
    //     <tr>

    let image = $('<td class="'+ json.userid + 'ProfileImage" rowspan="2" colspan="2"><img class="'+json.userid+'ProfileImage" src="data:' + json.contentType + ';base64,' + json.profilePic + '" alt="User Profile Image"></td>');
    //     <td class="<uid>ProfileImage" rowspan="2" colspan="2">
    //     <img class="<uid>ProfileImage" src="data:image/jpeg;base64,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" alt="User Profile Image">


    let name = $('<td>Name:</td><td colspan="2">'+json.firstName +' ' +json.lastName + '</td>');
    //     <td>Name:</td>    <td colspan="2">Rachelle Gelden</td>
    let email = $('<td>Email:</td><td>'+json.userEmail+'</td>')
    // <td>Email:</td>      <td>rachelle@gelden.com</td>




    row.append(image);
    row.append(name);
    row.append(email);

    table.append(row);

    row = $('<tr></tr>');
    // <tr>

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
    // <td>Account Status:</td>   <td><span class="<uid>UserStatus">Admin</span></td>


    let cells1 = $('<td><button class="'+json.userid+'ChangeStatus" data-status="false" onclick="onChangeStatus('+json.userid+')">Change Status</button></td>');
    // <td><button class="<uid>ChangeStatus" data-status="false" onclick="onChangeStatus(<uid>)">Change Status</button></td>
    let cells2 = $('<td><button class="'+json.userid+'SendRecovery" onclick="onSendRecovery('+json.userid+')">Send Recovery Email</button></td>');
    // <td><button class="<uid>SendRecovery" onclick="onSendRecovery(<uid>)">Send Recovery Email</button></td>
    let cells3 = $('<td><button class="'+json.userid+'CopyRecovery" onclick="onCopyRecovery('+json.userid+')">Copy Recovery Token</button></td>');
    // <td><button class="<uid>CopyRecovery" onclick="onCopyRecovery(<uid>)">Copy Recovery Token</button></td>




    row.append(stat);
    row.append(cells1);
    row.append(cells2);
    row.append(cells3);

    table.append(row);

    row = $('<tr></tr>');
    // <tr>

    cells1 = $('<td colspan="2"><button onclick="onRemoveImage('+json.userid+')">Remove Image</button></td>');
    // <td colspan="2"><button onclick="onRemoveImage(<uid>)">Remove Image</button></td>

    text =(json.isBanned)? 'unban': 'ban';
    cells2 = $('<td><button class="'+json.userid+'BanUser" onclick="onBanUser('+json.userid+')" disabled>'+text+'</button></td>');
    // <td><button class="<uid>BanUser" onclick="onBanUser(<uid>)" disabled="">ban</button></td>

    text = (json.isAdmin)? 'Remove Admin':'Enable Admin';
    cells3 = $('<td><button class="'+json.userid+'AdminUser" onclick="onAdminUser('+json.userid+')" disabled>'+text+'</button></td>');

    // <td><button class="<uid>AdminUser" onclick="onAdminUser(<uid>)" disabled="">Remove Admin</button></td>

    //TODO finish me
    let cells4 = $('<td><form method="get" action=""><button>View Users Order History</button></form></td>');
    // <td><form method="get" action=""><button>View Users Order History</button></form></td>

    let cells5 = $('<td><button>View Users Reviews</button></td>');
    // <td><button>View Users Reviews</button></td>

    let cells6 = $('<td><button>View Users Comments</button></td>');
// <td><button>View Users Comments</button></td>


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
    //<table class="productItem">
    let row = $('<tr class="productHeaders"></tr>');
    //<tr class="productHeaders">



    let pname = $("<td class='productNameTitle'><span>" + json.productName + "</span></td>");
    //<td class="productNameTitle"><span>product1</span></td>
    let psize = $("<td class='productSizeTitle'><span>Size</span></td>");
    // <td class="productSizeTitle"><span>Size</span></td>
    let price = $("<td class='productPriceTitle'><span>Price</span></td>");
    // <td class="productPriceTitle"><span>Price</span></td>
    let quantity = $("<td class='productQuantityTitle'><span>Quantity</span></td>");
    // <td class="productQuantityTitle"><span>Quantity</span></td>


    row.append(pname);
    row.append(psize);
    row.append(price);
    row.append(quantity);

    table.append(row);
    row = $("<tr></tr>");
    // <tr>

    let image = $('<td rowspan="4" class="productImage"><img src="data:' + json.productContentType + ';base64,' + json.productImage + '" alt="product Image" ></td>');
    // <td rowspan="4" class="productImage">
    //     <img src="data:image/jpeg;base64,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" alt="product Image">
//     </td>
    let size = $('<td class="productSize"><span>' + json.small.productSize + '</span></td>');
    // <td class="productSize"><span>small</span></td>
    price = $('<td class="productPrice"><span>' + json.small.productPrice + '</span></td>');
    // <td class="productPrice"><span>3.00</span></td>
    quantity = $('<td class="productQuantity"><span>' + json.small.productQuantity + '</span></td>');
    // <td class="productQuantity"><span>0</span></td>


    row.append(image);
    row.append(size);
    row.append(price);
    row.append(quantity);

    table.append(row);
    row = $("<tr></tr>");
    // <tr>


    size = $('<td class="productSize"><span>' + json.medium.productSize + '</span></td>');
    // <td class="productSize"><span>medium</span></td>
    price = $('<td class="productPrice"><span>' + json.medium.productPrice + '</span></td>');
    // <td class="productPrice"><span>2.00</span></td>
    quantity = $('<td class="productQuantity"><span>' + json.medium.productQuantity + '</span></td>');
    // <td class="productQuantity"><span>0</span></td>



    row.append(size);
    row.append(price);
    row.append(quantity);

    table.append(row);
    row = $("<tr></tr>");
    // <tr>


    size = $('<td class="productSize"><span>' + json.large.productSize + '</span></td>');
    // <td class="productSize"><span>large</span></td>
    price = $('<td class="productPrice"><span>' + json.large.productPrice + '</span></td>');
    // <td class="productPrice"><span>1.00</span></td>
    quantity = $('<td class="productQuantity"><span>' + json.large.productQuantity + '</span></td>');
    // <td class="productQuantity"><span>0</span></td>



    row.append(size);
    row.append(price);
    row.append(quantity);

    table.append(row);
    row = $("<tr></tr>");
    // <tr>

    size = $('<td class="productSize"><span>' + json.xl.productSize + '</span></td>');
    // <td class="productSize"><span>xl</span></td>
    price = $('<td class="productPrice"><span>' + json.xl.productPrice + '</span></td>');
    // <td class="productPrice"><span>4.00</span></td>
    quantity = $('<td class="productQuantity"><span>' + json.xl.productQuantity + '</span></td>');
    // <td class="productQuantity"><span>0</span></td>


    row.append(size);
    row.append(price);
    row.append(quantity);
    table.append(row);


    row = $("<tr></tr>");
    // <tr>

    let btnEdit = $('<td class="editProduct" colspan="4"><form action="editProduct.php"><input type="hidden" name="pno" value="'+ json.productNumber +'"><input type="submit" value="Edit Product" /></form></td>');
    // <td class="editProduct" colspan="4">
    //     <form action="editProduct.php?pno=23"><input type="submit" value="Edit Product"></form>
    // </td>

    row.append(btnEdit);
    table.append(row);

    return table;

}







