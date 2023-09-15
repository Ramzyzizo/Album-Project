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
            <form action="">
                <h3>Registration Form</h3>
                <div class="form-group">
                    <div class="form-wrapper">
                        <label for="">First Name</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="form-wrapper">
                        <label for="">Last Name</label>
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="form-wrapper">
                    <label for="">Email</label>
                    <input type="text" class="form-control">
                </div>
                <div class="form-wrapper">
                    <label for="">Password</label>
                    <input type="password" class="form-control">
                </div>
                <div class="form-wrapper">
                    <label for="">Confirm Password</label>
                    <input type="password" class="form-control">
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox"> I caccept the Terms of Use & Privacy Policy.
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="form-group">
                <button style="color: white;" type="submit">Register Now</button>
                <button style="color: white; background-color: gray" type="button">Login</button>
                </div>
            </form>
        </div>
    </div>
    </body>
</html>
