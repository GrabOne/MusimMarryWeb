$(window).load(function(){
	$('#category').keyup(function(e){
		if(e.keyCode == 13){
			saveCategory();
		}
	})
	$('#AddCategory').click(function(){
		saveCategory();
	})
	function saveCategory(){
		$('.spinner').toggleClass('hidden');
		var category = $('#category').val();
		$.ajax({
			type: 'POST',
			url: STR_URL_POST_ADD_NEW_CATEGORY,
			data: {
				category: category,
			}
		}).success(function(response){
			$('.spinner').toggleClass('hidden');
			$('#category').select();
			if(response.status == STR_STATUS_SUCCESS){
				var new_cate = '<li id="category_'+response.category.id+'" class="list-group-item">'+response.category.name+'<span onclick="DeleteCategory('+response.category.id+')" class="glyphicon glyphicon-remove pull-right"></span></li>';
				$('#categories ul').prepend(new_cate);
				$('#category').select();
			}else{
				alert(response.message);
			}
		})
	}

})
function DeleteCategory(id){
	var r = confirm('Are you sure you want to delete this item?');
	if(r == true){
		$('.spinner').toggleClass('hidden');
		$.ajax({
			type: 'DELETE',
			url: STR_URL_DELETE_CATEGORY,
			data: {
				category_id: id,
			}
		}).success(function(response){
			$('.spinner').toggleClass('hidden');
			if(response.status == STR_STATUS_SUCCESS){
				$('#category_'+id).remove();
			}else{
				alert(response.message);
			}
		})
	}
}