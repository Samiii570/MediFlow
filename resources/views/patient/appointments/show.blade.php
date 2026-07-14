<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-slate-800 leading-tight">Appointment Details</h2>
                <p class="text-sm text-slate-500 mt-1">Appointment #{{ $appointment->token_no ?? 'N/A' }}</p>
            </div>
            <a href="{{ route('patient.appointments.index') }}" class="text-sm text-slate-600 hover:text-slate-800 font-medium">
                &larr; Back to Appointments
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-slate-800">Appointment Information</h3>
                    @php
                        $statusClasses = match($appointment->status ?? '') {
                            'pending' => 'bg-amber-100 text-amber-700',
                            'in_progress' => 'bg-blue-100 text-blue-700',
                            'completed' => 'bg-emerald-100 text-emerald-700',
                            'cancelled' => 'bg-red-100 text-red-700',
                            default => 'bg-slate-100 text-slate-700',
                        };
                    @endphp
                    <span class="text-xs px-3 py-1.5 rounded-full font-medium {{ $statusClasses }}">
                        {{ ucfirst(str_replace('_', ' ', $appointment->status)) }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Doctor</p>
                            <p class="text-sm font-medium text-slate-800">Dr. {{ $appointment->doctor->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Department</p>
                            <p class="text-sm font-medium text-slate-800">{{ $appointment->doctor->department->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Specialization</p>
                            <p class="text-sm font-medium text-slate-800">{{ $appointment->doctor->specialization ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Date</p>
                            <p class="text-sm font-medium text-slate-800">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Token Number</p>
                            <p class="text-sm font-medium text-slate-800 font-mono">{{ $appointment->token_no ?? 'N/A' }}</p>
                        </div>
                        @if($appointment->follow_up_date)
                            <div>
                                <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Follow-up Date</p>
                                <p class="text-sm font-medium text-slate-800">{{ \Carbon\Carbon::parse($appointment->follow_up_date)->format('F d, Y') }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                @if($appointment->status === 'pending')
                    <div class="mt-6 pt-6 border-t border-slate-200">
                        <form action="{{ route('patient.appointments.cancel', $appointment) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this appointment?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition">
                                Cancel Appointment
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            @if(isset($appointment->prescription))
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Prescription</h3>

                    <div class="mb-4">
                        <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Diagnosis</p>
                        <p class="text-sm text-slate-800">{{ $appointment->prescription->diagnosis ?? 'N/A' }}</p>
                    </div>

                    @if(isset($appointment->prescription->medicines) && $appointment->prescription->medicines->count())
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-slate-200">
                                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Medicine</th>
                                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Dosage</th>
                                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Duration</th>
                                        <th class="px-4 py-3 text-left font-semibold text-slate-700">Frequency</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($appointment->prescription->medicines as $medicine)
                                        <tr>
                                            <td class="px-4 py-3 text-slate-800 font-medium">{{ $medicine->medicine_name }}</td>
                                            <td class="px-4 py-3 text-slate-600">{{ $medicine->pivot->dosage ?? 'N/A' }}</td>
                                            <td class="px-4 py-3 text-slate-600">{{ $medicine->pivot->duration ?? 'N/A' }}</td>
                                            <td class="px-4 py-3 text-slate-600">{{ $medicine->pivot->frequency ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-slate-500 text-sm">No medicines prescribed</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
