<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{$page_title}}</title>
    <link rel="stylesheet" href="{{asset('fonts/material-design-iconic-font/css/material-design-iconic-font.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<header class="header">
<ul class="nav justify-content-center mt-4">
    <li class="nav-item">
        <a class="nav-link {{($page == 'Home') ? 'font-weight-bolder' : ''}}" href="{{url('/')}}">Home</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{($page == 'Create') ? 'font-weight-bolder' : ''}}" href="{{route('album.create')}}">Create Album</a>
    </li>
    <div class="navbar-nav ms-auto">
    <a href="{{route('logout')}}" type="button">
        <button style="margin-left: 45px; color: white; background-color: gray" class="nav-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
        </button>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
    </div>
</ul>
</header>


