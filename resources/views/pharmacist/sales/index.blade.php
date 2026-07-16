<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">Sales History</h2>
            <a href="{{ route('pharmacist.sales.create') }}" class="bg-teal-600 text-white px-4 py-2 rounded-xl hover:bg-teal-700 transition text-sm font-medium">
                + New Sale
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-slate-500 bg-slate-50">
                                <th class="px-6 py-4 font-medium">Sale ID</th>
                                <th class="px-6 py-4 font-medium">Patient</th>
                                <th class="px-6 py-4 font-medium">Items</th>
                                <th class="px-6 py-4 font-medium">Total</th>
                                <th class="px-6 py-4 font-medium">Date</th>
                                <th class="px-6 py-4 font-medium text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sales as $sale)
                            <tr class="border-t border-slate-100 hover:bg-slate-50">
                                <td class="px-6 py-4 font-medium text-slate-800">#{{ $sale->id }}</td>
                                <td class="px-6 py-4">{{ $sale->patient->user->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $sale->saleItems->count() }}</td>
                                <td class="px-6 py-4 font-semibold text-slate-800">${{ number_format($sale->total_amount, 2) }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ $sale->created_at->format('M d, Y h:i A') }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('pharmacist.sales.show', $sale) }}" class="text-teal-600 hover:text-teal-800 transition px-3 py-1.5 rounded-lg hover:bg-teal-50">
                                            View
                                        </a>
                                        <a href="{{ route('pharmacist.sales.invoice', $sale) }}" class="text-slate-600 hover:text-slate-800 transition px-3 py-1.5 rounded-lg hover:bg-slate-100">
                                            Invoice PDF
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-400">No sales found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $sales->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
