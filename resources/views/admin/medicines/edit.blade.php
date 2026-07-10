<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Medicine</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                @if($errors->any())
                    <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4">
                        <div class="flex">
                            <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">There were some errors with your submission:</h3>
                                <ul class="mt-2 list-disc list-inside text-sm text-red-700">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.medicines.update', $medicine) }}">
                    @csrf
                    @method('PUT')

                    <div class="space-y-5">
                        <div>
                            <label for="medicine_name" class="block text-sm font-medium text-slate-700 mb-1">Medicine Name</label>
                            <input
                                type="text"
                                name="medicine_name"
                                id="medicine_name"
                                value="{{ old('medicine_name', $medicine->medicine_name) }}"
                                required
                                class="w-full rounded-lg border-slate-300 focus:border-teal-500 focus:ring-teal-500 text-sm"
                                placeholder="e.g. Amoxicillin 500mg"
                            >
                        </div>

                        <div>
                            <label for="stock" class="block text-sm font-medium text-slate-700 mb-1">Stock Quantity</label>
                            <input
                                type="number"
                                name="stock"
                                id="stock"
                                value="{{ old('stock', $medicine->stock) }}"
                                required
                                min="0"
                                class="w-full rounded-lg border-slate-300 focus:border-teal-500 focus:ring-teal-500 text-sm"
                                placeholder="0"
                            >
                        </div>

                        <div>
                            <label for="price" class="block text-sm font-medium text-slate-700 mb-1">Price</label>
                            <input
                                type="number"
                                name="price"
                                id="price"
                                value="{{ old('price', $medicine->price) }}"
                                required
                                step="0.01"
                                min="0"
                                class="w-full rounded-lg border-slate-300 focus:border-teal-500 focus:ring-teal-500 text-sm"
                                placeholder="0.00"
                            >
                        </div>

                        <div>
                            <label for="expiry_date" class="block text-sm font-medium text-slate-700 mb-1">Expiry Date</label>
                            <input
                                type="date"
                                name="expiry_date"
                                id="expiry_date"
                                value="{{ old('expiry_date', $medicine->expiry_date ? \Carbon\Carbon::parse($medicine->expiry_date)->format('Y-m-d') : '') }}"
                                class="w-full rounded-lg border-slate-300 focus:border-teal-500 focus:ring-teal-500 text-sm"
                            >
                            <p class="mt-1 text-xs text-slate-500">Leave blank if not applicable.</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 mt-8">
                        <a
                            href="{{ route('admin.medicines.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-slate-300 rounded-lg font-semibold text-xs text-slate-700 tracking-widest hover:bg-slate-50 focus:bg-slate-50 active:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            Cancel
                        </a>
                        <button
                            type="submit"
                            class="inline-flex items-center px-4 py-2 bg-teal-500 border border-transparent rounded-lg font-semibold text-xs text-white tracking-widest hover:bg-teal-600 focus:bg-teal-600 active:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        >
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Update Medicine
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
