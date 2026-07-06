<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'MediFlow') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            @keyframes fade-in { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
            .content-enter { animation: fade-in 0.3s ease-out both; }
            .sidebar-link { transition: all 0.2s ease; position: relative; }
            .sidebar-link:hover { background: linear-gradient(135deg, rgba(13,148,136,0.08), rgba(37,99,235,0.05)); }
            .sidebar-link.active {
                background: linear-gradient(135deg, rgba(13,148,136,0.12), rgba(37,99,235,0.08));
                color: #0d9488;
                font-weight: 600;
            }
            .sidebar-link.active::before {
                content: '';
                position: absolute;
                left: 0;
                top: 4px;
                bottom: 4px;
                width: 3px;
                background: linear-gradient(to bottom, #0d9488, #2563eb);
                border-radius: 0 4px 4px 0;
            }
            .kpi-card { transition: all 0.3s ease; }
            .kpi-card:hover { transform: translateY(-2px); box-shadow: 0 12px 24px -8px rgba(0,0,0,0.08); }
            .kpi-icon { transition: transform 0.3s ease; }
            .kpi-card:hover .kpi-icon { transform: scale(1.1) rotate(-3deg); }
            .toast-success { animation: slide-in-right 0.3s ease-out, fade-out 0.3s ease-in 3.7s; }
            .toast-error { animation: slide-in-right 0.3s ease-out, fade-out 0.3s ease-in 3.7s; }
            @keyframes slide-in-right { from { opacity: 0; transform: translateX(40px); } to { opacity: 1; transform: translateX(0); } }
            @keyframes fade-out { from { opacity: 1; } to { opacity: 0; } }
        </style>
    </head>
    <body class="h-full font-sans antialiased bg-slate-50/80">
        <div class="min-h-full" x-data="{ sidebarOpen: false }">
            {{-- Mobile sidebar overlay --}}
            <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false"></div>

            {{-- Sidebar --}}
            <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-slate-200/80 transform transition-transform duration-300 ease-in-out lg:translate-x-0 flex flex-col shadow-xl lg:shadow-none">
                {{-- Logo --}}
                <div class="flex items-center gap-3 px-5 py-5 border-b border-slate-100">
                    <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-br from-teal-500 to-blue-600 rounded-xl shadow-lg shadow-teal-500/20">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-extrabold text-slate-800 tracking-tight">MediFlow</h1>
                        <p class="text-[10px] text-slate-400 uppercase tracking-widest font-medium">Smart Hospital Ops</p>
                    </div>
                </div>

                {{-- Navigation --}}
                <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto scrollbar-thin scrollbar-thumb-slate-200 scrollbar-track-transparent">
                    @php $role = auth()->user()->role; @endphp
                    @if($role === 'admin')
                        @include('partials.sidebar-admin')
                    @elseif($role === 'doctor')
                        @include('partials.sidebar-doctor')
                    @elseif($role === 'patient')
                        @include('partials.sidebar-patient')
                    @elseif($role === 'pharmacist')
                        @include('partials.sidebar-pharmacist')
                    @elseif($role === 'receptionist')
                        @include('partials.sidebar-receptionist')
                    @endif
                </nav>

                {{-- User info --}}
                <div class="border-t border-slate-100 p-4">
                    <div class="flex items-center gap-3 p-2 rounded-xl hover:bg-slate-50 transition-colors">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-teal-400 to-blue-500 flex items-center justify-center text-white text-xs font-bold shadow-md">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-slate-400 uppercase tracking-wider font-medium">{{ $role }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all" title="Logout">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Main content --}}
            <div class="lg:pl-72 flex flex-col min-h-screen">
                {{-- Top bar --}}
                <div class="sticky top-0 z-30 bg-white/70 backdrop-blur-xl border-b border-slate-200/60">
                    <div class="flex items-center gap-4 px-4 sm:px-6 h-14">
                        <button @click="sidebarOpen = true" class="lg:hidden text-slate-500 hover:text-slate-700 p-1.5 hover:bg-slate-100 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                        <div class="flex-1"></div>

                        {{-- Toast notifications --}}
                        @if(session('success'))
                            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)" class="toast-success fixed top-4 right-4 z-50 max-w-sm bg-white border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl shadow-xl shadow-emerald-500/10 flex items-center gap-3">
                                <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span class="text-sm font-medium">{{ session('success') }}</span>
                                <button @click="show = false" class="ml-1 text-slate-400 hover:text-slate-600"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)" class="toast-error fixed top-4 right-4 z-50 max-w-sm bg-white border border-red-200 text-red-700 px-4 py-3 rounded-xl shadow-xl shadow-red-500/10 flex items-center gap-3">
                                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <span class="text-sm font-medium">{{ session('error') }}</span>
                                <button @click="show = false" class="ml-1 text-slate-400 hover:text-slate-600"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                            </div>
                        @endif

                        <div class="flex items-center gap-2 text-xs text-slate-400 font-medium">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>{{ now()->format('D, M j, Y') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Page content --}}
                <main class="flex-1 p-4 sm:p-6 lg:p-8 content-enter">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
        <script>
            function formatCurrency(amount) {
                return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(amount);
            }
            function animateValue(el, start, end, duration, prefix = '', suffix = '') {
                let startTime = null;
                function step(timestamp) {
                    if (!startTime) startTime = timestamp;
                    const progress = Math.min((timestamp - startTime) / duration, 1);
                    const eased = 1 - Math.pow(1 - progress, 3);
                    const current = Math.floor(start + (end - start) * eased);
                    el.textContent = prefix + current.toLocaleString() + suffix;
                    if (progress < 1) requestAnimationFrame(step);
                }
                requestAnimationFrame(step);
            }
        </script>
        @stack('scripts')
    </body>
</html>
