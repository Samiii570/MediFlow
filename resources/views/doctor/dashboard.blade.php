<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Doctor Dashboard - {{ Auth::user()->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- KPI Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-teal-100 text-teal-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Today's Appointments</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $totalToday }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-amber-100 text-amber-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Pending</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $pendingCount }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-emerald-100 text-emerald-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Completed</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $completedCount }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Follow-ups</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $upcomingFollowUps->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Today's Appointments Table --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
                        <div class="p-6 border-b border-slate-200">
                            <h3 class="text-lg font-semibold text-gray-900">Today's Appointments</h3>
                        </div>
                        <div class="p-6">
                            @if($todayAppointments->isEmpty())
                                <p class="text-gray-500 text-center py-4">No appointments scheduled for today.</p>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-slate-200">
                                        <thead class="bg-slate-50">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Token#</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-slate-200">
                                            @foreach($todayAppointments as $appt)
                                                <tr>
                                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $appt->token_no }}</td>
                                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">{{ $appt->patient->user->name ?? 'N/A' }}</td>
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
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('doctor.appointments.index') }}" class="text-teal-600 hover:text-teal-700 text-sm font-medium">View All Appointments →</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Right Sidebar --}}
                <div class="space-y-6">
                    {{-- Upcoming Follow-ups --}}
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
                        <div class="p-6 border-b border-slate-200">
                            <h3 class="text-lg font-semibold text-gray-900">Upcoming Follow-ups</h3>
                        </div>
                        <div class="p-6">
                            @if($upcomingFollowUps->isEmpty())
                                <p class="text-gray-500 text-center py-4">No upcoming follow-ups.</p>
                            @else
                                <ul class="space-y-3">
                                    @foreach($upcomingFollowUps as $followUp)
                                        <li class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $followUp->patient->user->name ?? 'N/A' }}</p>
                                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($followUp->follow_up_date)->format('M d, Y') }}</p>
                                            </div>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Follow-up</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                    {{-- Pending Lab Tests --}}
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
                        <div class="p-6 border-b border-slate-200">
                            <h3 class="text-lg font-semibold text-gray-900">Pending Lab Tests</h3>
                        </div>
                        <div class="p-6">
                            @if($pendingLabTests->isEmpty())
                                <p class="text-gray-500 text-center py-4">No pending lab tests.</p>
                            @else
                                <ul class="space-y-3">
                                    @foreach($pendingLabTests as $test)
                                        <li class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $test->test_name }}</p>
                                                <p class="text-xs text-gray-500">{{ $test->patient->user->name ?? 'N/A' }}</p>
                                            </div>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800">Pending</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
