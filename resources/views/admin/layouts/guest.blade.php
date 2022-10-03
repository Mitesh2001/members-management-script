<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="images/favicon.png">
    <meta name="theme-color" content="#ffffff">

    <title>{{ config('app.name') }} - @yield('title')</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" />
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">

    {{--Favicon--}}
    @include('admin.layouts.include.favicon')
</head>
<body>
    <div class="login-bg">
        <div class="login-inner h-100 d-flex align-items-center flex-wrap">
            <div class="login-left">
                <div class="form-main-container h-100 d-flex justify-content-center align-items-center">
                    @yield('content')
                </div>
            </div>

            <div class="login-right">
                <div class="d-flex align-items-center h-100 login-text">
                    <h1>UNLEASH <br>THE <br>FEAR</h1>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
