<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
    </head>
    <body class="guest-bg">
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>
        <style>
            body.guest-bg {
                min-height: 100vh;
                width: 100vw;
                margin: 0;
                font-family: 'Nunito', sans-serif;
                background: url('{{ asset('images/logo.png') }}') no-repeat center center fixed;
                background-size: 350px 350px;
                background-color: #f3f6fd;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            html, body {
                height: 100%;
                width: 100%;
            }
            .font-sans.text-gray-900.antialiased {
                width: 100%;
            }
            .auth-card {
                background: rgba(255,255,255,0.60);
                border-radius: 18px;
                box-shadow: 0 4px 24px rgba(0,0,0,0.10);
                padding: 48px 40px 40px 40px;
                max-width: 520px;
                width: 100%;
                margin: 40px auto;
            }
            .auth-card form {
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            .auth-card form > div,
            .auth-card form > label,
            .auth-card form > input,
            .auth-card form > button,
            .auth-card form > a {
                width: 100%;
                max-width: 350px;
            }
            .auth-card form .flex {
                justify-content: center;
            }
            .auth-card form .block {
                width: 100%;
            }
        </style>
    </body>
</html>
