<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Prescriptions
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-gray-900">Prescriptions List</h3>
                </div>
                <div class="p-6">
                    @if($prescriptions->isEmpty())
                        <p class="text-gray-500 text-center py-8">No prescriptions found.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Appointment Date</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diagnosis</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Medicines Count</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Created</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-slate-200">
                                    @foreach($prescriptions as $prescription)
                                        <tr>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $prescription->id }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">{{ $prescription->appointment->patient->user->name ?? 'N/A' }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">{{ \Carbon\Carbon::parse($prescription->appointment->appointment_date)->format('M d, Y') }}</td>
                                            <td class="px-4 py-4 text-sm text-gray-700 max-w-xs truncate">{{ $prescription->diagnosis }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">{{ $prescription->medicines->count() }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">{{ $prescription->created_at->format('M d, Y') }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm space-x-2">
                                                <a href="{{ route('doctor.prescriptions.show', $prescription) }}"
                                                   class="inline-flex items-center px-3 py-1.5 bg-teal-500 text-white text-xs font-medium rounded-lg hover:bg-teal-600 transition-colors">
                                                    View
                                                </a>
                                                <a href="{{ route('doctor.prescriptions.pdf', $prescription) }}"
                                                   class="inline-flex items-center px-3 py-1.5 bg-slate-600 text-white text-xs font-medium rounded-lg hover:bg-slate-700 transition-colors">
                                                    Download PDF
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-6">
                            {{ $prescriptions->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
