<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Add this line -->
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <style>
        body {
            background: linear-gradient(to bottom, #ffa07a, #333);
            height: 100vh;
            margin: 0;
        }

      .admin-reg-stage_1 {
        background-color: black !important;
        color: #ffa07a !important;
        font-family: Arial, Helvetica, sans-serif;
      }

    </style>
    @vite(['../js/app.js', '../sass/app.scss'])
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
    <div id="app_admin_register">
    <admin-register-form></admin-register-form>
        <calendar-app></calendar-app>
@section('content')
</div>
@endsection <!-- End of content section -->
