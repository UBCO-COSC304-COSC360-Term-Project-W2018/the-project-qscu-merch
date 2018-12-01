
$(document).ready(function(){
     $("#addToCartButton").on('click', function (e) {
	     
        var quantity = $("#quantity").val();
        var size = $("#size").val();
        var pNo = $("#pNo").val();
        if(pNo==11){
	        var rand = Math.floor(Math.random() * 2) + 1;
	        if(rand ==1){
		       window.location.replace("https://www.youtube.com/watch?v=fmz-K2hLwSI"); 
	        }else{
		        window.location.replace("http://www.calendar.ubc.ca/okanagan/?tree=3,54,111,959");
	        }
	        return;
        }else{
		//TODO Do more validation on emailField clientside right here
		var obj = {'pNo':pNo, 'size':size, 'quantity':quantity};
		//send this inputted email to the server to check if it exists in the DB
		
		$.post('action/addToCart.php', JSON.stringify(obj))
		.done(function (data){
			if(data == true){

				$("#addedToCart").text("Added To Cart");
			
				setTimeout( function(){
					$("#addedToCart").empty();
				}, 1000);
			}else{
				$("#addedToCart").text("Failed To Add To Cart");
				
				setTimeout( function(){
					$("#addedToCart").empty();
					}, 1000);
			}
		}).fail(function(jqXHR){
			console.log(jqXHR);
			
		}).always(function(data){

			console.log(data);
		});
}		
});
});