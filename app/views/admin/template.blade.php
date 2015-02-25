<html>
<head>
	<title>{{$title}}</title>
	<meta charse="UTF-8">
	<meta name="keywords" content="Deal, grabone, shoping, group">
	<meta name="description" content="Grabone, Admin panel">
	<meta name="author" content="NightFury">
	<!-- Javascript Library -->
	<script type="text/javascript" src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
	<!-- Bootstrap 36 grid -->
	<link rel="stylesheet" type="text/css" href="{{asset('bower_components/nightfury_bootstrap_36grid/css/bootstrap.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('bower_components/nightfury_bootstrap_36grid/css/bootstrap-theme.min.css')}}">
	<script type="text/javascript" src="{{asset('bower_components/nightfury_bootstrap_36grid/js/bootstrap.min.js')}}"></script>
	<link rel="stylesheet" type="text/css" href="{{asset('lib/css/template.css')}}">
	


	<!-- sweetalert -->
	<script type="text/javascript" src="{{asset('bower_components/sweetalert/lib/sweet-alert.min.js')}}"></script>
	<link rel="stylesheet" type="text/css" href="{{asset('bower_components/sweetalert/lib/sweet-alert.css')}}">
	<!-- angular -->
	<script type="text/javascript" src="{{asset('bower_components/angular/angular.min.js')}}"></script>
	<!-- angular tinymce -->
	<script type="text/javascript" src="{{asset('bower_components/tinymce/tinymce.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('bower_components/angular-ui-tinymce/src/tinymce.js')}}"></script>
	<!-- angular spinkit -->
	<link rel="stylesheet" href="{{asset('bower_components/angular-spinkit/build/angular-spinkit.min.css')}}">
	<script src="{{asset('bower_components/angular-spinkit/build/angular-spinkit.min.js')}}"></script>

	<script type="text/javascript">
		var STR_STATUS_SUCCESS   = "{{STR_STATUS_SUCCESS}}";
		var STR_STATUS_ERROR     = "{{STR_STATUS_ERROR}}";
		var LOGIN                = "{{Auth::check()}}";
		var USER_STATUS_DEACTIVE = 0;
		var USER_STATUS_ACTIVE   = 1;
	</script>
	<script type="text/javascript" src="{{asset('lib/js/admin/template.js')}}"></script>
</head>
<body ng-app="GraboneAdmin">
	<nav class="navbar navbar-default" role="navigation" ng-controller="GraboneAdminNavbarCtrl">
		<div class="container" ng-if="LOGIN == 1">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{asset('admin/home')}}">Grabone</a>
			</div><!--end .navbar-header-->

			<div class="collapse navbar-collapse" id="navbar-collapse">
				<ul class="nav navbar-nav">
					@if(!empty(Auth::user()) && Auth::user()->role != 3)
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Angebote <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="{{asset('admin/angebote')}}">Angebote</a></li>
							<li><a href="{{asset('admin/neues-angebote')}}">Neues Angebote</a></li>
						</ul>
					</li>
					@if(Auth::user()->role_id < 3)
					<li><a href="{{asset('admin/categories')}}">Categories</a></li>
					<li><a href="{{asset('admin/location')}}">Location</a></li>
					<li><a href="{{asset('admin/agent')}}">Agent</a></li>
					<li><a href="{{asset('admin/manage-user')}}">User</a></li>
					<li><a href="{{asset('admin/promocode')}}">Promocode</a></li>
					@endif
					<li><a href="{{asset('admin/notification')}}">Push Notification</a></li>
					@endif
				</ul>
				<ul class="nav navbar-nav navbar-right {{Auth::check() ? '' : 'hidden'}}">
					<li><a href="#">{{Auth::check() ? Auth::user()->email : ''}}</a></li>
					<li><a href="{{asset('admin/logout')}}">Logout</a></li>
				</ul>
			</div><!--end #navbar-collapse-->
		</div>
	</nav>
	<section class="container">
		@yield('content')
	</section>
<div class="spinner hidden">
	<circle-spinner></circle-spinner>
</div>
</body>
</html>