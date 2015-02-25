@extends('admin.template')
@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('lib/css/admin/angebote.css')}}">
<script type="text/javascript" src="{{asset('lib/js/admin/angebote.js')}}"></script>
<script type="text/javascript">
	var deals = {{$deals}};
	var STR_URL_REMOVE_DEAL = "{{asset('ajax/remove-deal')}}";
	var STR_STATUS_SUCCESS = "{{STR_STATUS_SUCCESS}}";
</script>
<div ng-controller="AngeboteCtrl">
	<table class="table table-bordered">
		<thead>
			<tr>
				<td>Image</td>
				<td>Name</td>
				<td>User</td>
				<td>Kategorie</td>
				<td>Adresse</td>
				<td>Location</td>
				<td>Price</td>
				<td>Beginn</td>
				<td>Ende</td>
				<td>Edit/Delete</td>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="deal in deals" id="<%deal.id%>">
				<td><img style="max-width: 60px;" src="<%deal.image%>"></td>
				<td ng-bind="deal.title"></td>
				<td ng-bind="deal.user.username"></td>
				<td ng-bind="deal.category.name"></td>
				<td ng-bind="deal.address"></td>
				<td ng-bind="deal.location.location"></td>
				<td ng-bind="deal.price"></td>
				<td ng-bind="deal.start_date"></td>
				<td ng-bind="deal.end_date"></td>
				<td><a href="{{asset('admin/neues-angebote')}}/<%deal.id%>"><span class="glyphicon glyphicon-edit pull-left"></span></a><span ng-click="RemoveDeal(deal)" class="glyphicon glyphicon-remove pull-right"></span></td>
			</tr>
		</tbody>
	</table>
</div><!--end AngeboteApp>
	
@stop