<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>{{ config("app.name", "Laravel") }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link
            href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600"
            rel="stylesheet"
        />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path("build/manifest.json")) || file_exists(public_path("hot")))
            @vite(["resources/css/app.css", "resources/js/app.js"])
        @else
            <style>
                /* Tailwind CSS - keeping your existing styles */
                /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
                /* ... your existing Tailwind styles ... */
            </style>
        @endif
        
        <style>
            /* Custom dark gradient background */
            body {
                background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
                background-attachment: fixed;
            }
        </style>
    </head>
    <body
        class="text-[#1b1b18] dark:text-white flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col"
    >

     <!-- User Greeting Header (Only shows when logged in) -->
        @auth
            <header class="w-full max-w-[2000px] mb-6">
                <div class="flex items-center gap-3 px-4 py-3 bg-white/5 border border-white/10 rounded-lg backdrop-blur-sm">
                    <!-- User Avatar -->
                    <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center text-white font-bold text-sm shrink-0">
                        {{ strtoupper(substr(auth()->user()->firstname, 0, 1)) }}{{ strtoupper(substr(auth()->user()->lastname, 0, 1)) }}
                    </div>
                    
                    <!-- User Info -->
                    <div class="flex flex-col flex-1 min-w-0">
                        <span class="text-white/60 text-xs">Welcome back,</span>
                        <span class="text-white font-semibold text-lg truncate">
                            {{ auth()->user()->firstname }} {{ auth()->user()->lastname }}
                        </span>
                        <span class="text-white/40 text-xs truncate">{{ auth()->user()->email }}</span>
                    </div>
                </div>
            </header>
        @endauth
        
       <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
            <!-- Changed max-w-4xl to max-w-[2000px] for wider content -->
            <main class="flex max-w-[2000px] w-full flex-col">
                @include("partials.welcome-main")
            </main>
        </div>

        @if (Route::has("login"))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>