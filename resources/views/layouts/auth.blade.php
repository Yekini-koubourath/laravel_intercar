<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'INTERCAR')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font Awesome pour les icônes --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Bootstrap & Styles via Vite --}}
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-light antialiased m-0 p-0 overflow-x-hidden">

    @yield('content')

</body>
</html>