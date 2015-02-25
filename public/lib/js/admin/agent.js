	GraboneAdmin.controller('AgentCtrl',function($scope,$http){
		$scope.agents = agents;
		if(agents.length > 0){
			var currentAgent = agents[0];
			$scope.agentClass = [];
			$scope.agentClass[agents[0].id] = 'list-group-item-info';
			$scope.locations = agents[0].location;
		}
		/*
		* AllLocation
		*/
		$scope.AllLocation = AllLocation;
		/*
		* Add Agent
		*/
		$scope.addAgent = function(){
			$('.spinner').toggleClass('hidden');
			$http.post(STR_URL_ADD_AGENT, {username: $scope.newAgentUsername,email: $scope.newAgentEmail,password: $scope.newAgentPassword})
				.success(function(response){
					$('.spinner').toggleClass('hidden');
					if(response.status == STR_STATUS_SUCCESS){
						if($scope.agents.length > 0){
							agents.unshift(response.agent);
							$scope.agents = agents;
						}else{
							agents = [response.agent];
							$scope.agents = agents;
						}
						sweetAlert('Success','Agent has been created','success');
					}else{
						sweetAlert('Oops!..',response.message,'error');
					}
				})
		}
		/*
		* Agent click
		*/
		$scope.agentClick = function(agent){
			if(agent.location == undefined){
				index = agents.indexOf(agent);
				agent.location = [];
				agents[index] = agent;
			}
			currentAgent = agent;
			$scope.locations = currentAgent.location;
			/*
			* Reset active class
			*/
			$scope.agentClass = [];
			/*
			* Add active class to currentLocation
			*/
			$scope.agentClass[currentAgent.id] = 'list-group-item-info';
		}
		/*
		* Delete Agent
		*/
		$scope.DeleteAgent = function(agent){
			var r = confirm('Are you sure you want delete this agent?')
			if(r == undefined || r == false){return;}
			$('.spinner').toggleClass('hidden');
			$http.post(STR_URL_DELETE_AGENT,{user_id: agent.id})
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
		* Delete Location
		*/
		$scope.DeleteLocation = function(location){
			var r = confirm('Are you sure you want to delete this item?');
			if(r == undefined || r == false){ return;}
			
			$('.spinner').toggleClass('hidden');
			$http.post(STR_URL_USER_DELETE_LOCATION,{user_id: currentAgent.id,location_id: location.id})
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
		* Add Location -> Agent
		*/
		$scope.SelectLocation = function(location){
			if(currentAgent == undefined){
				sweetAlert('Oops!..','Please select an Agent','warning');
				return;
			}
			$('.spinner').toggleClass('hidden');
			$http.post(STR_URL_ADD_LOCATION,{user_id: currentAgent.id,location_id: location.id})
				.success(function(response){
					$('.spinner').toggleClass('hidden');
					if(response.status == STR_STATUS_SUCCESS){
						index = agents.indexOf(currentAgent);
						agents[index].location.unshift(response.location);
						$scope.agents = agents;
					}else{
						sweetAlert('Oops!..',response.message,'error');
					}
				})
		}
	})