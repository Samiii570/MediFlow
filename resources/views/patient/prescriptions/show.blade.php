<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-slate-800 leading-tight">Prescription Details</h2>
                <p class="text-sm text-slate-500 mt-1">Prescription from {{ $prescription->created_at->format('M d, Y') }}</p>
            </div>
            <a href="{{ route('patient.prescriptions.index') }}" class="text-sm text-slate-600 hover:text-slate-800 font-medium">
                &larr; Back to Prescriptions
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-slate-800">Prescription Information</h3>
                    <a href="{{ route('patient.prescriptions.pdf', $prescription) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Download PDF
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Doctor</p>
                            <p class="text-sm font-medium text-slate-800">Dr. {{ $prescription->doctor->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Department</p>
                            <p class="text-sm font-medium text-slate-800">{{ $prescription->doctor->department->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Date Issued</p>
                            <p class="text-sm font-medium text-slate-800">{{ $prescription->created_at->format('F d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Appointment</p>
                            <p class="text-sm font-medium text-slate-800">Token #{{ $prescription->appointment->token_no ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <p class="text-xs text-slate-500 uppercase tracking-wider mb-2">Diagnosis</p>
                    <div class="p-4 bg-slate-50 rounded-xl">
                        <p class="text-sm text-slate-800">{{ $prescription->diagnosis ?? 'No diagnosis provided' }}</p>
                    </div>
                </div>

                @if($prescription->notes)
                    <div class="mb-6">
                        <p class="text-xs text-slate-500 uppercase tracking-wider mb-2">Doctor's Notes</p>
                        <div class="p-4 bg-slate-50 rounded-xl">
                            <p class="text-sm text-slate-800">{{ $prescription->notes }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Medicines</h3>
                @if(isset($prescription->medicines) && $prescription->medicines->count())
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-slate-200">
                                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Name</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Dosage</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Duration</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Frequency</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($prescription->medicines as $medicine)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-4 py-3">
                                            <p class="font-medium text-slate-800">{{ $medicine->medicine_name }}</p>
                                        </td>
                                        <td class="px-4 py-3 text-slate-600">{{ $medicine->pivot->dosage ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-slate-600">{{ $medicine->pivot->duration ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-slate-600">{{ $medicine->pivot->frequency ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-slate-500 text-sm">No medicines prescribed</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
