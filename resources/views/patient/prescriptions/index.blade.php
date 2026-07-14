<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-slate-800 leading-tight">My Prescriptions</h2>
                <p class="text-sm text-slate-500 mt-1">View your prescription history</p>
            </div>
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
                                <th class="px-6 py-4 text-left font-semibold text-slate-700">Date</th>
                                <th class="px-6 py-4 text-left font-semibold text-slate-700">Diagnosis</th>
                                <th class="px-6 py-4 text-left font-semibold text-slate-700">Medicines</th>
                                <th class="px-6 py-4 text-left font-semibold text-slate-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($prescriptions as $prescription)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-slate-800">Dr. {{ $prescription->doctor->name ?? 'N/A' }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600">{{ $prescription->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4">
                                        <p class="text-slate-800 max-w-[200px] truncate">{{ $prescription->diagnosis ?? 'N/A' }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full">{{ $prescription->medicines_count ?? $prescription->medicines->count() ?? 0 }} items</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('patient.prescriptions.show', $prescription) }}" class="text-teal-600 hover:text-teal-700 font-medium text-xs">View</a>
                                            <a href="{{ route('patient.prescriptions.pdf', $prescription) }}" class="text-blue-600 hover:text-blue-700 font-medium text-xs">Download PDF</a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <p class="text-slate-500 text-sm">No prescriptions found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($prescriptions->hasPages())
                    <div class="px-6 py-4 border-t border-slate-200">
                        {{ $prescriptions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
