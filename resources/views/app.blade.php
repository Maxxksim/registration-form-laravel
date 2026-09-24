<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @class(['dark' => ($appearance ?? 'system') == 'dark'])>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <x-inertia::head>
        <title>Registration Form</title>
    </x-inertia::head>
</head>
<body class="font-sans antialiased">
<x-inertia::app/>
<script src="{{ mix('js/app.js') }}" defer></script>
</body>
</html>
