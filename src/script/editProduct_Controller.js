let selected = null;

$(document).on("click", ".categoryItem", function () {
    $('.categoryItem').removeClass('selected');
    selected = $(this);
    selected.addClass('selected');
});

function addCategory() {
    if(selected){
        let obj = {'action': 'addCategory', 'cid': selected.data('cid'), 'pno':selected.data('pno')};
        $.post('action/editCategory.php', JSON.stringify(obj))
            .done(function (data) {
                console.log(data);
                location.reload();
            }).fail(function (jqXHR) {
                console.log(jqXHR)

        })


    }
}
function removeCategory() {
    if(selected){
        let obj = {'action': 'removeCategory', 'cid': selected.data('cid'), 'pno':selected.data('pno')};
        $.post('action/editCategory.php', JSON.stringify(obj))
            .done(function (data) {
                console.log(data);
                location.reload();
            }).fail(function (jqXHR) {
            console.log(jqXHR)

        })


    }
}
function newCategory() {
    let node = $("#newCategoryName");
    let regex = new RegExp(/^[A-Za-z0-9 _]*[A-Za-z0-9][A-Za-z0-9 _]*$/);
    if(regex.test(node.val())){
        let obj = {'action': 'newCategory', 'pno':node.data('pno'), 'cname':node.val()};
        $.post('action/editCategory.php', JSON.stringify(obj))
            .done(function (data) {
                console.log(data);
                location.reload();
            }).fail(function (jqXHR) {
            console.log(jqXHR)

        })
    }
}

function deleteCategory() {
    if(selected){
        let obj = {'action': 'deleteCategory', 'cid': selected.data('cid'), 'pno':selected.data('pno')};
        $.post('action/editCategory.php', JSON.stringify(obj))
            .done(function (data) {
                console.log(data);
                location.reload();
            }).fail(function (jqXHR) {
            console.log(jqXHR)

        })


    }
}