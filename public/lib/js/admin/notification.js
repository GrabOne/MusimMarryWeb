GraboneAdmin.controller('NotificationCtrl',function($scope,$http){
	$scope.locations = locations;
	$scope.PushNotification = function(){
		sweetAlert('Success','Notification was sent','success');
	}
})