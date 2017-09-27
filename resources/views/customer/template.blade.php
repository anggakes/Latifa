<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet">
    <!--<link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">-->
    <link rel="stylesheet" href="{{asset('css/material.css')}}" >
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <link href="{{asset('css/open-iconic-bootstrap.css')}}" rel="stylesheet">

    <style>
        body{
            font-family: 'Comfortaa', cursive;
            background: #f3f3f3;
            font-size: 4vw;
        }

        button, input, optgroup, select, textarea {
            font-family: 'Comfortaa', cursive;
        }

        .btn-primary {
            background: #e77817;
            color: white;
        }

        .btn-primary:active, .btn-primary.active {
            background-color: #b95e0f;
        }
    </style>

    @yield('css')
</head>
<body >
<br>
<div id="app" class="container">


    @yield('content')

</div>




<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="{{asset('js/material.min.js')}}" ></script>
<script src="{{asset('js/bootstrap.min.js')}}" ></script>
<script src="{{asset('js/moment.js')}}" ></script>

<script src="https://unpkg.com/vue"></script>
<script src="https://unpkg.com/vuex"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://unpkg.com/element-ui@1.4.2/lib/index.js"></script>


<script src="{{asset('js/app/utils.js')}}" ></script>
<script src="{{asset('js/app/store.js')}}" ></script>
<script src="{{asset('js/app/config.js')}}" ></script>
<script src="{{asset('js/app/interceptor.js')}}" ></script>

{{--<script src="{{ asset('js/app.js') }}"></script>--}}

    @yield('js')

</body>
</html>