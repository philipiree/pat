<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href=" {{ asset('css/app.css') }} ">
    <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
</head>
<body>
    @include('inc.navbar')
    <div style="margin-top:50px;"class="container">
        @include('inc.message')
        @yield('content')
    </div>
    <script>
        CKEDITOR.replace( 'editor1' );
    </script>
</body>
</html>


