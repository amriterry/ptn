function showResponse(text,responseTyp){
	if(responseTyp == 'WARNING'){
		className = 'warning';
	} else {
		className = 'success';
	}

	var promptHtml = '<div class="' + className + '">' + text + '</div>';

	$("#login").prepend(promptHtml);

	setTimeout(function(){$("."+className).slideUp()}, 3000);
}

$(document).ready(function(){
	$("#forgotPromptBtn").click(function(){
		var firstName = $("#forgotForm input[name='firstName']").val();
		var lastName = $("#forgotForm input[name='lastName']").val();
		var username = $("#forgotForm input[name='username']").val();
		var email = $("#forgotForm input[name='email']").val();
		var phone = $("#forgotForm input[name='phone']").val();

		if(firstName == '' || lastName == '' || username == '' || email == '' || phone == ''){
			showResponse("Please fill all fields!",'WARNING');

		} else {
			console.log("before ajax");
			$.ajax({
				type: "post",
				dataType: "json",
				url: "forgot_test.php",
				data: {
					firstName : firstName,
					lastName : lastName,
					username : username,
					email : email,
					phone : phone
				},
				success: function(response){
					console.log("success");
					if(response.success){
						showResponse("We will send you your changed password soon!",'SUCCESS');
						$("#forgotForm input[name='firstName']").val('');
						$("#forgotForm input[name='lastName']").val('');
						$("#forgotForm input[name='username']").val('');
						$("#forgotForm input[name='email']").val('');
						$("#forgotForm input[name='phone']").val('');
					} else {
						showResponse(response.errorMsg,'WARNING');
					}
				},
				error: function(jqrXHR,status,errorThrown){
					console.log(jqrXHR);
					console.log(status);
					console.log(errorThrown);
				}
			});
			console.log("after ajax");
		}
		return false;
	});
});