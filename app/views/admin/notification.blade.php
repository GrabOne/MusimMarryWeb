@extends('admin.template')
@section('content')
	<script type="text/javascript">
		var locations = {{$locations}};
	</script>
	<script type="text/javascript" src="{{asset('lib/js/admin/notification.js')}}"></script>
	<div id="notification" ng-controller="NotificationCtrl">
		<form method="post" ng-submit="PushNotification()" class="col-md-12 col-md-offset-12 col-sm-18 col-sm-offset-9 col-xs-36">
			<div class="form-group">
				<select class="form-control" name="location" ng-model="location" ng-options="location as location.location for location in locations" required>
					<option value="">Select a location</option>
				</select>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" ng-model="title" placeholder="Title" required>
			</div>
			<div class="form-group">
				<textarea ng-model="content" class="form-control" required></textarea>
			</div>
			<input type="submit" class="btn btn-primary" value="Push Notification" placeholder="">
		</form>
	</div>

	

@stop