<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-slate-800 leading-tight">My Lab Reports</h2>
                <p class="text-sm text-slate-500 mt-1">View your lab test results</p>
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
                                <th class="px-6 py-4 text-left font-semibold text-slate-700">Test Name</th>
                                <th class="px-6 py-4 text-left font-semibold text-slate-700">Doctor</th>
                                <th class="px-6 py-4 text-left font-semibold text-slate-700">Status</th>
                                <th class="px-6 py-4 text-left font-semibold text-slate-700">Date</th>
                                <th class="px-6 py-4 text-left font-semibold text-slate-700">Report</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($labReports as $labReport)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-slate-800">{{ $labReport->test_name ?? $labReport->name ?? 'N/A' }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-slate-800">Dr. {{ $labReport->doctor->name ?? 'N/A' }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusClasses = match($labReport->status ?? '') {
                                                'pending' => 'bg-amber-100 text-amber-700',
                                                'in_progress' => 'bg-blue-100 text-blue-700',
                                                'completed' => 'bg-emerald-100 text-emerald-700',
                                                default => 'bg-slate-100 text-slate-700',
                                            };
                                        @endphp
                                        <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $statusClasses }}">
                                            {{ ucfirst(str_replace('_', ' ', $labReport->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600">{{ $labReport->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4">
                                        @if($labReport->report_file || $labReport->report_path)
                                            <span class="text-xs bg-emerald-100 text-emerald-700 px-2 py-1 rounded-full font-medium">Uploaded</span>
                                        @else
                                            <span class="text-xs bg-slate-100 text-slate-600 px-2 py-1 rounded-full font-medium">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                        </svg>
                                        <p class="text-slate-500 text-sm">No lab reports found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($labReports->hasPages())
                    <div class="px-6 py-4 border-t border-slate-200">
                        {{ $labReports->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
