<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Strong Services | Log in</title>
	<link rel="icon" href="{{asset('img/favicon.ico')}}" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<link rel="stylesheet" href="{{asset('adminlte/css/all.min.css')}}">
	<link rel="stylesheet" href="{{asset('adminlte/css/adminlte.min.css')}}">
	<link rel="stylesheet" href="{{asset('adminlte/css/custom.css')}}">
</head>
<body class="hold-transition login-page">
	<div class="login-box">
  		<div class="card card-outline card-primary">
    		<div class="card-header text-center">
      			<a href="{{route('login')}}" class="h1"><img src="{{asset('img/logo.png')}}" alt="Logo"></a>
    		</div>
    		<div class="card-body">
		      	<form id="login-form" name="login-form" action="{{route('authenticate')}}" method="POST">
		      		@csrf
					@include('shared.alert')
					@if (count($errors) > 0)
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<ul>
							@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
					@endif
			        <div class="input-group mb-3">
			        	<input type="text" class="form-control" id="phone" name="phone" placeholder="Mobile Number">
			          	<div class="input-group-append">
			            	<div class="input-group-text">
			              		<span class="fas fa-phone"></span>
			            	</div>
			          	</div>
			        </div>
			        <div class="input-group mb-3">
			          	<input type="password" id="password" name="password" placeholder="Password" class="form-control" maxlength="16">
			          	<div class="input-group-append">
			            	<div class="input-group-text">
			              		<span class="fas fa-lock"></span>
			            	</div>
			          	</div>
			        </div>
			        <div class="row">
			          	<div class="col-8">
			            	<div class="icheck-primary">
			              		<input type="checkbox" id="remember_me" name="remember_me">
			              		<label for="remember">
			                		Remember Me
			              		</label>
			            	</div>
			          	</div>
			          	<div class="col-4">
			            	<button type="submit" id="submitBtn" name="submitBtn" class="btn btn-primary btn-block">Login</button>
			          	</div>
			        </div>
		      	</form>
      			<p class="mb-1">
        			<a href="{{route('forget_password')}}">I forgot my password</a>
      			</p>
    		</div>
  		</div>
	</div>
	<script src="{{asset('adminlte/js/jquery.min.js')}}"></script>
    <script src="{{asset('adminlte/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('adminlte/js/adminlte.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/additional-methods.min.js"></script>
	<script src="{{asset('js/validation-additional.js')}}"></script>
    <script>
	(function() {
		$('#login-form').validate({
			rules: {
				phone: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
				password: {
					required: true,
					minlength:8,
					maxlength: 16,
				},
			},
			messages:{
			 	phone: {
                    required: "Plese enter mobile number.",
                },
			 	password:{
			 		required: "Plese enter your password.",
			 	}
			},
			errorPlacement: function(error, element) {
				$(element.parent()).find("div.input-group-append").after(error);
            },
			submitHandler: function (form) {
				form.submit();
			},
		});
	})();
	</script>
</body>
</html>