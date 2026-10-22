<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Docs</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('static/favicon.png') }}">
    @vite('resources/css/frontend.css')
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/prism/prism.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/custom-style.css?x=' . rand(1111, 9999)) }}">
    <style>
        [x-cloak] {
            display: none !important
        }
        pre {
            margin: 0 !important;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Page Container -->
    <div class="mx-auto min-w-[320px] bg-white">
        <main id="page-content">{{ $slot }}</main>
    </div>
    <!-- END Page Container -->
    <script src="{{ asset('frontend/js/flowbite.min.js') }}"></script>
    <script src="{{ asset('frontend/prism/prism.js') }}"></script>
    <script src="{{ asset('frontend/js/frontend-script.js') }}"></script>
    @vite(['resources/js/app.js'])
</body>

</html>
