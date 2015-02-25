@extends('admin.template')
@section('content')
	<script type="text/javascript">
		var users                  = {{$users}};
		var pages                  = {{json_encode($pages)}};
		var STR_REMOVE_USER        = "{{asset('ajax/remove-user')}}";
		var STR_CHANGE_USER_STATUS = "{{asset('ajax/change-user-status')}}";
		var STR_EDIT_USER          = "{{asset('ajax/edit-user')}}";
	</script>
	<script type="text/javascript" src="{{asset('lib/js/admin/manage_user.js')}}"></script>
<div id="manage_user" ng-controller="ManageUser">
		<table class="table table-bordered">
			<thead>
				<tr>
					<td>Email</td>
					<td>Username</td>
					<td>Balance</td>
					<td>Promocode</td>
					<td class="text-center">Edit</td>
					<td class="text-center">Active/Deactive</td>
					<td class="text-center">Delete</td>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="user in users" id="<%user.id%>">
					<td ng-bind="user.email"></td>
					<td ng-bind="user.username"></td>
					<td ng-bind="user.balance"></td>
					<td ng-bind="user.promocode"></td>
					<td class="text-center"><span class="glyphicon glyphicon-edit" data-toggle="modal" data-target="#edit_user_modal" ng-click="EditUser(user)"></span></td>
					<td class="text-center"><span class="glyphicon glyphicon-ok" ng-if="user.active == 1" ng-click="ChangeUserStatus(user,USER_STATUS_DEACTIVE)"></span><span class="glyphicon glyphicon-off" ng-if="user.active == 0" ng-click="ChangeUserStatus(user,USER_STATUS_ACTIVE)"></span></td>
					<td class="text-center"><span class="glyphicon glyphicon-remove" ng-click="RemoveUser(user)"></span></td>
				</tr>
			</tbody>
		</table>
		<div class="col-md-36">
			<ul class="pagination">
				<li ng-repeat="page in pages">
					<a href="<%page.link%>" ng-bind="page.key"></a>
				</li>
			</ul>
		</div>

	<!-- modal -->

	<div class="modal fade" id="edit_user_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <h4 class="modal-title" id="myModalLabel">Edit User</h4>
	      </div>
	      <div class="modal-body">
	        <form method="post" ng-submit="ChangeUserInfo()">
	        	<div class="form-group">
	        		<label for="">Username</label>
					<input type="text" class="form-control" ng-model="edit_username" required>
	        	</div>
	        	<div class="form-group">
	        		<label>Email</label>
					<input type="email" class="form-control" ng-model="edit_email" required>
	        	</div>
	        	<div class="form-group">
	        		<label for="">Balance</label>
					<input type="text" class="form-control" ng-model="edit_balance" required>
	        	</div>
	        	<div class="form-group">
					<input type="submit" class="btn btn-primary" value="Change">
	        	</div>
	        </form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>

</div> <!-- manage_user -->

@stop