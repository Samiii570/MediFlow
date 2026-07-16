<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">Sale #{{ $sale->id }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <div class="text-sm text-slate-500 mb-1">Patient</div>
                        <div class="font-medium text-slate-800">{{ $sale->patient->user->name ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-slate-500 mb-1">Pharmacist</div>
                        <div class="font-medium text-slate-800">{{ $sale->pharmacist->name ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-slate-500 mb-1">Date</div>
                        <div class="font-medium text-slate-800">{{ $sale->created_at->format('M d, Y h:i A') }}</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-slate-500 bg-slate-50">
                                <th class="px-6 py-4 font-medium">Medicine</th>
                                <th class="px-6 py-4 font-medium text-center">Qty</th>
                                <th class="px-6 py-4 font-medium text-right">Unit Price</th>
                                <th class="px-6 py-4 font-medium text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sale->saleItems as $item)
                            <tr class="border-t border-slate-100">
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $item->medicine->medicine_name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-center">{{ $item->quantity }}</td>
                                <td class="px-6 py-4 text-right">${{ number_format($item->unit_price, 2) }}</td>
                                <td class="px-6 py-4 text-right font-medium">${{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6">
                <div class="flex justify-between items-center">
                    <div class="text-lg font-semibold text-slate-800">Total Amount</div>
                    <div class="text-3xl font-bold text-teal-600">${{ number_format($sale->total_amount, 2) }}</div>
                </div>
            </div>

            <div class="flex gap-4">
                <a href="{{ route('pharmacist.sales.invoice', $sale) }}" class="bg-slate-100 text-slate-700 px-6 py-3 rounded-xl hover:bg-slate-200 transition font-medium">
                    Download Invoice PDF
                </a>
                <a href="{{ route('pharmacist.sales.index') }}" class="bg-white border border-slate-200 text-slate-700 px-6 py-3 rounded-xl hover:bg-slate-50 transition font-medium">
                    ← Back to Sales
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
