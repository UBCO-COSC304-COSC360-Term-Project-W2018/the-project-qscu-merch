window.onload = function () {

    $("#sendResetEmailButton").on('click', function (e) {
		
		$("sendResetEmailButton").attr("disabled","disabled");
		e.preventDefault();
        var emailField = document.getElementById("forgetPassEmailInput");
		//TODO Do more validation on emailField clientside right here
		
		//send this inputted email to the server to check if it exists in the DB
		$.ajax({
			url:"action/resetPass.php",
			method:"post",
			data:"email="+$(emailField).val(),
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
    });
	
	$("#newPassForm").on('submit', function(e) {
		
        var passwordField = document.getElementById("signUpPasswordInput");
        var passwordConfirmField = document.getElementById("signUpPasswordConfirmationInput");
		
		if ( passwordField.value != passwordConfirmField.value ) {
            e.preventDefault();
            alert("Passwords do not match");
        }
		
	});

}