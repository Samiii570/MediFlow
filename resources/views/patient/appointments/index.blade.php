<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-slate-800 leading-tight">My Appointments</h2>
                <p class="text-sm text-slate-500 mt-1">View and manage your appointments</p>
            </div>
            <a href="{{ route('patient.appointments.create') }}" class="px-4 py-2 bg-teal-600 text-white text-sm font-medium rounded-lg hover:bg-teal-700 transition">
                + Book Appointment
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-200">
                                <th class="px-6 py-4 text-left font-semibold text-slate-700">Doctor</th>
                                <th class="px-6 py-4 text-left font-semibold text-slate-700">Department</th>
                                <th class="px-6 py-4 text-left font-semibold text-slate-700">Date</th>
                                <th class="px-6 py-4 text-left font-semibold text-slate-700">Token #</th>
                                <th class="px-6 py-4 text-left font-semibold text-slate-700">Status</th>
                                <th class="px-6 py-4 text-left font-semibold text-slate-700">Follow-up</th>
                                <th class="px-6 py-4 text-left font-semibold text-slate-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($appointments as $appointment)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-slate-800">Dr. {{ $appointment->doctor->name ?? 'N/A' }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600">{{ $appointment->doctor->department->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-slate-600">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</td>
                                    <td class="px-6 py-4">
                                        <span class="font-mono text-slate-800">{{ $appointment->token_no ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusClasses = match($appointment->status ?? '') {
                                                'pending' => 'bg-amber-100 text-amber-700',
                                                'in_progress' => 'bg-blue-100 text-blue-700',
                                                'completed' => 'bg-emerald-100 text-emerald-700',
                                                'cancelled' => 'bg-red-100 text-red-700',
                                                default => 'bg-slate-100 text-slate-700',
                                            };
                                        @endphp
                                        <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $statusClasses }}">
                                            {{ ucfirst(str_replace('_', ' ', $appointment->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600">
                                        {{ $appointment->follow_up_date ? \Carbon\Carbon::parse($appointment->follow_up_date)->format('M d, Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('patient.appointments.show', $appointment) }}" class="text-teal-600 hover:text-teal-700 font-medium text-xs">View</a>
                                            @if($appointment->status === 'pending')
                                                <form action="{{ route('patient.appointments.cancel', $appointment) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this appointment?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-red-600 hover:text-red-700 font-medium text-xs">Cancel</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="text-slate-500 text-sm">No appointments found</p>
                                        <a href="{{ route('patient.appointments.create') }}" class="inline-block mt-3 text-teal-600 hover:text-teal-700 text-sm font-medium">Book your first appointment</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($appointments->hasPages())
                    <div class="px-6 py-4 border-t border-slate-200">
                        {{ $appointments->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
