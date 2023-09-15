<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Register at Album</title>
    <link rel="stylesheet" href="{{asset('fonts/material-design-iconic-font/css/material-design-iconic-font.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">

</head>
<body class="antialiased">

<div class="wrapper" style="background-image: url({{asset('front_images/bg-registration-form-2.jpg')}});">
    <div
        class="inner" style="background-image: url({{asset('front_images/registration-form-2.jpg')}});">
        <form id="a-form"
              method="POST" action="{{ route('register') }}">
            @csrf
            <h3>Registration Form</h3>
            <div class="form-group">
                <div class="form-wrapper">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" class="form-control">
                    @error('first_name')
                    <span class="invalid-feedback" role="alert">
                                        <strong style="color: red">{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="form-wrapper">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" class="form-control">
                    @error('last_name')
                    <span class="invalid-feedback" role="alert">
                                        <strong style="color: red">{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-wrapper">
                <label for="email">Email</label>
                <input type="text" name="email" class="form-control">
                @error('email')
                <span class="invalid-feedback" role="alert">
                                        <strong style="color: red">{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="form-wrapper">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control">
                @error('password')
                <span class="invalid-feedback" role="alert">
                                        <strong style="color: red">{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="form-wrapper">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control">
                @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                                        <strong style="color: red">{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="acceptance"> I caccept the Terms of Use & Privacy Policy.
                    <span class="checkmark"></span>
                </label>
            </div>
            @error('acceptance')
            <span class="invalid-feedback" role="alert">
                                        <strong style="color: red">{{ $message }}</strong>
                                    </span>
            @enderror
            <div class="form-group">
                <button style="color: white;" type="submit">Register Now</button>
            </div>
        </form>
            <a href="{{route('login')}}" type="button"><button style="margin-left: 45px; color: white; background-color: gray"> Login</button></a>

    </div>
</div>
</body>
</html>
