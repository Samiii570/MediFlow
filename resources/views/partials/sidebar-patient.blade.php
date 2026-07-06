<a href="{{ route('patient.dashboard') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('patient.dashboard') ? 'active' : 'text-slate-600' }}">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
    Dashboard
</a>
<a href="{{ route('patient.appointments.create') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold bg-gradient-to-r from-teal-500 to-blue-500 text-white shadow-lg shadow-teal-500/25 hover:shadow-xl hover:shadow-teal-500/30 hover:-translate-y-0.5 transition-all">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
    Book Appointment
</a>
<a href="{{ route('patient.appointments.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('patient.appointments.*') ? 'active' : 'text-slate-600' }}">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
    My Appointments
</a>
<a href="{{ route('patient.prescriptions.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('patient.prescriptions.*') ? 'active' : 'text-slate-600' }}">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
    Prescriptions
</a>
<a href="{{ route('patient.lab-reports.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('patient.lab-reports.*') ? 'active' : 'text-slate-600' }}">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
    Lab Reports
</a>
<a href="{{ route('patient.timeline') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request()->routeIs('patient.timeline') ? 'active' : 'text-slate-600' }}">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    My Timeline
</a>
