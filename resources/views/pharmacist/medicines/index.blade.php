<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-800 leading-tight">Medicine Inventory</h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search and Filters -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6">
                <form method="GET" action="{{ route('pharmacist.medicines.index') }}" class="flex flex-wrap gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search medicines..."
                            class="w-full rounded-xl border-slate-200 focus:border-teal-500 focus:ring-teal-500">
                    </div>
                    <div>
                        <select name="status" class="rounded-xl border-slate-200 focus:border-teal-500 focus:ring-teal-500">
                            <option value="">All Status</option>
                            <option value="low_stock" {{ request('status') === 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                            <option value="expiring" {{ request('status') === 'expiring' ? 'selected' : '' }}>Expiring Soon</option>
                            <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-teal-600 text-white px-6 py-2 rounded-xl hover:bg-teal-700 transition">Filter</button>
                </form>
            </div>

            <!-- Medicines Table -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-slate-500 bg-slate-50">
                                <th class="px-6 py-4 font-medium">Name</th>
                                <th class="px-6 py-4 font-medium">Stock</th>
                                <th class="px-6 py-4 font-medium">Price</th>
                                <th class="px-6 py-4 font-medium">Expiry</th>
                                <th class="px-6 py-4 font-medium">Status</th>
                                <th class="px-6 py-4 font-medium">Quick Stock Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($medicines as $medicine)
                            <tr class="border-t border-slate-100 hover:bg-slate-50">
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $medicine->name }}</td>
                                <td class="px-6 py-4">
                                    <span class="{{ $medicine->stock <= 10 ? 'text-rose-600 font-semibold' : ($medicine->stock <= 20 ? 'text-amber-600 font-medium' : 'text-slate-700') }}">
                                        {{ $medicine->stock }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">${{ number_format($medicine->price, 2) }}</td>
                                <td class="px-6 py-4">{{ $medicine->expiry_date->format('M d, Y') }}</td>
                                <td class="px-6 py-4">
                                    @if($medicine->expiry_date->isPast())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">Expired</span>
                                    @elseif($medicine->stock <= 10)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-700">Low Stock</span>
                                    @elseif($medicine->expiry_date->diffInDays(now()) <= 30)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">Expiring Soon</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">In Stock</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('pharmacist.medicines.stock', $medicine) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="stock" value="{{ $medicine->stock }}" min="0" class="w-20 rounded-lg border-slate-200 text-sm focus:border-teal-500 focus:ring-teal-500">
                                        <button type="submit" class="bg-teal-600 text-white px-3 py-1.5 rounded-lg text-xs hover:bg-teal-700 transition">Update</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-400">No medicines found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $medicines->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
