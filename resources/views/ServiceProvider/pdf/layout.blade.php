<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>@yield('title')</title>
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> --}}
    <meta content="Reserve conveniently and quickly - that's the new trend. How does our system work? It's simple: we create connections. We combine reservation, overview lists and delivery in four different areas. With that you are prepared for the future." name="description"/>
    <meta content="" name="author"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App favicon -->
    <link type="image/x-icon" rel="shortcut icon" href="{{URL::to('storage/app/public/Serviceassets/images/favicon.png')}}">
    <link href="{{URL::to('storage/app/public/Serviceassets/css/pdf/font.css')}}">

    <!-- App css -->
    <link href="{{URL::to('storage/app/public/Serviceassets/css/pdf/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::to('storage/app/public/Serviceassets/css/invoice.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        
        body {
            font-size: 16px;
            line-height: 1.8;
        }
    </style>
    @yield('css')
</head>

<body>

    @yield('content')

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- Vendor js -->

@yield('plugin')

@yield('js')

</body>

</html>
