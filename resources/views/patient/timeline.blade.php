<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-slate-800 leading-tight">My Patient Journey</h2>
                <p class="text-sm text-slate-500 mt-1">A timeline of your healthcare events</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                @if(isset($timeline) && $timeline->count())
                    <div class="relative">
                        <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-slate-200"></div>

                        <div class="space-y-8">
                            @foreach($timeline as $event)
                                @php
                                    $config = match($event['type'] ?? $event->type ?? '') {
                                        'registration' => [
                                            'color' => 'bg-teal-100 text-teal-600',
                                            'dot' => 'bg-teal-500',
                                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>',
                                            'label' => 'Registration',
                                        ],
                                        'appointment' => [
                                            'color' => 'bg-blue-100 text-blue-600',
                                            'dot' => 'bg-blue-500',
                                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
                                            'label' => 'Appointment',
                                        ],
                                        'prescription' => [
                                            'color' => 'bg-purple-100 text-purple-600',
                                            'dot' => 'bg-purple-500',
                                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
                                            'label' => 'Prescription',
                                        ],
                                        'lab_test' => [
                                            'color' => 'bg-amber-100 text-amber-600',
                                            'dot' => 'bg-amber-500',
                                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>',
                                            'label' => 'Lab Test',
                                        ],
                                        'pharmacy_sale' => [
                                            'color' => 'bg-green-100 text-green-600',
                                            'dot' => 'bg-green-500',
                                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>',
                                            'label' => 'Pharmacy',
                                        ],
                                        default => [
                                            'color' => 'bg-slate-100 text-slate-600',
                                            'dot' => 'bg-slate-500',
                                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                                            'label' => 'Event',
                                        ],
                                    };
                                    $eventDate = \Carbon\Carbon::parse($event['date'] ?? $event->date ?? $event['created_at'] ?? now());
                                @endphp

                                <div class="relative flex items-start gap-4 pl-4">
                                    <div class="absolute left-0 w-12 h-12 {{ $config['color'] }} rounded-full flex items-center justify-center z-10 shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            {!! $config['icon'] !!}
                                        </svg>
                                    </div>

                                    <div class="flex-1 ml-8">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-xs font-semibold uppercase tracking-wider {{ $config['color'] }}">{{ $config['label'] }}</span>
                                            <span class="text-xs text-slate-400">{{ $eventDate->format('M d, Y') }}</span>
                                        </div>
                                        <h4 class="text-sm font-semibold text-slate-800">{{ $event['title'] ?? $event->title ?? 'Event' }}</h4>
                                        <p class="text-sm text-slate-600 mt-1">{{ $event['description'] ?? $event->description ?? '' }}</p>
                                        @if(isset($event['time']) || isset($event->time))
                                            <p class="text-xs text-slate-400 mt-1">{{ $event['time'] ?? $event->time ?? '' }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-slate-500 text-sm">No events in your timeline yet</p>
                        <p class="text-slate-400 text-xs mt-1">Your healthcare journey will appear here</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
