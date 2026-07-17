<x-app-layout>
<div class="max-w-7xl mx-auto" x-data="queueDisplay()" x-init="init()">
    <!-- Header -->
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-slate-800 mb-1">Live Queue Display</h1>
        <p class="text-slate-500">Real-time patient queue tracking</p>
    </div>

    <!-- Selectors -->
    <div class="flex justify-center gap-4 mb-8">
        <select x-model="doctorId" @change="fetchQueue()" class="rounded-xl border-slate-300 focus:border-teal-500 focus:ring-teal-500 text-sm px-4 py-2.5">
            <option value="">All Doctors</option>
            @foreach($doctors as $doc)
                <option value="{{ $doc->id }}">Dr. {{ $doc->user->name }} ({{ $doc->department->name }})</option>
            @endforeach
        </select>
    </div>

    <!-- Loading Skeleton -->
    <div x-show="loading" class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8"><div class="animate-pulse space-y-4"><div class="h-6 bg-slate-200 rounded w-1/2 mx-auto"></div><div class="h-32 bg-slate-200 rounded"></div></div></div>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8"><div class="animate-pulse space-y-4"><div class="h-6 bg-slate-200 rounded w-1/2 mx-auto"></div><div class="h-24 bg-slate-200 rounded"></div></div></div>
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8"><div class="animate-pulse space-y-4"><div class="h-6 bg-slate-200 rounded w-1/2 mx-auto"></div><div class="h-20 bg-slate-200 rounded"></div></div></div>
    </div>

    <!-- Queue Display -->
    <div x-show="!loading" class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Now Serving -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 text-center">
            <div class="w-14 h-14 bg-teal-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </div>
            <h2 class="text-xl font-semibold text-slate-600 mb-4">Now Serving</h2>
            <template x-if="currentServing">
                <div>
                    <div class="text-8xl font-bold text-teal-600 mb-4" x-text="'#' + currentServing.token_no"></div>
                    <div class="text-xl text-slate-800 font-medium" x-text="currentServing.patient_name"></div>
                    <div class="text-sm text-slate-500 mt-2" x-text="currentServing.doctor_name"></div>
                </div>
            </template>
            <template x-if="!currentServing">
                <div class="py-8">
                    <div class="text-5xl text-slate-200 mb-2">--</div>
                    <p class="text-slate-400">No patient being served</p>
                </div>
            </template>
        </div>

        <!-- Waiting -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
            <h2 class="text-xl font-semibold text-slate-600 mb-4">Waiting (<span x-text="waitingList.length"></span>)</h2>
            <div class="space-y-3 max-h-96 overflow-y-auto">
                <template x-for="(appt, index) in waitingList" :key="appt.id">
                    <div class="flex items-center justify-between p-3 bg-amber-50 rounded-xl border border-amber-100">
                        <div class="flex items-center gap-3">
                            <div class="text-xl font-bold text-amber-600" x-text="'#' + appt.token_no"></div>
                            <div>
                                <div class="font-medium text-slate-800 text-sm" x-text="appt.patient_name"></div>
                                <div class="text-xs text-slate-500" x-text="appt.doctor_name"></div>
                            </div>
                        </div>
                        <div class="text-xs text-amber-600 font-medium" x-text="'#' + (index + 1)"></div>
                    </div>
                </template>
                <div x-show="waitingList.length === 0" class="text-center py-8 text-slate-400 text-sm">
                    No patients waiting
                </div>
            </div>
        </div>

        <!-- Completed -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 text-center">
            <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h2 class="text-xl font-semibold text-slate-600 mb-4">Completed</h2>
            <div class="text-6xl font-bold text-emerald-600 mb-2" x-text="completedCount"></div>
            <div class="text-slate-500 text-sm">patients served today</div>
        </div>
    </div>

    <!-- Refresh indicator -->
    <div class="text-center mt-6">
        <span class="text-xs text-slate-400">Auto-refreshing every 5 seconds</span>
        <div class="inline-block w-2 h-2 bg-emerald-400 rounded-full ml-2 animate-pulse"></div>
    </div>

    @push('scripts')
    <script>
        function queueDisplay() {
            return {
                loading: true,
                doctorId: '',
                currentServing: null,
                waitingList: [],
                completedCount: 0,
                interval: null,

                init() {
                    this.fetchQueue();
                    this.interval = setInterval(() => this.fetchQueue(), 5000);
                },

                async fetchQueue() {
                    try {
                        const params = new URLSearchParams();
                        if (this.doctorId) params.append('doctor_id', this.doctorId);
                        params.append('date', new Date().toISOString().split('T')[0]);

                        const response = await fetch(`{{ route('queue.data') }}?${params.toString()}`);
                        const data = await response.json();

                        this.currentServing = data.current;
                        this.waitingList = data.pending;
                        this.completedCount = data.completed_count;
                        this.loading = false;
                    } catch (error) {
                        console.error('Failed to fetch queue:', error);
                        this.loading = false;
                    }
                },

                destroy() {
                    if (this.interval) clearInterval(this.interval);
                }
            }
        }
    </script>
    @endpush
</div>
</x-app-layout>
