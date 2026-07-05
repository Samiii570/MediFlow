<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MediFlow') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-15px); } }
        @keyframes pulse-dot { 0%, 100% { opacity: 0.3; transform: scale(1); } 50% { opacity: 0.8; transform: scale(1.2); } }
        @keyframes slide-in { from { opacity: 0; transform: translateX(30px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes fade-up { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .anim-float { animation: float 5s ease-in-out infinite; }
        .anim-float-d1 { animation: float 6s ease-in-out 0.5s infinite; }
        .anim-float-d2 { animation: float 7s ease-in-out 1s infinite; }
        .anim-dot { animation: pulse-dot 3s ease-in-out infinite; }
        .anim-slide { animation: slide-in 0.6s ease-out both; }
        .anim-fade { animation: fade-up 0.5s ease-out both; }
        .auth-bg { background: linear-gradient(135deg, #0f766e 0%, #1e40af 50%, #7c3aed 100%); }
    </style>
</head>
<body class="font-sans text-slate-900 antialiased">
    <div class="min-h-screen flex">
        {{-- Left panel - branding --}}
        <div class="hidden lg:flex lg:w-1/2 auth-bg relative overflow-hidden flex-col justify-between p-12">
            {{-- Background decoration --}}
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-20 left-10 w-64 h-64 bg-white/5 rounded-full anim-float"></div>
                <div class="absolute bottom-20 right-10 w-80 h-80 bg-white/5 rounded-full anim-float-d1"></div>
                <div class="absolute top-1/3 right-1/4 w-20 h-20 bg-white/5 rounded-2xl anim-float-d2 rotate-12"></div>
                <div class="absolute bottom-1/3 left-1/4 w-12 h-12 bg-white/5 rounded-xl anim-float -rotate-12"></div>
                <div class="absolute top-1/2 left-1/3 w-3 h-3 bg-white/20 rounded-full anim-dot"></div>
                <div class="absolute top-1/4 right-1/3 w-2 h-2 bg-white/30 rounded-full anim-dot" style="animation-delay:1s"></div>
                <div class="absolute bottom-1/2 right-1/4 w-4 h-4 bg-white/15 rounded-full anim-dot" style="animation-delay:2s"></div>
            </div>

            <div class="relative">
                <a href="/" class="flex items-center gap-3">
                    <div class="w-11 h-11 bg-white/15 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/20">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                    <span class="text-2xl font-extrabold text-white tracking-tight">MediFlow</span>
                </a>
            </div>

            <div class="relative space-y-8">
                <h2 class="text-4xl font-extrabold text-white leading-tight">Smart Hospital<br>Operations Platform</h2>
                <p class="text-teal-100/70 text-lg max-w-md leading-relaxed">Manage appointments, prescriptions, pharmacy sales, and lab workflows — all in one beautiful dashboard.</p>

                <div class="space-y-4">
                    <div class="flex items-center gap-4 bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/10">
                        <div class="w-10 h-10 bg-emerald-400/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-white font-semibold text-sm">Role-Based Access</p>
                            <p class="text-teal-200/50 text-xs">Admin, Doctor, Patient, Pharmacist, Receptionist</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/10">
                        <div class="w-10 h-10 bg-blue-400/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-white font-semibold text-sm">PDF Generation</p>
                            <p class="text-teal-200/50 text-xs">Prescriptions & invoices as downloadable PDFs</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/10">
                        <div class="w-10 h-10 bg-purple-400/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </div>
                        <div>
                            <p class="text-white font-semibold text-sm">Real-Time Analytics</p>
                            <p class="text-teal-200/50 text-xs">Interactive charts for data-driven decisions</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative">
                <p class="text-teal-200/40 text-sm">&copy; {{ date('Y') }} MediFlow. All rights reserved.</p>
            </div>
        </div>

        {{-- Right panel - form --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 bg-gradient-to-br from-slate-50 via-white to-teal-50/30">
            <div class="w-full max-w-md anim-slide">
                {{-- Mobile logo --}}
                <div class="lg:hidden mb-8 text-center anim-fade">
                    <a href="/" class="inline-flex items-center gap-3">
                        <div class="w-11 h-11 bg-gradient-to-br from-teal-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </div>
                        <span class="text-xl font-bold text-slate-800">MediFlow</span>
                    </a>
                </div>

                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
