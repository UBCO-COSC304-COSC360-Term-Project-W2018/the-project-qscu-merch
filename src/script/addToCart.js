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
		
		$.post('../src/action/addToCart.php', JSON.stringify(obj))
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
/*
		$.ajax({
			url:"action/addToCart.php",
			method:"POST",
			data:"&pNo="+$(pNo).val() + "size=" + $(size).val() + "quantity=" + $(quantity).val(),
			beforeSend:function() {
				
				$("#statusHolder").html("<p>Sending...</p>");
				$("#statusHolder").addClass("loading");
				
			},
			success:function(res) {
				
				console.log(res);
				$("#statusHolder").removeClass("loading");
				var results = JSON.parse(res);
				if (results.status == "success") {
					$("#statusHolder").addClass("success");
					$("#statusHolder").html("<p>Email sent! Please check your email.</p>");
				} else {
					$("#statusHolder").addClass("fail");
					$("#statusHolder").html("<p>Error, this email is not in our user database.</p>");
					$("sendResetEmailButton").removeAttr("disabled");
				}
				
			}
		});
		return false;
*/



// mock javascript php 
// 
// Javascript 
// 
// function doAThing(shit){
// 	let num = randomNum()
// 	
// 	let obj = {'kindOfShit': search, 'ranNum': num};
// 
//     $.post('addToCart.php', JSON.stringify(obj))
//         .done(function (data) {
// 		do a thing if works
// 		data is the server respons 
// 		
// 		console.log(data)
// 
//         }).fail(function (jqXHR) {
// 		failed
//         console.log("Error: " + jqXHR.status);
//     })
// 	.always(function(){
// 	always runs
// 	
// 	});
// }
// 
// PHP
// 
// <?php
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $input = json_decode(file_get_contents('php://input'), true);
// 	if(isset($input['kindOfShit']) && isset($input['ranNum'])){
// 	$data = [];
//     for($i = 0; $i < 10; $i++){
//         $data[$input['kindOfShit'].$i] = $input['ranNum'];
//     }
// 		header('Content-Type: application/json');
// 		echo json_encode($data);
// 	}
// }
// ?>