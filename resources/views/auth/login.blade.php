<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login at Album</title>
    <link rel="stylesheet" href="{{asset('fonts/material-design-iconic-font/css/material-design-iconic-font.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">

</head>
<body class="antialiased">

<div class="wrapper" style="background-image: url({{asset('front_images/bg-registration-form-2.jpg')}});">
    <div
        class="inner" style="background-image: url({{asset('front_images/registration-form-2.jpg')}});">
        <form id="a-form"
              method="POST" action="{{ route('login') }}">
            @csrf>
            <h3>Login Form</h3>
            <div class="form-wrapper">
                <label for="email">Email</label>
                <input type="text" name="email" class="form-control">
            </div>
            @if ($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error)
                            <span class="invalid-feedback" role="alert">
                                        <strong style="color: red">- These credentials are not right</strong>
                                    </span>
                            <br>
                        @endforeach
                    </ul>
            @endif
            <div class="form-wrapper">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <button style="color: white;" type="submit">Login Now</button>
            </div>
        </form>
        <a href="{{route('register')}}" type="button"><button style="margin-left: 45px; color: white; background-color: gray"> Register</button></a>

    </div>
</div>
</body>
</html>
