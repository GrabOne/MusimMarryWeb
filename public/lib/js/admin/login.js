
GraboneAdmin.controller('GraboneAdminLoginCtrl',function($scope,$http){

	$scope.Login = function(){
		$('.spinner').toggleClass('hidden');
		var data = {
			email : $scope.email,
			password : $scope.password,
		};
		$http.post(STR_URL_LOGIN,data).success(function(response){
			console.log(response);
			$('.spinner').toggleClass('hidden');
			if(response.status == STR_STATUS_SUCCESS){
				document.location.href = STR_URL_LOGIN_SUCCESS;
			}else{
				sweetAlert('Oops!..',response.message,'error');
			}
		})
	}
})