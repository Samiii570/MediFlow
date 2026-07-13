<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lab Tests Management
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-gray-900">All Lab Tests</h3>
                </div>
                <div class="p-6">
                    @if($labTests->isEmpty())
                        <p class="text-gray-500 text-center py-8">No lab tests found.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doctor</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Test Name</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-slate-200">
                                    @foreach($labTests as $test)
                                        <tr>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">#{{ $test->id }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">{{ $test->patient->user->name ?? 'N/A' }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">{{ $test->doctor->user->name ?? 'N/A' }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $test->test_name }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                @if($test->status === 'pending')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">Pending</span>
                                                @elseif($test->status === 'in_progress')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">In Progress</span>
                                                @elseif($test->status === 'completed')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Completed</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">{{ $test->created_at->format('M d, Y') }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm space-x-2">
                                                <form action="{{ route('admin.lab-tests.status', $test) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="status" onchange="this.form.submit()"
                                                        class="text-xs rounded-lg border-slate-300 focus:border-teal-500 focus:ring-teal-500">
                                                        <option value="pending" {{ $test->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="in_progress" {{ $test->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                        <option value="completed" {{ $test->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                                    </select>
                                                </form>
                                                @if($test->status !== 'completed')
                                                    <button onclick="document.getElementById('upload-modal-{{ $test->id }}').classList.remove('hidden')"
                                                        class="inline-flex items-center px-3 py-1 bg-teal-500 text-white text-xs font-medium rounded-lg hover:bg-teal-600 transition-colors">
                                                        Upload Report
                                                    </button>
                                                @endif
                                                @if($test->labReport)
                                                    <a href="{{ asset('storage/lab-reports/' . $test->labReport->report_file) }}" target="_blank"
                                                        class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-xs font-medium rounded-lg hover:bg-blue-600 transition-colors">
                                                        View Report
                                                    </a>
                                                @endif
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

    @foreach($labTests as $test)
        <div id="upload-modal-{{ $test->id }}" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl shadow-xl max-w-md w-full mx-4 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Upload Lab Report for #{{ $test->id }}</h3>
                <form action="{{ route('admin.lab-tests.report', $test) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Report File</label>
                        <input type="file" name="report_file" required
                            class="w-full rounded-xl border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Remarks</label>
                        <textarea name="remarks" rows="3"
                            class="w-full rounded-xl border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm"
                            placeholder="Optional remarks..."></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="document.getElementById('upload-modal-{{ $test->id }}').classList.add('hidden')"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-teal-500 rounded-xl hover:bg-teal-600 transition-colors">
                            Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
</x-app-layout>
