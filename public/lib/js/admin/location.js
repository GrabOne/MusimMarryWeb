
	GraboneAdmin.controller('LocationCtrl',function($scope,$http){
		locations = locations;
		$scope.locations = locations;
		/*
		* First Location is current location
		*/
		var currentLocation = locations[0];
		/*
		* Active first location
		*/
		$scope.locationClass = [];
		$scope.locationClass[locations[0].id] = 'list-group-item-info';
		/*
		* State of first location
		*/
		$scope.states = locations[0].state;
		/*
		* Location click function
		*/
		$scope.LocationClick = function(location){
			currentLocation = location;
			$scope.states = currentLocation.state;
			/*
			* Reset active class
			*/
			$scope.locationClass = [];
			/*
			* Add active class to currentLocation
			*/
			$scope.locationClass[currentLocation.id] = 'list-group-item-info';
		}
		/*
		* Add location
		*/
		$scope.addLocation = function(){
			$('.spinner').toggleClass('hidden');
			$http.post(STR_URL_ADD_LOCATION,{location: $scope.newLocation})
				.success(function(response){
					$('.spinner').toggleClass('hidden');
					if(response.status == STR_STATUS_SUCCESS){
						$scope.locations.unshift(response.location);
					}else{
						sweetAlert('Oops!..',response.message,'error');
					}
				})

		}
		/*
		* Delete location
		*/
		$scope.DeleteLocation = function(location){
			var r = confirm('Are you sure you want to delete this item?');
			if(r == undefined || r == false){
				return;
			}
			$('.spinner').toggleClass('hidden');
			$http.post(STR_URL_REMOVE_LOCATION,{location_id: location.id})
				.success(function(response){
					$('.spinner').toggleClass('hidden');
					if(response.status == STR_STATUS_SUCCESS){
						document.location.reload();
					}else{
						sweetAlert('Oops!..',response.message,'error');
					}
				})
		}
		/*
		* Insert state
		*/
		$scope.addState = function(){
			$('.spinner').toggleClass('hidden');
			var data = {location_id: currentLocation.id, state: $scope.newState};
			$http.post(STR_URL_INSERT_STATE,data)
				.success(function(response){
					$('.spinner').toggleClass('hidden');
					if(response.status == STR_STATUS_SUCCESS){
						$scope.states.unshift(response.state);
					}else{
						sweetAlert('Oops!..',response.message,'error');
						$('#newLocation').select();
					}
				})
		}
		/*
		* Delete State
		*/
		$scope.DeleteState = function(state){
			var r = confirm('Are you sure you want to delete this item?');
			if(r == undefined || r == false){return;}

			$('.spinner').toggleClass('hidden');

			$http.post(STR_URL_DELETE_STATE,{state_id: state.id})
				.success(function(response){
					$('.spinner').toggleClass('hidden');
					if(response.status == STR_STATUS_SUCCESS){
						document.location.reload();
					}else{
						alert(response.message);
						$('#newState').select();
					}
				})
		}
	})
/*
* jQuery
*/
