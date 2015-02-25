
$(window).load(function(){
    $('.start_date').datetimepicker();
    $('.end_date').datetimepicker();
})

GraboneAdmin.controller('GraboneAdminNewDeal',function($scope,$http){
	$scope.AllDeal = AllDeal;
	var time_sensitive        = '';
	var time_sensitive_header = '';
	var week = [
		{start_time: null, end_time: null, day: "monday"},
		{start_time: null, end_time: null, day: "tueday"},
		{start_time: null, end_time: null, day: "wednesday"},
		{start_time: null, end_time: null, day: "thusday"},
		{start_time: null, end_time: null, day: "friday"},
		{start_time: null, end_time: null, day: "satuday"},
		{start_time: null, end_time: null, day: "sunday"},
	];

	$scope.week = week;

	$scope.UpdateTime = function(){
		time_sensitive        = JSON.stringify($scope.week);
		time_sensitive_header = $scope.time_sensitive_header;
		$('#select_time_modal').modal('hide')
		console.log(time_sensitive);
	}

	var image_url = null;
	if(Deal){
		console.log(Deal);
		var edit_deal = new Object();
			edit_deal.title       = Deal.title;
			edit_deal.address     = Deal.address;
			edit_deal.postcode    = parseInt(Deal.postcode);
			$scope.lat            = Deal.deal_location.lat;
			$scope.lng            = Deal.deal_location.lng;
			edit_deal.phone       = Deal.phone;
			edit_deal.website     = Deal.website;
			edit_deal.price       = Deal.price;
			edit_deal.quantity    = Deal.quantity;
			edit_deal.note        = Deal.note;
			edit_deal.start_date  = Deal.start_date;
			edit_deal.end_date    = Deal.end_date;
			edit_deal.refresh     = parseInt(Deal.refresh);
			edit_deal.sale_off    = Deal.sale_off;
			edit_deal.preview     = Deal.preview;
			edit_deal.own_email   = Deal.own_email;
			edit_deal.description = Deal.description;
		$scope.formData = edit_deal;

	}
	/*
	* variable to save image file when input[type="file"]
	*/
	var image = null;
	/*
	* load location
	*/
	$scope.locations = locations;
	/*
	* load categories
	*/
	$scope.categories = categories;
	/*
	* Auto fill data feild
	*/
	$scope.AutoFill = function(deal){
		console.log(deal);
		var auto_fill = new Object();
			auto_fill.title       = deal.title;
			auto_fill.address     = deal.address;
			auto_fill.postcode    = parseInt(deal.postcode);
			$scope.lat            = deal.deal_location.lat;
			$scope.lng            = deal.deal_location.lng;
			auto_fill.phone       = deal.phone;
			auto_fill.website     = deal.website;
			auto_fill.price       = deal.price;
			auto_fill.quantity    = deal.quantity;
			auto_fill.note        = deal.note;
			auto_fill.start_date  = deal.start_date;
			auto_fill.end_date    = deal.end_date;
			auto_fill.refresh     = parseInt(deal.refresh);
			auto_fill.sale_off    = deal.sale_off;
			auto_fill.preview     = deal.preview;
			auto_fill.own_email   = deal.own_email;
			auto_fill.description = deal.description;
		$scope.formData = auto_fill;
		$('select[name="location"]').find('option').each(function(){
			if($(this).text() == deal.location.location){
				$(this).attr('selected','true');
				var location_index = $(this).val();
				$scope.location = locations[location_index];
				$scope.states = locations[location_index].state;
			}
		})
		$scope.time_sensitive_header = deal.time_sensitive_header;
		$scope.week = JSON.parse(deal.time_sensitive);
	}
	/**
	*	Select state when location has been changed
	*/
	$scope.getLocation = function(location){
		$scope.states = location.state;
	}
	$scope.ImageFile = function(files){
		console.log(files[0]);
		var fd = new FormData();
			fd.append('image',files[0]);
		var xhr = new XMLHttpRequest();
		xhr.upload.addEventListener('progress',uploadProgress,false);
		xhr.open('POST',STR_URL_UPLOAD_IMAGE);
		xhr.send(fd);
		xhr.onreadystatechange = function(){
			console.log(xhr.responseText);
			if(xhr.readyState == 4 && xhr.status == 200){
				$scope.precentComplete = 0;
				image_url = xhr.responseText;
				$scope.$apply();
			}
		}
		
	}
	function uploadProgress(evt){
		if(evt.lengthComputable){
			var precentComplete = Math.round(evt.loaded * 100 / evt.total);
			$scope.precentComplete = precentComplete;
			console.log(precentComplete);
			$scope.$apply();
		}
	}
	$scope.submit = function(){
		if(image_url == null || image_url == ''){
			sweetAlert('Error','Please select an image OR wait until file uploaded','error');
			return;
		}
		$('.spinner').toggleClass('hidden');
		var deal_location = new Object();
			deal_location.lat = document.getElementById('lat').value;
			deal_location.lng = document.getElementById('lng').value;
		if(Deal){
			var data = {
				time_sensitive: 		time_sensitive,
				time_sensitive_header:  time_sensitive_header,
				deal:           		$scope.formData,
				location: 				$scope.location,
				state: 					$scope.state,
				category: 				$scope.category,
				deal_location:  		deal_location,
				_token: 				csrf_token,
				image: 					image_url,
				deal_id: 				Deal.id
			};

		}else{
			var data = {
				time_sensitive: 		time_sensitive,
				time_sensitive_header:  time_sensitive_header,
				deal: 					$scope.formData,
				location: 				$scope.location,
				state: 					$scope.state,
				category:				$scope.category,
				deal_location:  		deal_location,
				_token: 				csrf_token,
				image: 					image_url,
			};

		}
		console.log(data);
		console.log(JSON.stringify(data));
		$http.post(STR_URL_POST_DEAL,data)
			.success(function(response){
				console.log(response);
				$('.spinner').toggleClass('hidden');
				if(response.status == STR_STATUS_SUCCESS){
					if(Deal){
						document.location.href= BASE_URL + "/admin/angebote";
					}else{
						sweetAlert('Success','Deal has been created','success');
					}
				}else{
					sweetAlert('Error',response.message,'error');
				}
			})

	}
	/*
	* Get Latitude && Longtitude
	*/

})

/*
* Google Map API
*/
var map;
var geocoder;
var STR_ERROR_GEOCODER = 'goecoder error';
function GetLatLng(address){
	geocoder = new google.maps.Geocoder();
	geocoder.geocode({address: address},function(results,status){
		if(status == google.maps.GeocoderStatus.OK){
			var location = results[0].geometry.location;
			console.log(location);
			document.getElementById('lat').value = Math.round(location.k*100000)/100000;
			document.getElementById('lng').value = Math.round(location.D*100000)/100000;
		}else{
			console.log(STR_ERROR_GEOCODER);
		}
	});	
}
