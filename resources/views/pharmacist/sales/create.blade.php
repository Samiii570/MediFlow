<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">New Sale</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('pharmacist.sales.store') }}" method="POST" id="saleForm">
                @csrf
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Patient Information</h3>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Select Patient</label>
                        <select name="patient_id" required class="w-full rounded-xl border-slate-200 focus:border-teal-500 focus:ring-teal-500">
                            <option value="">Choose a patient...</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->name }} - {{ $patient->phone ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-slate-800">Medicines</h3>
                        <button type="button" onclick="addItem()" class="bg-teal-600 text-white px-4 py-2 rounded-xl hover:bg-teal-700 transition text-sm font-medium">
                            + Add Item
                        </button>
                    </div>

                    <div id="itemsContainer" class="space-y-4">
                        <div class="item-row grid grid-cols-12 gap-4 items-end" data-index="0">
                            <div class="col-span-5">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Medicine</label>
                                <select name="items[0][medicine_id]" required onchange="updatePrice(this)" class="w-full rounded-xl border-slate-200 focus:border-teal-500 focus:ring-teal-500 medicine-select">
                                    <option value="">Select medicine...</option>
                                    @foreach($medicines as $medicine)
                                        <option value="{{ $medicine->id }}" data-price="{{ $medicine->price }}">{{ $medicine->medicine_name }} - ${{ number_format($medicine->price, 2) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Qty</label>
                                <input type="number" name="items[0][quantity]" min="1" value="1" required onchange="calculateRow(this)" class="w-full rounded-xl border-slate-200 focus:border-teal-500 focus:ring-teal-500 quantity-input">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Unit Price</label>
                                <input type="text" readonly class="w-full rounded-xl border-slate-200 bg-slate-50 unit-price">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Subtotal</label>
                                <input type="text" readonly class="w-full rounded-xl border-slate-200 bg-slate-50 subtotal">
                            </div>
                            <div class="col-span-1">
                                <button type="button" onclick="removeItem(this)" class="w-full bg-rose-100 text-rose-600 px-3 py-2 rounded-xl hover:bg-rose-200 transition">
                                    ✕
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <div class="flex justify-end">
                        <div class="text-right">
                            <div class="text-sm text-slate-500 mb-1">Total Amount</div>
                            <div class="text-3xl font-bold text-teal-600" id="totalDisplay">$0.00</div>
                        </div>
                    </div>
                    <div class="flex justify-end mt-6">
                        <button type="submit" class="bg-teal-600 text-white px-8 py-3 rounded-xl hover:bg-teal-700 transition font-medium">
                            Complete Sale
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        let itemIndex = 1;

        function addItem() {
            const container = document.getElementById('itemsContainer');
            const firstRow = container.querySelector('.item-row');
            const newRow = firstRow.cloneNode(true);
            
            newRow.dataset.index = itemIndex;
            newRow.querySelectorAll('select, input').forEach(el => {
                if (el.name) el.name = el.name.replace('[0]', `[${itemIndex}]`);
                if (el.classList.contains('medicine-select') || el.classList.contains('quantity-input')) {
                    el.value = '';
                }
            });
            newRow.querySelector('.unit-price').value = '';
            newRow.querySelector('.subtotal').value = '';
            
            container.appendChild(newRow);
            itemIndex++;
        }

        function removeItem(btn) {
            const rows = document.querySelectorAll('.item-row');
            if (rows.length > 1) {
                btn.closest('.item-row').remove();
                calculateTotal();
            }
        }

        function updatePrice(select) {
            const row = select.closest('.item-row');
            const option = select.options[select.selectedIndex];
            const price = option.dataset.price || 0;
            row.querySelector('.unit-price').value = '$' + parseFloat(price).toFixed(2);
            calculateRow(row.querySelector('.quantity-input'));
        }

        function calculateRow(input) {
            const row = input.closest('.item-row');
            const select = row.querySelector('.medicine-select');
            const option = select.options[select.selectedIndex];
            const price = parseFloat(option.dataset.price) || 0;
            const qty = parseInt(input.value) || 0;
            const subtotal = price * qty;
            
            row.querySelector('.subtotal').value = '$' + subtotal.toFixed(2);
            calculateTotal();
        }

        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.subtotal').forEach(el => {
                const val = parseFloat(el.value.replace('$', '')) || 0;
                total += val;
            });
            document.getElementById('totalDisplay').textContent = '$' + total.toFixed(2);
        }
    </script>
    @endpush
</x-app-layout>
