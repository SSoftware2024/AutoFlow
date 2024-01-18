<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @vite(['resources/sass/app.scss'])
    @inertiaHead

    {{-- CDN --}}
    {{-- FONT AWESSOME V6 --}}
    <script src="https://kit.fontawesome.com/4ecb736ddb.js" crossorigin="anonymous"></script>
    {{-- END FONT AWESSOME --}}
    {{-- END-CDN --}}
</head>

<body class="font-sans antialiased">
    @inertia
    <script>
        function startTheme() {
            if (!localStorage.getItem('theme')) {
                localStorage.setItem('theme', 'light');
                document.documentElement.classList.remove('dark');
            } else {
                switch (localStorage.getItem('theme')) {
                    case 'light':
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('theme', 'light');
                        break;
                    case 'dark':
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('theme', 'dark');
                        break;

                    default:
                        break;
                }
            }
        }
        startTheme();
    </script>
</body>

</html>
