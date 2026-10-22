<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ settings()?->company_name }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('static/favicon.png') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/oat/oat.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/custom-style.css?x='. rand(1111,9999)) }}">
    <style>
        [x-cloak] {
            display: none !important
        }
    </style>
</head>

<body class="bg-gray-50 align-center">
    <div class="mx-auto min-w-[320px] bg-white">
        <main id="page-content">{{ $slot }}</main>
    </div>
    <script src="{{ asset('frontend/oat/oat.min.js') }}"></script>
</body>

</html>
