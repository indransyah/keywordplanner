<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="keywords" content="">
		<meta name="author" content="">

		<!-- MAIN CSS -->
		{{ HTML::style('assets/css/bootstrap.min.css') }}
		{{ HTML::style('assets/css/ndoboost.css') }}

        <title>Login - Keyword Planner</title>
        {{ HTML::style('assets/css/login.css') }}
    </head>
    <body>
        <div class="container">
            {{ Form::open(array('url'=>'user/login', 'class'=>'form-signin')) }}
            <div class="row-fluid text-center">
                <img src="{{ asset('assets/images/logo.png') }}" style="margin-bottom: 20px;width: 200px;">
                @if(Session::has('error'))
                <div class="alert alert-danger square fade in alert-dismissable">
                    {{ Session::get('error') }}
                </div>
                @endif
                <input name="username" type="text" class="form-control" placeholder="Username" required autofocus>
                <br />
                <input name="password" type="password" class="form-control" placeholder="Password" required>
                <!-- <label class="checkbox text-left">
                  <input type="checkbox" value="remember-me"> Remember me
                </label> -->
                <button class="btn btn-info btn-block btn-lg" type="submit">Login</button>
                <br />
                <!-- Not a Member? {{ HTML::link('user/register', 'Register here!') }} -->
            </div>
            {{ Form::close() }}
        </div>
    </body>
</html>