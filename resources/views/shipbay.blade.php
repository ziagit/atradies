<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>aTradies</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="js/v3.js"></script>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic|Material+Icons">

    <script  src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAQTHaD2g0BjmczBlX73Vv-KthtHzdRYPk"></script>
    <style>                                                                    
        html,
        body {
            height: 100% !important;
            min-height: 100% !important;
        }
        #app {
            height: 100% !important;
            min-height: 100% !important;
        }
        /* width */
::-webkit-scrollbar {
  width: 0px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: #888; 
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555; 
}
    </style>
</head>

<body>
    <div id="app">
        <app></app>
    </div>
    <script src="{{ asset('js/app.js') }}" defer></script>

</body>

</html>