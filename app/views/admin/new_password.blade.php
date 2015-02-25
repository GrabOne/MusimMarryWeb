@extends('admin.template')
@section('content')
	<script type="text/javascript" src="{{asset('lib/jquery.validate.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('lib/js/admin/new_password.js')}}"></script>
	<div class="col-md-12 col-md-offset-12 col-sm-18 col-sm-offset-9 col-xs-36">
		<h1>New Password</h1>
		<form method="POST" id="new_password">
			<div class="form-group">
				<input type="password" id="password" class="form-control" name="password" placeholder="New password">
			</div>
			<div class="form-group">
				<input type="password" class="form-control" name="password_confirmation" placeholder="Confirm password">
			</div>
			<input type="hidden" class="form-control" name="_token" value="{{csrf_token()}}">
			<input type="submit" class="btn btn-block btn-primary" name="submit" value="Ok">
		</form>
	</div>
@stop