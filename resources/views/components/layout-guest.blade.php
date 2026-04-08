<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }}
        @isset($pageTitle)
            - {{ $pageTitle }}
        @endisset
    </title>

    <!-- favicon -->
    <link rel="icon" href="{{ assets('assets/images/favicon.png') }}" type="image/png">
    <!-- resources -->
    <link rel="stylesheet" href="{{ assets('assets/bootstrap/bootstrap.min.css') }}">
    <!-- custom -->
    <link rel="stylesheet" href="{{ assets('assets/css/main.css') }}">
</head>

<body>

    {{ $slot }}

    <!-- resources -->
    <script src="{{ assets('assets/bootstrap/bootstrap.bundle.min.js') }}"></script>

</body>

</html>
