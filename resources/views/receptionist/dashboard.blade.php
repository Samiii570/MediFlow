<x-app-layout>
    <div class="space-y-6">
        <div><h1 class="text-2xl font-bold text-slate-800">Receptionist Dashboard</h1><p class="text-slate-500 mt-1">Manage patient check-ins and queue</p></div>

        <!-- KPI Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 bg-teal-50 rounded-xl flex items-center justify-center"><svg class="w-6 h-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                    <div><p class="text-2xl font-bold text-slate-800">{{ $todayAppointments->count() }}</p><p class="text-xs text-slate-500">Today's Appointments</p></div>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 bg-amber-50 rounded-xl flex items-center justify-center"><svg class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                    <div><p class="text-2xl font-bold text-amber-600">{{ $todayAppointments->where('status', 'pending')->count() }}</p><p class="text-xs text-slate-500">Pending Check-ins</p></div>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 bg-blue-50 rounded-xl flex items-center justify-center"><svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
                    <div><p class="text-2xl font-bold text-blue-600">{{ $totalPatients }}</p><p class="text-xs text-slate-500">Total Patients</p></div>
                </div>
            </div>
        </div>

        <!-- Department Summary -->
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
            <h3 class="text-lg font-semibold text-slate-800 mb-4">Departments</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
                @foreach($departments as $dept)
                <div class="text-center p-3 bg-slate-50 rounded-xl border border-slate-100">
                    <div class="text-xl font-bold text-teal-600">{{ $dept->doctors_count }}</div>
                    <div class="text-xs text-slate-600 mt-1">{{ $dept->name }}</div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Today's Appointments -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-800">Today's Appointments</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Token#</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Patient</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Doctor</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Department</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($todayAppointments as $appt)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-3 font-mono font-semibold text-teal-600">#{{ $appt->token_no }}</td>
                            <td class="px-6 py-3 font-medium text-slate-800">{{ $appt->patient->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-3 text-slate-600">Dr. {{ $appt->doctor->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-3 text-slate-600">{{ $appt->doctor->department->name ?? 'N/A' }}</td>
                            <td class="px-6 py-3">
                                @php
                                    $sc = ['pending' => 'bg-amber-100 text-amber-700', 'in_progress' => 'bg-blue-100 text-blue-700', 'completed' => 'bg-emerald-100 text-emerald-700'];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $sc[$appt->status] ?? '' }}">{{ ucfirst(str_replace('_', ' ', $appt->status)) }}</span>
                            </td>
                            <td class="px-6 py-3 text-right">
                                @if($appt->status === 'pending')
                                <form action="{{ route('receptionist.checkin', $appt) }}" method="POST" class="inline">@csrf @method('PATCH')
                                    <button type="submit" class="bg-teal-500 text-white px-4 py-1.5 rounded-lg text-xs font-medium hover:bg-teal-600 transition">Check In</button>
                                </form>
                                @else
                                <span class="text-slate-400 text-xs">--</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="px-6 py-12 text-center text-slate-400">No appointments today</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
