@extends('admin.template')
@section('content')
	<div class="col-md-12 col-sm-18 col-xs-36 col-md-offset-12 col-sm-offset-9">
		<h3>Promocode Bonus</h3>
		<form method="post" ng-submit="SavePromocodeBonus">
			<div class="form-group">
				<label for="">User who has promocode</label>
				<input type="text" class="form-control" ng-model="user_has_promocode" placeholder="USD" required>
			</div>
			<div class="form-group">
				<label for="">User who use promocode</label>
				<input type="text" class="form-control" ng-model="user_use_promocode" placeholder="USD" required>
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-primary" value="submit">
			</div>
		</form>
	</div>

@stop

