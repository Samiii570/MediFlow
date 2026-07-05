<x-guest-layout>
    <div class="mb-8 anim-fade">
        <h1 class="text-2xl font-extrabold text-slate-800">Welcome Back</h1>
        <p class="text-slate-500 text-sm mt-1">Sign in to your MediFlow account</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-xs font-semibold uppercase tracking-wider text-slate-500" />
            <div class="mt-1.5 relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <x-text-input id="email" class="block w-full rounded-xl border-slate-200 pl-11 focus:border-teal-500 focus:ring-teal-500 text-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="you@example.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" class="text-xs font-semibold uppercase tracking-wider text-slate-500" />
            <div class="mt-1.5 relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <x-text-input id="password" class="block w-full rounded-xl border-slate-200 pl-11 focus:border-teal-500 focus:ring-teal-500 text-sm" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded-lg border-slate-300 text-teal-600 shadow-sm focus:ring-teal-500 w-4 h-4" name="remember">
                <span class="text-sm text-slate-600">{{ __('Remember me') }}</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-teal-600 hover:text-teal-700 transition-colors" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-teal-500 to-blue-600 text-white px-6 py-3 rounded-xl text-sm font-bold hover:from-teal-600 hover:to-blue-700 transition-all shadow-lg shadow-teal-500/25 hover:shadow-xl hover:shadow-teal-500/30 hover:-translate-y-0.5 active:translate-y-0">
            {{ __('Sign In') }}
        </button>
    </form>

    <div class="mt-6 text-center">
        <p class="text-sm text-slate-500">
            Don't have an account?
            <a href="{{ route('register') }}" class="font-semibold text-teal-600 hover:text-teal-700 transition-colors">Register as Patient</a>
        </p>
    </div>

    <div class="mt-6 border-t border-slate-200 pt-5">
        <p class="text-xs font-semibold text-slate-400 mb-3 text-center uppercase tracking-wider">Quick Demo Access</p>
        <div class="grid grid-cols-2 gap-2 text-xs">
            <div class="bg-gradient-to-br from-slate-50 to-slate-100/80 rounded-xl px-3 py-2.5 border border-slate-200/60 hover:border-teal-300 hover:shadow-sm transition-all cursor-default">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                    <span class="font-semibold text-slate-700">Admin</span>
                </div>
                <p class="text-slate-400 mt-0.5 text-[11px]">admin@mediflow.com</p>
            </div>
            <div class="bg-gradient-to-br from-slate-50 to-slate-100/80 rounded-xl px-3 py-2.5 border border-slate-200/60 hover:border-blue-300 hover:shadow-sm transition-all cursor-default">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                    <span class="font-semibold text-slate-700">Doctor</span>
                </div>
                <p class="text-slate-400 mt-0.5 text-[11px]">dr.smith@mediflow.com</p>
            </div>
            <div class="bg-gradient-to-br from-slate-50 to-slate-100/80 rounded-xl px-3 py-2.5 border border-slate-200/60 hover:border-teal-300 hover:shadow-sm transition-all cursor-default">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                    <span class="font-semibold text-slate-700">Patient</span>
                </div>
                <p class="text-slate-400 mt-0.5 text-[11px]">patient1@mediflow.com</p>
            </div>
            <div class="bg-gradient-to-br from-slate-50 to-slate-100/80 rounded-xl px-3 py-2.5 border border-slate-200/60 hover:border-purple-300 hover:shadow-sm transition-all cursor-default">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 bg-purple-500 rounded-full"></span>
                    <span class="font-semibold text-slate-700">Pharmacist</span>
                </div>
                <p class="text-slate-400 mt-0.5 text-[11px]">pharmacist@mediflow.com</p>
            </div>
            <div class="bg-gradient-to-br from-slate-50 to-slate-100/80 rounded-xl px-3 py-2.5 border border-slate-200/60 hover:border-amber-300 hover:shadow-sm transition-all cursor-default col-span-2">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 bg-amber-500 rounded-full"></span>
                    <span class="font-semibold text-slate-700">Receptionist</span>
                </div>
                <p class="text-slate-400 mt-0.5 text-[11px]">receptionist@mediflow.com</p>
            </div>
        </div>
        <p class="text-[10px] text-slate-400 text-center mt-2">Password for all: <code class="bg-slate-100 px-1 py-0.5 rounded text-slate-500">password</code></p>
    </div>
</x-guest-layout>
