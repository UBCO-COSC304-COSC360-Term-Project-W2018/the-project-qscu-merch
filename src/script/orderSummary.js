window.onload = function (){
    console.log("yikes");
    var editBtn = document.getElementById('editOrderButton');
    // if (editBtn) {
        editBtn.addEventListener('click', function() {
            console.log("hello");
            window.location.href='checkout.php';
        });
    // }

}
