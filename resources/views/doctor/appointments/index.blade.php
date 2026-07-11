<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Appointments
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Filters --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm mb-6">
                <div class="p-6">
                    <form action="{{ route('doctor.appointments.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                            <input type="date" name="date" id="date" value="{{ request('date') }}"
                                class="rounded-xl border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm">
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" id="status"
                                class="rounded-xl border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-teal-500 text-white text-sm font-medium rounded-xl hover:bg-teal-600 transition-colors">
                            Filter
                        </button>
                        @if(request('date') || request('status'))
                            <a href="{{ route('doctor.appointments.index') }}" class="px-4 py-2 bg-slate-200 text-slate-700 text-sm font-medium rounded-xl hover:bg-slate-300 transition-colors">
                                Clear
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            {{-- Appointments Table --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-gray-900">Appointments List</h3>
                </div>
                <div class="p-6">
                    @if($appointments->isEmpty())
                        <p class="text-gray-500 text-center py-8">No appointments found.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Token#</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient Name</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-slate-200">
                                    @foreach($appointments as $appt)
                                        <tr>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $appt->token_no }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">{{ $appt->patient->user->name ?? 'N/A' }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">{{ \Carbon\Carbon::parse($appt->appointment_date)->format('M d, Y') }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                @if($appt->status === 'pending')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">Pending</span>
                                                @elseif($appt->status === 'in_progress')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">In Progress</span>
                                                @elseif($appt->status === 'completed')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Completed</span>
                                                @elseif($appt->status === 'cancelled')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Cancelled</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm space-x-2">
                                                @if($appt->status === 'pending')
                                                    <form action="{{ route('doctor.appointments.status', $appt) }}" method="POST" class="inline-block">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="in_progress">
                                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-blue-500 text-white text-xs font-medium rounded-lg hover:bg-blue-600 transition-colors">
                                                            Start
                                                        </button>
                                                    </form>
                                                @endif
                                                @if($appt->status === 'in_progress')
                                                    <form action="{{ route('doctor.appointments.status', $appt) }}" method="POST" class="inline-block">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="completed">
                                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-emerald-500 text-white text-xs font-medium rounded-lg hover:bg-emerald-600 transition-colors">
                                                            Complete
                                                        </button>
                                                    </form>
                                                @endif
                                                @if($appt->status === 'completed')
                                                    <a href="{{ route('doctor.prescriptions.create', $appt) }}"
                                                       class="inline-flex items-center px-3 py-1.5 bg-teal-500 text-white text-xs font-medium rounded-lg hover:bg-teal-600 transition-colors">
                                                        Prescribe
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-6">
                            {{ $appointments->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
