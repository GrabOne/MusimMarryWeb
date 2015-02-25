@extends('admin.template')
@section('content')
	<div class="col-md-12 col-md-offset-12 col-sm-18 col-sm-offset-9 col-xs-36">
		<h1>Forgot Password</h1>
		<form method="POST">
			<div class="form-group">
				<input type="email" class="form-control" name="email" placeholder="Your Email">
			</div>
			<input type="hidden" name="_token" value="{{csrf_token()}}">
			<div class="form-group">
				<input type="submit" class="btn btn-block btn-primary" value="Forgot password">
			</div>
		</form>
		<span class="pull-right"><a href="{{asset('admin/forgot-password')}}">Forgot password</span>
	</div>
@stop