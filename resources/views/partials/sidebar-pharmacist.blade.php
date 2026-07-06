<a href="{{ route('pharmacist.dashboard') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('pharmacist.dashboard') ? 'active' : 'text-slate-600' }}">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
    Dashboard
</a>
<a href="{{ route('pharmacist.medicines.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('pharmacist.medicines.*') ? 'active' : 'text-slate-600' }}">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
    Medicines
</a>
<a href="{{ route('pharmacist.sales.create') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold bg-gradient-to-r from-teal-500 to-blue-500 text-white shadow-lg shadow-teal-500/25 hover:shadow-xl hover:shadow-teal-500/30 hover:-translate-y-0.5 transition-all">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
    New Sale
</a>
<a href="{{ route('pharmacist.sales.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('pharmacist.sales.*') ? 'active' : 'text-slate-600' }}">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
    Sales History
</a>
