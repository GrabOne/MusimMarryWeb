$(window).load(function(){
	$('#new_password').validate({
		rules: {
			password: {
				required: true,
				minlength: 8,
				maxlength: 30,
			},
			password_confirmation: {
				equalTo : '#password',
			}
		}
	})
})