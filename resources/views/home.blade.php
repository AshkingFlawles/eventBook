<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Add this line -->
    <title>HomePage</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <style>
        body {
            background: linear-gradient(to bottom, #ffa07a, #333);
            height: 100vh;
            margin: 0;
        }
    </style>
    @vite(['../js/app.js', '../sass/app.scss'])
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
    
    <div id="HomePage">
        <HomePage></HomePage>
    </div>
</body>
</html>