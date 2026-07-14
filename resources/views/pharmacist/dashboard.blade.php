<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">Pharmacy Dashboard</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- KPI Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <div class="text-sm font-medium text-slate-500">Today's Sales ($)</div>
                    <div class="mt-2 text-3xl font-bold text-slate-800">${{ number_format($todaySales, 2) }}</div>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <div class="text-sm font-medium text-slate-500">Today's Transactions</div>
                    <div class="mt-2 text-3xl font-bold text-slate-800">{{ $todaySalesCount }}</div>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <div class="text-sm font-medium text-slate-500">Total Medicines</div>
                    <div class="mt-2 text-3xl font-bold text-slate-800">{{ $totalMedicines }}</div>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <div class="text-sm font-medium text-slate-500">Low Stock</div>
                    <div class="mt-2 text-3xl font-bold text-amber-600">{{ $lowStockMedicines }}</div>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <div class="text-sm font-medium text-slate-500">Expiring Soon</div>
                    <div class="mt-2 text-3xl font-bold text-rose-600">{{ $expiringMedicines }}</div>
                </div>
            </div>

            <!-- Weekly Sales Chart -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-8">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Weekly Sales</h3>
                <canvas id="weeklySalesChart" height="100"></canvas>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Sales -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Recent Sales</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-slate-500 border-b border-slate-100">
                                    <th class="pb-3 font-medium">ID</th>
                                    <th class="pb-3 font-medium">Patient</th>
                                    <th class="pb-3 font-medium">Items</th>
                                    <th class="pb-3 font-medium">Total</th>
                                    <th class="pb-3 font-medium">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentSales as $sale)
                                <tr class="border-b border-slate-50">
                                    <td class="py-3">#{{ $sale->id }}</td>
                                    <td class="py-3">{{ $sale->patient->user->name ?? 'N/A' }}</td>
                                    <td class="py-3">{{ $sale->saleItems->count() }}</td>
                                    <td class="py-3 font-medium">${{ number_format($sale->total_amount, 2) }}</td>
                                    <td class="py-3 text-slate-500">{{ $sale->created_at->format('M d, Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-slate-400">No recent sales</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Expiring Medicines -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Expiring Medicines Alert</h3>
                    <div class="space-y-3">
                        @forelse($expiringMedicinesList as $medicine)
                        <div class="flex items-center justify-between p-3 bg-rose-50 rounded-xl border border-rose-100">
                            <div>
                                <div class="font-medium text-slate-800">{{ $medicine->name }}</div>
                                <div class="text-sm text-slate-500">Stock: {{ $medicine->stock }}</div>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-700">
                                    Expires {{ $medicine->expiry_date->format('M d, Y') }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 text-slate-400">No medicines expiring soon</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('weeklySalesChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($weeklySales->pluck('day')),
                datasets: [{
                    label: 'Sales ($)',
                    data: @json($weeklySales->pluck('total')),
                    backgroundColor: 'rgba(20, 184, 166, 0.8)',
                    borderColor: 'rgb(20, 184, 166)',
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { callback: val => '$' + val }
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>
