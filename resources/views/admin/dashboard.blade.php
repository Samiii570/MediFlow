<x-app-layout>
    <div class="space-y-8">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Admin Dashboard</h1>
            <p class="text-slate-500 mt-1">Overview of hospital operations</p>
        </div>

        {{-- KPI Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="kpi-card bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="kpi-icon w-11 h-11 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-extrabold text-slate-800" data-count="{{ $totalPatients }}">0</p>
                        <p class="text-xs text-slate-500 font-medium">Total Patients</p>
                    </div>
                </div>
            </div>
            <div class="kpi-card bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="kpi-icon w-11 h-11 bg-gradient-to-br from-teal-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg shadow-teal-500/20">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-extrabold text-slate-800" data-count="{{ $todayAppointments }}">0</p>
                        <p class="text-xs text-slate-500 font-medium">Today's Appointments</p>
                    </div>
                </div>
            </div>
            <div class="kpi-card bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="kpi-icon w-11 h-11 bg-gradient-to-br from-purple-500 to-violet-600 rounded-xl flex items-center justify-center shadow-lg shadow-purple-500/20">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-extrabold text-slate-800" data-count="{{ $totalDoctors }}">0</p>
                        <p class="text-xs text-slate-500 font-medium">Total Doctors</p>
                    </div>
                </div>
            </div>
            <div class="kpi-card bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="kpi-icon w-11 h-11 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-extrabold text-slate-800" data-count="{{ $totalRevenue }}" data-prefix="$" data-decimals="2">$0</p>
                        <p class="text-xs text-slate-500 font-medium">Today's Revenue</p>
                    </div>
                </div>
            </div>
            <div class="kpi-card bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="kpi-icon w-11 h-11 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg shadow-amber-500/20">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-extrabold text-slate-800" data-count="{{ $lowStockMedicines }}">0</p>
                        <p class="text-xs text-slate-500 font-medium">Low Stock Items</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm">
                <h3 class="text-base font-bold text-slate-800 mb-4">Appointments (Last 7 Days)</h3>
                <canvas id="appointmentsChart" height="200"></canvas>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm">
                <h3 class="text-base font-bold text-slate-800 mb-4">Revenue (Last 7 Days)</h3>
                <canvas id="revenueChart" height="200"></canvas>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm">
                <h3 class="text-base font-bold text-slate-800 mb-4">Medicine Stock Levels</h3>
                <canvas id="stockChart" height="200"></canvas>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm">
                <h3 class="text-base font-bold text-slate-800 mb-4">Department Load</h3>
                <canvas id="deptChart" height="200"></canvas>
            </div>
        </div>

        {{-- Expiring Medicines Alert --}}
        @if($expiringMedicines->count() > 0)
        <div class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200/60 rounded-2xl p-5">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                </div>
                <h3 class="font-bold text-amber-800">Expiry Alert</h3>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                @foreach($expiringMedicines->take(9) as $med)
                <div class="flex items-center justify-between bg-white/80 backdrop-blur-sm rounded-lg px-3 py-2 border border-amber-100/60 hover:border-amber-300 hover:shadow-sm transition-all">
                    <span class="text-sm text-slate-700 font-medium">{{ $med->medicine_name }}</span>
                    <span class="text-xs font-bold {{ $med->isExpired() ? 'text-red-600' : 'text-amber-600' }}">{{ $med->expiry_date->format('M Y') }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Recent Appointments --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h3 class="text-base font-bold text-slate-800">Recent Appointments</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50/80">
                        <tr>
                            <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider">Patient</th>
                            <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider">Doctor</th>
                            <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider">Department</th>
                            <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentAppointments as $appt)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-3 font-semibold text-slate-800">{{ $appt->patient->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-3 text-slate-600">Dr. {{ $appt->doctor->name }}</td>
                            <td class="px-6 py-3 text-slate-600">{{ $appt->doctor->department->name }}</td>
                            <td class="px-6 py-3 text-slate-500 text-xs">{{ $appt->appointment_date->format('M d, Y') }}</td>
                            <td class="px-6 py-3">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-amber-100 text-amber-700 ring-1 ring-amber-200/60',
                                        'in_progress' => 'bg-blue-100 text-blue-700 ring-1 ring-blue-200/60',
                                        'completed' => 'bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200/60',
                                        'cancelled' => 'bg-red-100 text-red-700 ring-1 ring-red-200/60',
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $statusColors[$appt->status] ?? '' }}">
                                    {{ ucfirst(str_replace('_', ' ', $appt->status)) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-6 py-12 text-center text-slate-400">No recent appointments</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[data-count]').forEach(el => {
                const target = parseFloat(el.dataset.count);
                const prefix = el.dataset.prefix || '';
                const decimals = parseInt(el.dataset.decimals) || 0;
                let startTime = null;
                function step(timestamp) {
                    if (!startTime) startTime = timestamp;
                    const progress = Math.min((timestamp - startTime) / 1200, 1);
                    const eased = 1 - Math.pow(1 - progress, 4);
                    const current = target * eased;
                    el.textContent = prefix + current.toFixed(decimals).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                    if (progress < 1) requestAnimationFrame(step);
                    else el.textContent = prefix + target.toFixed(decimals).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                }
                const obs = new IntersectionObserver(entries => {
                    if (entries[0].isIntersecting) { requestAnimationFrame(step); obs.disconnect(); }
                }, { threshold: 0.5 });
                obs.observe(el);
            });
        });

        const appointmentsData = @json($appointmentsPerDay);
        const revenueData = @json($revenuePerDay);
        const stockData = @json($medicineStock);
        const deptData = @json($departmentLoad);

        const teal = '#0d9488';
        const tealLight = 'rgba(13, 148, 136, 0.1)';
        const blue = '#2563eb';

        new Chart(document.getElementById('appointmentsChart'), {
            type: 'line',
            data: {
                labels: appointmentsData.map(d => new Date(d.appointment_date).toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric' })),
                datasets: [{
                    label: 'Appointments',
                    data: appointmentsData.map(d => d.count),
                    borderColor: teal,
                    backgroundColor: tealLight,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: teal,
                    pointBorderWidth: 2,
                    pointHoverRadius: 7,
                    borderWidth: 2.5,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false }, tooltip: { backgroundColor: '#1e293b', titleFont: { weight: '600' }, bodyFont: { weight: '500' }, padding: 12, cornerRadius: 10, displayColors: false } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 11 } }, grid: { color: 'rgba(0,0,0,0.04)' } }, x: { grid: { display: false }, ticks: { font: { size: 11 } } } }
            }
        });

        new Chart(document.getElementById('revenueChart'), {
            type: 'bar',
            data: {
                labels: revenueData.map(d => new Date(d.sale_date).toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric' })),
                datasets: [{
                    label: 'Revenue ($)',
                    data: revenueData.map(d => parseFloat(d.total)),
                    backgroundColor: 'rgba(16, 185, 129, 0.8)',
                    borderColor: '#10b981',
                    borderWidth: 1,
                    borderRadius: 8,
                    hoverBackgroundColor: 'rgba(16, 185, 129, 1)',
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false }, tooltip: { backgroundColor: '#1e293b', titleFont: { weight: '600' }, bodyFont: { weight: '500' }, padding: 12, cornerRadius: 10, displayColors: false, callbacks: { label: ctx => '$' + ctx.parsed.y.toFixed(2) } } },
                scales: { y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { font: { size: 11 } } }, x: { grid: { display: false }, ticks: { font: { size: 11 } } } }
            }
        });

        new Chart(document.getElementById('stockChart'), {
            type: 'bar',
            data: {
                labels: stockData.map(d => d.medicine_name.length > 15 ? d.medicine_name.substring(0, 15) + '...' : d.medicine_name),
                datasets: [{
                    label: 'Stock',
                    data: stockData.map(d => d.stock),
                    backgroundColor: stockData.map(d => d.stock <= 10 ? 'rgba(239, 68, 68, 0.8)' : 'rgba(59, 130, 246, 0.8)'),
                    borderRadius: 6,
                    hoverBackgroundColor: stockData.map(d => d.stock <= 10 ? 'rgba(239, 68, 68, 1)' : 'rgba(59, 130, 246, 1)'),
                }]
            },
            options: {
                responsive: true,
                indexAxis: 'y',
                plugins: { legend: { display: false }, tooltip: { backgroundColor: '#1e293b', padding: 12, cornerRadius: 10 } },
                scales: { x: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { font: { size: 11 } } }, y: { grid: { display: false }, ticks: { font: { size: 11 } } } }
            }
        });

        new Chart(document.getElementById('deptChart'), {
            type: 'doughnut',
            data: {
                labels: deptData.map(d => d.name),
                datasets: [{
                    data: deptData.map(d => d.doctors_count || 0),
                    backgroundColor: ['#0d9488', '#2563eb', '#7c3aed', '#db2777', '#ea580c', '#16a34a', '#ca8a04', '#dc2626', '#6366f1', '#0891b2'],
                    borderWidth: 0,
                    hoverOffset: 8,
                }]
            },
            options: {
                responsive: true,
                cutout: '65%',
                plugins: {
                    legend: { position: 'bottom', labels: { padding: 12, usePointStyle: true, pointStyle: 'circle', font: { size: 11, weight: '500' } } },
                    tooltip: { backgroundColor: '#1e293b', padding: 12, cornerRadius: 10 }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>
