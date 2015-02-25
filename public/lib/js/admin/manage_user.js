GraboneAdmin.controller('ManageUser',function($scope,$http){
	$scope.users = users;
	$scope.pages = pages;
	$scope.USER_STATUS_ACTIVE = USER_STATUS_ACTIVE;
	$scope.USER_STATUS_DEACTIVE = USER_STATUS_DEACTIVE;

	var edit_id = null;
	/*
	* Remove user
	*/
	$scope.RemoveUser = function(user){
		var r = confirm('Are you sure you want to delete this user?');
		if(r == undefined || r == false){return;}
		$('.spinner').toggleClass('hidden');
		var data = {user_id: user.id};
		$http.post(STR_REMOVE_USER,data).success(function(response){
			$('.spinner').toggleClass('hidden');
			if(response.status = STR_STATUS_SUCCESS){
				$('#'+user.id).remove();
			}else{
				sweetAlert('Error',response.message,'error');
			}
		})
	}
	$scope.ChangeUserStatus = function(user,status){
		$('.spinner').toggleClass('hidden');
		var data = {
			user_id : user.id,
			status: status,
		};
		console.log(data);
		$http.post(STR_CHANGE_USER_STATUS,data).success(function(response){
			console.log(response);
			$('.spinner').toggleClass('hidden');
			if(response.status == STR_STATUS_SUCCESS){
				var index = users.indexOf(user);
				users[index].active = status;
				$scope.users = users;
			}else{
				sweetAlert('Error',response.message,'error');
			}
		})
	}
	$scope.EditUser = function(user){
		console.log(user);
		edit_id = user.id;
		$scope.edit_username = user.username;
		$scope.edit_email = user.email;
		$scope.edit_balance = user.balance;
	}
	$scope.ChangeUserInfo = function(){
		$('.spinner').toggleClass('hidden');
		var data = {
			user_id : edit_id,
			username : $scope.edit_username,
			email : $scope.edit_email,
			balance : $scope.edit_balance,
		};
		$http.post(STR_EDIT_USER,data).success(function(response){
			console.log(response);
			$('.spinner').toggleClass('hidden');
			if(response.status == STR_STATUS_SUCCESS){
				$('#edit_user_modal').modal('hide')
				users.forEach(function(value,key){
					if(value.id == edit_id){
						users[key].username = $scope.edit_username;
						users[key].email = $scope.edit_email;
						users[key].balance = $scope.edit_balance;
						$scope.users = users;
						return;
					}
				})
			}else{
				sweetAlert('Error',response.message,'error');
			}
		})
	}
})