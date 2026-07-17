<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MediFlow - Smart Hospital Operations</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .hero-gradient { background: linear-gradient(135deg, #0f766e 0%, #1e40af 50%, #7c3aed 100%); }
        .hero-gradient::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.08) 1px, transparent 1px);
            background-size: 40px 40px;
            animation: drift 20s linear infinite;
        }
        @keyframes drift { 0% { transform: translate(0, 0); } 100% { transform: translate(40px, 40px); } }
        @keyframes float { 0%, 100% { transform: translateY(0px) rotate(0deg); } 50% { transform: translateY(-20px) rotate(5deg); } }
        @keyframes float2 { 0%, 100% { transform: translateY(0px) rotate(0deg); } 50% { transform: translateY(-15px) rotate(-3deg); } }
        @keyframes pulse-glow { 0%, 100% { opacity: 0.4; transform: scale(1); } 50% { opacity: 0.7; transform: scale(1.05); } }
        @keyframes slide-up { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes slide-in-left { from { opacity: 0; transform: translateX(-40px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes fade-in { from { opacity: 0; } to { opacity: 1; } }
        @keyframes scale-in { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }
        @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
        .anim-float { animation: float 6s ease-in-out infinite; }
        .anim-float2 { animation: float2 5s ease-in-out infinite 0.5s; }
        .anim-pulse { animation: pulse-glow 3s ease-in-out infinite; }
        .anim-slide-up { animation: slide-up 0.8s ease-out both; }
        .anim-slide-up-d1 { animation: slide-up 0.8s ease-out 0.1s both; }
        .anim-slide-up-d2 { animation: slide-up 0.8s ease-out 0.2s both; }
        .anim-slide-up-d3 { animation: slide-up 0.8s ease-out 0.3s both; }
        .anim-slide-up-d4 { animation: slide-up 0.8s ease-out 0.4s both; }
        .anim-slide-in { animation: slide-in-left 0.8s ease-out 0.2s both; }
        .anim-scale { animation: scale-in 0.6s ease-out both; }
        .feature-card:hover .feature-icon { transform: scale(1.1) rotate(-5deg); }
        .feature-icon { transition: transform 0.3s ease; }
        .role-card { transition: all 0.3s ease; }
        .role-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px -12px rgba(0,0,0,0.15); }
        .role-card:hover .role-icon { transform: scale(1.15); }
        .role-icon { transition: transform 0.3s ease; }
        .stat-number { font-variant-numeric: tabular-nums; }
        .btn-glow { position: relative; overflow: hidden; }
        .btn-glow::after { content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: linear-gradient(transparent, rgba(255,255,255,0.1), transparent); transform: rotate(45deg); transition: 0.5s; opacity: 0; }
        .btn-glow:hover::after { opacity: 1; left: 100%; }
        .cta-section { background: linear-gradient(135deg, #0f766e 0%, #1e40af 100%); position: relative; overflow: hidden; }
        .cta-section::before { content: ''; position: absolute; inset: 0; background: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%); }
        .glass-card { background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); }
    </style>
</head>
<body class="font-sans antialiased bg-slate-50">
    <div class="min-h-screen">
        {{-- Nav --}}
        <nav class="bg-white/80 backdrop-blur-md border-b border-slate-200/60 sticky top-0 z-50 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-9 h-9 bg-gradient-to-br from-teal-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg transition-shadow">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                    <span class="text-xl font-bold text-slate-800 tracking-tight">MediFlow</span>
                </a>
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-teal-500 text-white px-5 py-2 rounded-xl text-sm font-semibold hover:bg-teal-600 transition-all shadow-md shadow-teal-500/20 hover:shadow-lg hover:shadow-teal-500/30">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-teal-600 transition-colors px-3 py-2">Log in</a>
                        <a href="{{ route('register') }}" class="bg-teal-500 text-white px-5 py-2 rounded-xl text-sm font-semibold hover:bg-teal-600 transition-all shadow-md shadow-teal-500/20 hover:shadow-lg hover:shadow-teal-500/30 btn-glow">Register</a>
                    @endauth
                </div>
            </div>
        </nav>

        {{-- Hero --}}
        <div class="hero-gradient relative overflow-hidden">
            {{-- Floating shapes --}}
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-20 left-10 w-72 h-72 bg-white/5 rounded-full anim-float"></div>
                <div class="absolute bottom-10 right-20 w-96 h-96 bg-white/5 rounded-full anim-float2"></div>
                <div class="absolute top-40 right-40 w-24 h-24 bg-teal-400/10 rounded-2xl anim-float rotate-12"></div>
                <div class="absolute bottom-32 left-32 w-16 h-16 bg-blue-400/10 rounded-xl anim-float2 -rotate-12"></div>
                <div class="absolute top-1/2 left-1/4 w-3 h-3 bg-white/20 rounded-full anim-pulse"></div>
                <div class="absolute top-1/3 right-1/3 w-2 h-2 bg-white/30 rounded-full anim-pulse" style="animation-delay: 1s;"></div>
                <div class="absolute bottom-1/3 left-2/3 w-4 h-4 bg-white/15 rounded-full anim-pulse" style="animation-delay: 2s;"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 relative">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-4 py-1.5 mb-6 anim-slide-up">
                            <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                            <span class="text-xs font-medium text-teal-100">Trusted by 50+ Hospitals</span>
                        </div>
                        <h1 class="text-4xl lg:text-6xl font-extrabold text-white leading-tight anim-slide-up">
                            Smart Hospital <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-200 to-blue-200">Operations Platform</span>
                        </h1>
                        <p class="mt-6 text-lg text-teal-100/80 max-w-xl leading-relaxed anim-slide-up-d1">
                            A comprehensive RDBMS-powered hospital management system. From patient registration to pharmacy sales, manage every aspect of your healthcare facility.
                        </p>
                        <div class="mt-8 flex flex-wrap gap-4 anim-slide-up-d2">
                            @auth
                                <a href="{{ route('dashboard') }}" class="bg-white text-teal-700 px-7 py-3.5 rounded-xl text-sm font-bold hover:bg-teal-50 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 btn-glow inline-flex items-center gap-2">
                                    Go to Dashboard
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="bg-white text-teal-700 px-7 py-3.5 rounded-xl text-sm font-bold hover:bg-teal-50 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 btn-glow inline-flex items-center gap-2">
                                    Get Started Free
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                </a>
                                <a href="{{ route('login') }}" class="border-2 border-white/30 text-white px-7 py-3.5 rounded-xl text-sm font-bold hover:bg-white/10 hover:border-white/50 transition-all">Log In</a>
                            @endauth
                        </div>
                    </div>

                    {{-- Hero illustration --}}
                    <div class="hidden lg:block anim-slide-in">
                        <div class="relative">
                            <div class="glass-card rounded-3xl p-8">
                                <div class="space-y-4">
                                    <div class="flex items-center gap-4 bg-white/10 rounded-2xl p-4">
                                        <div class="w-12 h-12 bg-emerald-400/20 rounded-xl flex items-center justify-center">
                                            <svg class="w-6 h-6 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>
                                        <div>
                                            <p class="text-white font-semibold text-sm">Patient Registered</p>
                                            <p class="text-teal-200/60 text-xs">Token #A-042 assigned</p>
                                        </div>
                                        <span class="ml-auto text-xs text-emerald-300">Just now</span>
                                    </div>
                                    <div class="flex items-center gap-4 bg-white/10 rounded-2xl p-4">
                                        <div class="w-12 h-12 bg-blue-400/20 rounded-xl flex items-center justify-center">
                                            <svg class="w-6 h-6 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        </div>
                                        <div>
                                            <p class="text-white font-semibold text-sm">Prescription Ready</p>
                                            <p class="text-teal-200/60 text-xs">3 medicines prescribed</p>
                                        </div>
                                        <span class="ml-auto text-xs text-blue-300">2 min ago</span>
                                    </div>
                                    <div class="flex items-center gap-4 bg-white/10 rounded-2xl p-4">
                                        <div class="w-12 h-12 bg-purple-400/20 rounded-xl flex items-center justify-center">
                                            <svg class="w-6 h-6 text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                        </div>
                                        <div>
                                            <p class="text-white font-semibold text-sm">Lab Report Uploaded</p>
                                            <p class="text-teal-200/60 text-xs">Blood test complete</p>
                                        </div>
                                        <span class="ml-auto text-xs text-purple-300">5 min ago</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats bar --}}
        <div class="bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="text-3xl font-extrabold text-teal-600 stat-number" data-target="50">0</div>
                        <div class="text-sm text-slate-500 mt-1">Partner Hospitals</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-extrabold text-blue-600 stat-number" data-target="10000">0</div>
                        <div class="text-sm text-slate-500 mt-1">Patients Managed</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-extrabold text-purple-600 stat-number" data-target="500">0</div>
                        <div class="text-sm text-slate-500 mt-1">Doctors Online</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-extrabold text-emerald-600 stat-number" data-target="99">0</div>
                        <div class="text-sm text-slate-500 mt-1">% Uptime</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Features --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center mb-16">
                <span class="inline-block bg-teal-50 text-teal-700 text-xs font-semibold px-3 py-1 rounded-full mb-3 uppercase tracking-wider">Features</span>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-slate-800">Everything Your Hospital Needs</h2>
                <p class="text-slate-500 mt-3 max-w-lg mx-auto">A complete platform covering patient care, clinical workflows, pharmacy operations, and administrative analytics.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                $features = [
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>', 'title' => 'Patient Management', 'desc' => 'Register patients, track their complete journey from registration through treatment and follow-up.', 'color' => 'from-blue-500 to-indigo-600'],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>', 'title' => 'Smart Scheduling', 'desc' => 'Book appointments by department and doctor with automatic token generation and live queue tracking.', 'color' => 'from-teal-500 to-emerald-600'],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>', 'title' => 'Digital Prescriptions', 'desc' => 'Doctors create prescriptions with multiple medicines, downloadable as professional PDF documents.', 'color' => 'from-purple-500 to-violet-600'],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>', 'title' => 'Lab Workflow', 'desc' => 'Order lab tests, track status from pending to completed, upload reports with remarks.', 'color' => 'from-amber-500 to-orange-600'],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>', 'title' => 'Pharmacy Operations', 'desc' => 'Process sales with multiple line items, auto-calculate totals, decrement stock, and generate invoice PDFs.', 'color' => 'from-rose-500 to-pink-600'],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>', 'title' => 'Analytics Dashboard', 'desc' => 'Admin analytics with Chart.js: appointment trends, revenue tracking, department load, and inventory levels.', 'color' => 'from-cyan-500 to-blue-600'],
                ];
                @endphp
                @foreach($features as $feature)
                <div class="feature-card bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group cursor-default">
                    <div class="feature-icon w-12 h-12 bg-gradient-to-br {{ $feature['color'] }} rounded-xl flex items-center justify-center mb-4 shadow-lg group-hover:shadow-xl">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">{!! $feature['icon'] !!}</svg>
                    </div>
                    <h3 class="font-bold text-slate-800 text-lg mb-2">{{ $feature['title'] }}</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">{{ $feature['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Roles --}}
        <div class="bg-gradient-to-b from-slate-50 to-white border-t border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <div class="text-center mb-16">
                    <span class="inline-block bg-blue-50 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full mb-3 uppercase tracking-wider">Roles</span>
                    <h2 class="text-3xl lg:text-4xl font-extrabold text-slate-800">Built for Every Role</h2>
                    <p class="text-slate-500 mt-3">Role-based access control ensures each user sees exactly what they need.</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">
                    @php
                    $roles = [
                        ['name' => 'Admin', 'color' => 'from-red-500 to-rose-600', 'desc' => 'Full system access, analytics, user management'],
                        ['name' => 'Doctor', 'color' => 'from-blue-500 to-indigo-600', 'desc' => 'Appointments, prescriptions, lab orders'],
                        ['name' => 'Patient', 'color' => 'from-teal-500 to-emerald-600', 'desc' => 'Book appointments, view records, timeline'],
                        ['name' => 'Pharmacist', 'color' => 'from-purple-500 to-violet-600', 'desc' => 'Inventory, sales, invoice generation'],
                        ['name' => 'Receptionist', 'color' => 'from-amber-500 to-orange-600', 'desc' => 'Check-ins, queue management'],
                    ];
                    @endphp
                    @foreach($roles as $role)
                    <div class="role-card text-center p-6 rounded-2xl border border-slate-200 bg-white cursor-default">
                        <div class="role-icon w-16 h-16 bg-gradient-to-br {{ $role['color'] }} rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                            <span class="text-white font-extrabold text-xl">{{ substr($role['name'], 0, 1) }}</span>
                        </div>
                        <h4 class="font-bold text-slate-800 text-lg">{{ $role['name'] }}</h4>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">{{ $role['desc'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- CTA --}}
        <div class="cta-section">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative">
                <div class="text-center max-w-2xl mx-auto">
                    <h2 class="text-3xl lg:text-4xl font-extrabold text-white mb-4">Ready to Transform Your Hospital?</h2>
                    <p class="text-teal-100/80 text-lg mb-8">Join dozens of healthcare facilities already using MediFlow to streamline their operations and improve patient care.</p>
                    <div class="flex flex-wrap justify-center gap-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="bg-white text-teal-700 px-8 py-4 rounded-xl text-sm font-bold hover:bg-teal-50 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 btn-glow inline-flex items-center gap-2">
                                Go to Dashboard
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="bg-white text-teal-700 px-8 py-4 rounded-xl text-sm font-bold hover:bg-teal-50 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 btn-glow inline-flex items-center gap-2">
                                Start Free Today
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </a>
                            <a href="{{ route('login') }}" class="border-2 border-white/30 text-white px-8 py-4 rounded-xl text-sm font-bold hover:bg-white/10 hover:border-white/50 transition-all">Log In</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <footer class="bg-slate-900 text-slate-400 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-teal-500 to-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </div>
                        <span class="font-bold text-white">MediFlow</span>
                    </div>
                    <p class="text-sm">Smart Hospital Operations Platform &copy; {{ date('Y') }}</p>
                    <div class="flex items-center gap-4 text-sm">
                        <a href="#" class="hover:text-teal-400 transition-colors">Privacy</a>
                        <a href="#" class="hover:text-teal-400 transition-colors">Terms</a>
                        <a href="#" class="hover:text-teal-400 transition-colors">Support</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const counters = document.querySelectorAll('.stat-number');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const el = entry.target;
                        const target = parseInt(el.dataset.target);
                        let current = 0;
                        const increment = target / 60;
                        const timer = setInterval(() => {
                            current += increment;
                            if (current >= target) {
                                current = target;
                                clearInterval(timer);
                            }
                            el.textContent = target >= 1000 ? Math.floor(current).toLocaleString() + '+' : Math.floor(current) + (target === 99 ? '%' : '+');
                        }, 30);
                        observer.unobserve(el);
                    }
                });
            }, { threshold: 0.5 });
            counters.forEach(c => observer.observe(c));
        });
    </script>
</body>
</html>
