@extends('admin.template')
@section('content')
	<script type="text/javascript">
		var STR_URL_LOGIN         = "{{asset('ajax/login')}}";
		var STR_URL_LOGIN_SUCCESS = "{{asset('admin/home')}}";
	</script>
	<script type="text/javascript" src="{{asset('lib/js/admin/login.js')}}"></script>
	<div class="col-md-12 col-md-offset-12 col-sm-18 col-sm-offset-9 col-xs-36" ng-controller="GraboneAdminLoginCtrl">
		<h1>Login</h1>
		<form method="POST" id="login_form" ng-submit="Login()">
			<div class="form-group">		
				<input type="email" class="form-control" name="email" placeholder="Email" ng-model="email" required>
			</div>
			<div class="form-group">			
				<input type="password" class="form-control" name="password" placeholder="Password" ng-model="password" pattern=".{8,40}" title="8 - 40 characters" required>
			</div>
			<input type="hidden" class="form-control" name="_token" value="{{csrf_token()}}">
			<input type="submit" class="btn btn-block btn-primary" name="submit" value="Login">
		</form>
		<span class="pull-right"><a href="{{asset('admin/forgot-password')}}">Forgot password</a></span>
	</div>
	<span us-spinner="spin_opts" spinner-key="spinner-1"></span>
@stop