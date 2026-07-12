<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Prescription #{{ $prescription->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm mb-6">
                <div class="p-6 border-b border-slate-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Prescription Details</h3>
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('doctor.prescriptions.pdf', $prescription) }}"
                                class="inline-flex items-center px-4 py-2 bg-slate-600 text-white text-sm font-medium rounded-xl hover:bg-slate-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Download PDF
                            </a>
                            <a href="{{ route('doctor.prescriptions.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-slate-200 text-slate-700 text-sm font-medium rounded-xl hover:bg-slate-300 transition-colors">
                                ← Back
                            </a>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Patient</p>
                            <p class="text-sm text-gray-900">{{ $prescription->appointment->patient->user->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Doctor</p>
                            <p class="text-sm text-gray-900">{{ $prescription->doctor->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Diagnosis</p>
                            <p class="text-sm text-gray-900">{{ $prescription->diagnosis }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Date</p>
                            <p class="text-sm text-gray-900">{{ $prescription->created_at->format('M d, Y') }}</p>
                        </div>
                        @if($prescription->notes)
                            <div class="md:col-span-2">
                                <p class="text-sm font-medium text-gray-500">Notes</p>
                                <p class="text-sm text-gray-900">{{ $prescription->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Medicines Table --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-gray-900">Medicines</h3>
                </div>
                <div class="p-6">
                    @if($prescription->medicines->isEmpty())
                        <p class="text-gray-500 text-center py-4">No medicines prescribed.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dosage</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Frequency</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-slate-200">
                                    @foreach($prescription->medicines as $medicine)
                                        <tr>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $medicine->name ?? 'N/A' }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">{{ $medicine->pivot->dosage ?? 'N/A' }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">{{ $medicine->pivot->duration ?? 'N/A' }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">{{ $medicine->pivot->frequency ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
