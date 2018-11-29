$(document).ready(function(){

    $("#addToCartButton").on('click', function (e) {
	    
        var quantity = $("#quantity").val();
        var size = $("#size").val();
        var pNo = $("#pNo").val();
        if($.trim(quantity)!=""||$.trim(size)!=""||$.trim(pNo)!=""){
        console.log(quantity);
        console.log(size);
		//TODO Do more validation on emailField clientside right here
		let obj = {'pNo':pNo, 'size':size, 'quantity':quantity};
		//send this inputted email to the server to check if it exists in the DB
		
		$.post('../src/action/addToCart.php', JSON.stringify(obj))
		.done(function (data){
			
			var message = $("#addedToCart").html("Added To Cart");
		})
		.fail(function(jqXHR){
			console.log("Error:" + jqXHR.status);
		}).always(function(){
		
		})
}		
})
});
