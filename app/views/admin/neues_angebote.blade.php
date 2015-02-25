@extends('admin.template')
@section('content')

<script type="text/javascript" src="{{asset('lib/bootstrap-datetimepicker/moment.js')}}"></script>
<script type="text/javascript" src="{{asset('lib/bootstrap-datetimepicker/bootstrap-datetimepicker.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('lib/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css')}}">
<!-- Google Map API -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{GOOGLE_MAP_KEY}}"></script>
<script type="text/javascript">
	var locations            = {{$locations}};
	var categories           = {{$categories}};
	var STR_URL_POST_DEAL    = "{{asset('ajax/save-deal')}}";
	var STR_URL_UPLOAD_IMAGE = "{{asset('ajax/upload-deal-image')}}";
	var csrf_token           = "{{csrf_token()}}";
	var STR_STATUS_SUCCESS   = "{{STR_STATUS_SUCCESS}}";
	var BASE_URL             = "{{asset('')}}";
	var Deal                 = null;
	var AllDeal              = {{$alldeal}};
	@if($deal)
		Deal = {{$deal}};
	@endif
console.log(Deal);
</script>
<script type="text/javascript" src="{{asset('lib/js/admin/neues_angebote.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('lib/css/admin/neues_angebote.css')}}">


<div id="new_deal" ng-controller="GraboneAdminNewDeal"> 
<div class="container" onload="initialize()">
	<div class="col-md-18 col-sm-18 col-xs-36">
		<div class="form-group col-md-36">
			<label for="">Autom. fill in</label>
			<select class="form-control" name="location" ng-model="deal" ng-change="AutoFill(deal)" ng-options="d as d.title for d in AllDeal" required>
				
			</select>
		</div>
	</div>
 	<form method="post" id="new_form" class="col-md-36" enctype="multipart/form-data" name="ng" ng-model="form" ng-submit="submit()">
		<div class="col1 col-md-18 col-sm-18 col-xs-36">
			<div class="form-group">
				<label>TITEL</label>
				<input type="text" class="form-control" name="title" ng-model="formData.title" required maxlength="500">
			</div>
			<div class="form-group">
				<label>ADRESSE</label>
				<input type="text" class="form-control" name="address" ng-model="formData.address" onchange="GetLatLng(this.value)" required maxlength="160">
			</div>
			<div class="form-group">
				<label>POSTLEITZAHL</label>
				<input type="number" class="form-control" name="postcode" ng-model="formData.postcode" required maxlength="8">
			</div>
			<!-- SELECT LOCATION -->
			<div class="form-group">
				<label>LOCATION</label>
				<select class="form-control" name="location" ng-model="location" ng-change="getLocation(location)" ng-options="location as location.location for location in locations" required>
					<option value="">---Wählen location---</option>
				</select>
			</div>
			<!-- SELECT STATE -->
			<div class="form-group">
				<label>STADTTEIL</label>
				<select class="form-control" name="state" ng-model="state" ng-options="state as state.state for state in states" required>
					<option value="">---Wählen stadtteil---</option>
				</select>
			</div>
			<!-- SELECT CATEGORY -->
			<div class="form-group">
				<label>KATEGORIE</label>
				<select name="category" ng-model="category" class="form-control" ng-options="category as category.name for category in categories" required>
					<option value="">---Wählen kategorie---</option>
				</select>
			</div>
			<div class="form-group">
				<label>BREITE</label>
				<input type="text" class="form-control" id="lat" ng-model="lat" name="width" required maxlength="10">
			</div>
			<div class="form-group">
				<label>LÄNGE</label>
				<input type="text" class="form-control" id="lng" ng-model="lng" name="large" required maxlength="10">
			</div>
			<div class="form-group">
				<label>TELEFON</label>
				<input type="text" class="form-control" name="phone" ng-model="formData.phone" pattern="[0-9 |+]{6,20}" title="Please enter an valid phone number" required>
			</div>
			<div class="form-group">
				<label>WEBSITE</label>
				<input type="text" class="form-control" name="website" ng-model="formData.website">
			</div>
			<div class="form-group">
				<label>BEMERKUNG</label>
				<input type="text" class="form-control" name="note" ng-model="formData.note">
			</div>
			
			<input type="file" class="form-control form-group" id="image" name="image" onchange="angular.element(this).scope().ImageFile(this.files)">
			<p ng-if="precentComplete > 0"><span>Upload: </span><span ng-bind="precentComplete"></span><span>%</span></p>
		</div><!--end .col1-->
		<div class="col2 col-md-18 col-sm-18 col-xs-36">
			<div class="form-group">
				<label>Price</label>
				<input type="text" class="form-control" name="price" ng-model="formData.price" data-placeholder="Price" pattern="[0-9|.]{1,10}" title="Please enter an valid price, 1-10 characters" required>
			</div>
			<div class="form-group">
				<label>MAX. ANZAHL</label>
				<input type="text" class="form-control" name="quantity" ng-model="formData.quantity" data-placeholder="MAX. ANZAHL">
			</div>

			<label>STARTDATUM</label>
			<div class="form-group input-group">
				<input type="text" class="form-control start_date" data-date-format="DD/MM/YYYY HH:mm:ss" name="start_date" ng-model="formData.start_date" required>
				<span class="input-group-addon">
	                <span class="glyphicon-calendar glyphicon start_date_span"></span>
	            </span>
			</div>

			<label>ABLAUFDATUM</label>
			<div class="form-group input-group">
				<input type="text" class="form-control end_date" name="end_date" data-date-format="DD/MM/YYYY HH:mm:ss" ng-model="formData.end_date" required>
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-calendar"></span>
				</span>
			</div>
			<div class="form-group" data-toggle="modal" data-target="#select_time_modal">
				<a>IST VIEL AKTION</a>
			</div>
			<label for="">Refresh</label>
			<div class="form-group">
				<input type="number" class="form-control" ng-model="formData.refresh" placeholder="" required>
			</div>


			<div class="form-group">
				<label>RABATT IN %</label>
				<input type="text" class="form-control" name="sale_off" ng-model="formData.sale_off" data-placeholder="RABATT IN %">
			</div>
			
			<div class="form-group">
				<label>GESCHÄFT VORSCHAU</label>
				<input type="text" class="form-control" name="preview" ng-model="formData.preview" data-placeholder="GESCHÄFT VORSCHAU">
			</div>
			<div class="form-group">
				<label>OWNER E-MAIL</label>
				<input type="email" class="form-control" name="own_email" ng-model="formData.own_email" data-placeholder="OWNER E-MAIL" required>
			</div>
			<div class="form-group">
				<label>BESCHREIBUNG</label>
				<textarea class="form-control description" name="description" ui-tinymce ng-model="formData.description" data-placeholder="BESCHREIBUNG"></textarea>
			</div>
		</div><!--end .col2-->
		
		<div class="col-md-36 col-sm-36 col-xs-36">
			<input type="submit" class="btn btn-block btn-primary" value="submit">
		</div>

		</div>
	</form>


	<!-- modal -->
	<div class="modal fade" id="select_time_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <h4 class="modal-title" id="myModalLabel">IST VIEL AKTION</h4>
	      </div>
	      <div class="modal-body">
	        <ul class="list-group">
				<li ng-repeat="day in week" class="list-group-item"><span class="day" ng-bind="day.day"></span><span class="pull-right"><span>Start: <input type="time" ng-model="day.start_time"></span> <span>End :<input type="time" ng-model="day.end_time"></span></span></li>
	        </ul>
	        <div class="form-group">
				<label>Aktion deal nachricht</label>
				<input type="text" class="form-control" ng-model="time_sensitive_header">
	        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary" ng-click="UpdateTime()">Save changes</button>
	      </div>
	    </div>
	  </div>
	</div>


</div><!--end #new_deal-->
@stop