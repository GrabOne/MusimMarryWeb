@extends('admin.template')
@section('content')
<script type="text/javascript" src="{{asset('lib/js/admin/location.js')}}"></script>

<link rel="stylesheet" type="text/css" href="{{asset('lib/css/template.css')}}">
<script type="text/javascript">
	var locations               = {{$locations}};
	var STR_URL_ADD_LOCATION    = "{{asset('ajax/insert-location')}}";
	var STR_STATUS_SUCCESS      = "{{STR_STATUS_SUCCESS}}";
	var STR_URL_REMOVE_LOCATION = "{{asset('ajax/delete-location')}}";
	var STR_URL_INSERT_STATE    = "{{asset('ajax/insert-state')}}";
	var STR_URL_DELETE_STATE    = "{{asset('ajax/delete-state')}}";
	var STR_URL_CHECK_LOCATION  = "{{asset('ajax/check-location')}}";
	var STR_URL_CHECK_STATE     = "{{asset('ajax/check-state')}}";
</script>
<div ng-controller="LocationCtrl">
	<div id="locations" class="col-md-16 col-sm-16 col-xs-36">
		<div class="new form-group">
			<form id="location_form" onsubmit="return false">
				<div class="form-group">
					<input type="text" class="form-control" id="newLocation" name="newLocation" ng-model="newLocation" placeholder="New Location" maxlength="50" required>
				</div>
			</form>
				<button class="btn btn-success btn-block" ng-click="addLocation()">ADD</button>
		</div><!--end .new-->
		<ul class="list-group">
			<li id="location_<%location.id%>" data="<%location.id%>" class="list-group-item <%locationClass[location.id]%>" ng-click="LocationClick(location)" ng-repeat="location in locations"><%location.location%><span ng-click="DeleteLocation(location)" class="pull-right glyphicon glyphicon-remove"></span></li>
		</ul>
	</div><!--end #locations-->
	<div id="states" class="col-md-16 col-sm-16 col-xs-36 pull-right">
		<div class="new form-group">
			<form id="state_form">
				<div class="form-group">
					<input type="text" name="newState" id="newState" class="form-control" ng-model="newState" placeholder="New State" maxlength="50" required>
				</div>
			</form>
				<button class="btn btn-success btn-block" ng-click="addState()">ADD</button>
		</div><!--end .new-->
		<ul class="list-group">
			<li id="state_<%sate.id%>" class="list-group-item" ng-repeat="state in states"><%state.state%><span ng-click="DeleteState(state)" class="pull-right glyphicon glyphicon-remove"></span></li>
		</ul>
	</div><!--end #states-->
</div><!--end LocationApp-->
@stop
