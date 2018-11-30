/*
$(document).ready(function(){

    $("#addToCartButton").on('click', function (e) {
	    
        var quantity = $("#quantity").val();
        
        var size = $("#size").val();
        var pNo = $("#pNo").val();
        console.log(quantity);
        console.log(size);
        console.log(pNo);
		//TODO Do more validation on emailField clientside right here
		let obj = {'pNo':pNo, 'size':size, 'quantity':quantity};
		//send this inputted email to the server to check if it exists in the DB
		
		$.post('../src/action/addToCart.php', JSON.stringify(obj))
		.done(function (data){
		})
		.fail(function(jqXHR){
			console.log("Error:" + jqXHR.status);
		}).always(function(){
		
		});	
})
});
*/

$(document).ready(function(){
     $("#addToCartButton").on('click', function (e) {
        var quantity = $("#quantity").val();
        var size = $("#size").val();
        var pNo = $("#pNo").val();
        console.log(quantity);
        console.log(size);
		//TODO Do more validation on emailField clientside right here
		let obj = {'pNo':pNo, 'size':size, 'quantity':quantity};
		//send this inputted email to the server to check if it exists in the DB
		
		$.post('action/addToCart.php', JSON.stringify(obj))
		.done(function (data){
			console.log(data);
		})
		.fail(function(jqXHR){
			console.log("Error:" + jqXHR.status);
		}).always(function(){
			console.log("FUCK");
		})
		
})
});