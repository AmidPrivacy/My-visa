<!doctype html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.87.0">
    <title>Asan viza</title>

    <!-- Bootstrap core CSS -->
    <link href="{!! url('assets/css/bootstrap.min.css') !!}" rel="stylesheet">
    <link href="{!! url('assets/css/summernote.min.css') !!}" rel="stylesheet">
    <script src="{!! url('assets/js/jquery-3.5.1.min.js') !!}"></script>

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="{!! url('assets/css/custom.css') !!}" rel="stylesheet">
</head>
<body>
    
    

    
        @auth
        @include('layouts.partials.navbar')
        <main class="container">
          @yield('admin-content')
        </main>
        @endauth
        @guest
          @yield('public-content')
        @endguest
    
    
    <script src="{!! url('assets/js/bootstrap.bundle.min.js') !!}"></script>
    
    <script src="{!! url('assets/js/custom.js') !!}"></script>
      
  </body>
</html>