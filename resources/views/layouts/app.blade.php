<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <meta name="author" content="David Grzyb">
    <meta name="description" content="">
    <link href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Tailwind -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>


</head>
<body class="bg-gray-100 font-family-karla flex">
    @include('components.sidebar') <!-- Sidebar -->
    <div class="w-full flex flex-col h-screen overflow-y-hidden">
        @include('components.header') <!-- Desktop Header -->
        @include('components.mobile-menu') <!-- Mobile Header -->
        <div class="w-full overflow-x-hidden border-t flex flex-col min-h-screen">
            <main class="w-full flex-grow p-6">
              @yield('content')
            </main>
            <footer class="w-full bg-white text-right p-4">
              Built by <a target="_blank" href="https://davidgrzyb.com" class="underline">David Grzyb</a>.
            </footer>
          </div>          
    </div>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>
