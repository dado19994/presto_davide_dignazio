{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite (['resources/css/app.css', 'resources/js/app.js'])
    <title>Story1</title>
</head>


<body>

    <x-navbar />

    <main class="app-main">

        {{ $slot }}

    </main>

    <x-footer />

    {{-- AI Assistant Floating Core --}}
    <div class="ai-assistant-core d-none d-md-flex">
        <i class="fas fa-microchip"></i>
        <div class="ai-tooltip shadow-lg">
            <p class="fw-bold text-primary mb-1">VendoHub AI Assistant</p>
            <p class="m-0 small">Ciao! Sono qui per aiutarti a ottimizzare i tuoi annunci e le tue vendite.</p>
        </div>
    </div>

</body>

</html> --}}

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>VendoHub AI</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <x-navbar />
    <div class="noise"></div>
    <main class="app-main">
        {{ $slot }}
    </main>

    <x-footer />

</body>

</html>
