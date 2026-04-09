<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Solar ACE') }}</title>

    <!-- Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Phosphor Icons (Linear, sleek icons replacing the bulky ones) -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #fafafa; color: #09090b; }
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #e4e4e7; border-radius: 99px; }
        ::-webkit-scrollbar-thumb:hover { background: #18181b; }
    </style>
</head>
<body x-data="{ mobileMenuOpen: false }" class="text-zinc-950 antialiased h-screen flex overflow-hidden">

    <!-- Mobile Overlay -->
    <div x-show="mobileMenuOpen" x-transition.opacity class="fixed inset-0 z-40 bg-zinc-950/20 backdrop-blur-sm md:hidden" style="display: none;" @click="mobileMenuOpen = false"></div>

    <!-- Sidebar - Pure White with Zinc borders -->
    <aside :class="mobileMenuOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed md:relative inset-y-0 left-0 z-50 w-64 bg-white border-r border-zinc-200 transition-transform duration-300 ease-in-out md:translate-x-0 flex flex-col justify-between shrink-0 h-full">

        <div class="flex-1 flex flex-col overflow-y-auto overflow-x-hidden">
            <!-- Header Brand -->
            <div class="h-16 flex items-center px-6 shrink-0 border-b border-zinc-100">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded bg-zinc-900 flex items-center justify-center">
                        <img src="https://6mwxm9jt.dev.cdn.imgeng.in/wp-content/uploads/2024/10/cropped-Favicon-300x300.png" alt="Logo" class="h-5 w-5 object-contain invert">
                    </div>
                    <div>
                        <span class="font-bold text-zinc-900 text-sm tracking-tight block">SOLAR ACE</span>
                        <span class="text-[9px] uppercase tracking-widest text-zinc-500 font-bold">CRM Portal</span>
                    </div>
                </div>
            </div>

            <!-- Primary Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-1">
                <div class="text-[10px] uppercase tracking-widest text-zinc-400 font-bold mb-3 px-3">Overview</div>

                <a href="/dashboard" class="flex items-center gap-3 px-3 py-2 rounded-md transition-all text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-zinc-100 text-zinc-900' : 'text-zinc-500 hover:bg-zinc-50 hover:text-zinc-900' }}">
                    <i class="ph ph-squares-four text-lg"></i>
                    Dashboard
                </a>

                <a href="/leads" class="flex items-center gap-3 px-3 py-2 rounded-md transition-all text-sm font-medium {{ request()->routeIs('leads.*') ? 'bg-zinc-100 text-zinc-900' : 'text-zinc-500 hover:bg-zinc-50 hover:text-zinc-900' }}">
                    <i class="ph ph-users text-lg"></i>
                    Leads & CRM
                </a>

                <a href="/jobs" class="flex items-center gap-3 px-3 py-2 rounded-md transition-all text-sm font-medium {{ request()->routeIs('calendar.*') || request()->routeIs('jobs.*') ? 'bg-zinc-100 text-zinc-900' : 'text-zinc-500 hover:bg-zinc-50 hover:text-zinc-900' }}">
                    <i class="ph ph-calendar-blank text-lg"></i>
                    Installations
                </a>
                
                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-md transition-all text-sm font-medium text-zinc-500 hover:bg-zinc-50 hover:text-zinc-900">
                    <i class="ph ph-envelope-simple text-lg"></i>
                    Communications
                </a>
            </nav>
            
            <div class="px-4 py-4 border-t border-zinc-100">
                <div class="flex items-center gap-3 px-3">
                    <div class="w-8 h-8 rounded-full bg-zinc-100 text-zinc-600 border border-zinc-200 flex items-center justify-center font-bold text-xs uppercase">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <div class="text-xs font-semibold text-zinc-900 truncate">{{ auth()->user()->name ?? 'Agent Name' }}</div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-[10px] text-zinc-500 hover:text-zinc-900 transition-colors mt-0.5 font-medium tracking-wide">Sign Out</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </aside>

    <!-- Main Content Container -->
    <div class="flex-1 flex flex-col min-w-0 h-full relative bg-[#fafafa]">
        <!-- Top Header -->
        <header class="h-16 shrink-0 bg-white border-b border-zinc-200 flex items-center px-8 justify-between z-10">
            <div class="flex items-center flex-1 gap-4">
                <button @click="mobileMenuOpen = true" class="md:hidden p-2 -ml-2 text-zinc-900 hover:text-zinc-600 focus:outline-none transition-colors">
                    <i class="ph ph-list text-2xl"></i>
                </button>
                
                <div class="hidden sm:flex items-center gap-3">
                    @php
                        $hour = now()->format('H');
                        if ($hour < 12) {
                            $greeting = 'Good Morning';
                            $icon = 'ph-sun';
                        } elseif ($hour < 17) {
                            $greeting = 'Good Afternoon';
                            $icon = 'ph-sun-horizon';
                        } else {
                            $greeting = 'Good Evening';
                            $icon = 'ph-moon';
                        }
                    @endphp
                    <div class="flex items-center gap-2 text-[13px] font-medium text-zinc-600 bg-zinc-50 px-4 py-1.5 rounded-full border border-zinc-200">
                        <i class="ph {{ $icon }} text-lg text-zinc-900"></i>
                        <span>{{ $greeting }}, {{ auth()->user()->name ?? 'Agent' }}</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <button class="w-9 h-9 flex items-center justify-center rounded-md border border-zinc-200 bg-white hover:bg-zinc-50 transition-all relative">
                    <i class="ph ph-bell text-lg text-zinc-600"></i>
                    <span class="absolute top-2 right-2 w-1.5 h-1.5 bg-zinc-900 rounded-full"></span>
                </button>
                <div class="h-8 w-[1px] bg-zinc-200"></div>
                <button class="h-8 px-3 rounded-md bg-zinc-900 text-white text-xs font-medium">New Lead</button>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8 w-full z-0">
            {{ $slot ?? '' }}
            @yield('content')
        </main>
    </div>

    @livewireScripts
</body>
</html>