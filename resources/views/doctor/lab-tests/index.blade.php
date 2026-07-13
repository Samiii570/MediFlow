<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lab Tests
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Order Lab Test Form --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm mb-6">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-gray-900">Order Lab Test</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('doctor.lab-tests.order') }}" method="POST">
                        @csrf
                        <div class="flex flex-wrap items-end gap-4">
                            <div>
                                <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-1">Patient (Optional)</label>
                                <select name="patient_id" id="patient_id"
                                    class="rounded-xl border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm">
                                    <option value="">Select Patient</option>
                                    @isset($patients)
                                        @foreach($patients as $patient)
                                            <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                            <div>
                                <label for="test_name" class="block text-sm font-medium text-gray-700 mb-1">Test Name <span class="text-red-500">*</span></label>
                                <input type="text" name="test_name" id="test_name" required
                                    class="rounded-xl border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm"
                                    placeholder="Enter test name...">
                            </div>
                            <button type="submit"
                                class="px-4 py-2 bg-teal-500 text-white text-sm font-medium rounded-xl hover:bg-teal-600 transition-colors">
                                Order Test
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Lab Tests Table --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-gray-900">Lab Tests List</h3>
                </div>
                <div class="p-6">
                    @if($labTests->isEmpty())
                        <p class="text-gray-500 text-center py-8">No lab tests found.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient Name</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Test Name</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ordered Date</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-slate-200">
                                    @foreach($labTests as $test)
                                        <tr>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">{{ $test->patient->user->name ?? 'N/A' }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $test->test_name }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                @if($test->status === 'pending')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">Pending</span>
                                                @elseif($test->status === 'in_progress')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">In Progress</span>
                                                @elseif($test->status === 'completed')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Completed</span>
                                                @elseif($test->status === 'cancelled')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Cancelled</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">{{ $test->created_at->format('M d, Y') }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm">
                                                <span class="text-gray-400">-</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-6">
                            {{ $labTests->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
