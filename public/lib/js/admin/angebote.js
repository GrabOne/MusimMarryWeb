	GraboneAdmin.controller('AngeboteCtrl',function($scope,$http){
		$scope.deals = deals;
		console.log(deals);
		$scope.RemoveDeal = function(deal){
			var r = confirm('Are you sure you want to delete this item?');
			if(r == undefined || r == false){return;}
			
			$('.snipper').toggleClass('hidden');
			var data = {id: deal.id};
			console.log(data);
			$http.post(STR_URL_REMOVE_DEAL,data)
				.success(function(response){
					$('.snipper').toggleClass('hidden');
					console.log(response);
					if(response.status = STR_STATUS_SUCCESS){
						document.getElementById(deal.id).remove();
					}
				})
		}
	})