<!doctype html>
<html dir="ltr" lang="en-US">

<head>
    <title>Done</title>
    <link type="image/x-icon" rel="shortcut icon" href="{{asset('public/asset_front/assets/images/favicon.jpg')}}"/>
    <meta charset="UTF-8"/>
    <meta name="HandheldFriendly" content="true">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/all.min.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/fonts/stylesheet.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/owl.carousel.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/bootstrap.min.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/bootstrap-datepicker.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/styles3.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('public/asset_front/assets/css/responsive.css')}}"/>
</head>
<body>
<!--Header-->

<!-- Contact detail -->
              <div class="done-contrat">
            <div class="done-logo">
                <img src="{{asset('public/asset_front/assets/images/logo.svg')}}" alt="logo">
</div>
<div class="btn-home next"><a href="https://delemontstudio.com/r4ucontract" class="btn btn-black next">Back to Home</a></div>
</div>
<script src="{{asset('public/asset_front/assets/js/jquery.min.js')}}"></script>
<script src="{{asset('public/asset_front/assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="{{asset('public/asset_front/assets/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('public/asset_front/assets/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('public/asset_front/assets/js/custom3.js')}}"></script>
</body>

<script>


    function b2b_store() {
        var b2bdate = $("input[name=b2bdate]").val();
        var place = $("input[name=place]").val();
        var _token = $("input[name=_token]").val();

        $.ajax({
            type: 'post',
            url: '{{ route("b2b_store") }}',
            data: {
                'b2bdate': b2bdate,
                'place': place,
                _token: _token
            },
            success: function (data) {

                window.location.replace("{{config('app.url')}}");

            }
        });
    }
</script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

</html>
