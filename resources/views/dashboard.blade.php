{{-- resources/views/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    <div id="dashboard">
    <dashboard></dashboard>
    </div>
</body>
</html>
