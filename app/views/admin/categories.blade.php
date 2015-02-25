@extends('admin.template')
@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('lib/css/template.css')}}">
<script type="text/javascript" src="{{asset('lib/js/admin/categories.js')}}"></script>
<script type="text/javascript">
	var STR_URL_POST_ADD_NEW_CATEGORY = "{{asset('ajax/insert-category')}}";
	var STR_STATUS_SUCCESS            = "{{STR_STATUS_SUCCESS}}";
	var STR_URL_DELETE_CATEGORY 	  = "{{asset('ajax/delete-category')}}";
</script>
	<div class="col-md-20 col-md-offset-8">
		<div id="new_category" class="form-group">
			<input type="text" class="form-control form-group" id="category" placeholder="New Category">
			<input type="button" class="form-control btn btn-block btn-primary" id="AddCategory" value="ADD" >
		</div><!--end #new_category-->
		<div id="categories">
			<ul class="list-group">
			@foreach($categories as $category)
				<li id="category_{{$category->id}}" class="list-group-item">{{$category->name}}<span onclick="DeleteCategory({{$category->id}})" class="glyphicon glyphicon-remove pull-right"></span></li>
			@endforeach
			</ul>
		</div><!--end #categories-->
	</div>
@stop