@extends('admin.template')
@section('content')
<script type="text/javascript" src="{{asset('lib/js/admin/agent.js')}}"></script>

<link rel="stylesheet" type="text/css" href="{{asset('lib/css/template.css')}}">
<script type="text/javascript">
	var AllLocation                  = {{($locations)}};
	var agents                       = {{($agents)}};
	var STR_URL_ADD_AGENT            = "{{asset('ajax/insert-agent')}}";
	var STR_STATUS_SUCCESS           = '{{STR_STATUS_SUCCESS}}';
	var STR_URL_DELETE_AGENT         = "{{asset('ajax/delete-agent')}}";
	var STR_URL_USER_DELETE_LOCATION = "{{asset('ajax/delete-user-location')}}";
	var STR_URL_ADD_LOCATION         = "{{asset('ajax/insert-user-location')}}";
</script>
</style>
<div ng-controller="AgentCtrl">
	<div class="col-md-36 col-xs-36 col-sm-36" style="padding: 0px">
		<div class="new form-group col-md-16 col-sm-16 col-xs-36">
			<form id="location_form" ng-submit="addAgent()">
				<div class="form-group">
					<input type="text" class="form-control" id="newAgentUsername" name="newAgentUsername" ng-model="newAgentUsername" placeholder="Username" pattern="[a-zA-Z0-9_]{4,30}" title="Please enter an valid username (4 - 30 characters)" required>
				</div>
				<div class="form-group">
					<input type="email" class="form-control" id="newAgentEmail" name="newAgentEmail" ng-model="newAgentEmail" placeholder="Email" pattern=".{0,40}" required>
				</div>
				<div class="form-group">
					<input type="password" class="form-control" id="newAgentPassword" name="newAgentPassword" ng-model="newAgentPassword" placeholder="Password" pattern=".{6,40}" title="6 - 40 charactes" required>
				</div>
				<input type="submit" class="btn btn-success btn-block" value="ADD">
			</form>
		</div><!--end .new-->
	</div>
	<div id="agents" class="col-md-16 col-sm-16 col-xs-36">
		<h4>Agents</h4>
		<ul class="list-group">
			<li ng-repeat="agent in agents" id="agent<%agent.id%>" data="<%agent.id%>" class="list-group-item <%agentClass[agent.id]%>" ng-click="agentClick(agent)" ><%agent.username%><span ng-click="DeleteAgent(agent)" class="pull-right glyphicon glyphicon-remove"></span></li>
		</ul>
	</div><!--end #agents-->
	<div id="permisstion" class="col-md-16 col-sm-16 col-xs-36 pull-right">
		<h4>Locations</h4>	
		<ul class="list-group">
			<li id="location_<%location.id%>" data="<%location.id%>" class="list-group-item" ng-repeat="location in locations"><%location.location%><span ng-click="DeleteLocation(location)" class="pull-right glyphicon glyphicon-remove"></span></li>
		</ul>
		<button class="btn btn-block btn-default" ng-click="AddLocation()" data-toggle="modal" data-target="#LocationModal"><span class="glyphicon glyphicon-plus "></span></button>
	</div><!--end #permisstion-->
	<!-- modal -->

<div class="modal fade" id="LocationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Select a location</h4>
			</div>
			<div class="modal-body">
				<ul class="list-group">
					<li class="list-group-item" ng-repeat="location in AllLocation" data-dismiss="modal" ng-click="SelectLocation(location)"><%location.location%></li>
				</ul>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
	<!-- end Modal -->
</div><!--end AgentApp-->
@stop
