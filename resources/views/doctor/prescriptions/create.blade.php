<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Prescription
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            {{-- Appointment Info --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm mb-6">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-gray-900">Appointment Details</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Patient</p>
                            <p class="text-sm text-gray-900">{{ $appointment->patient->user->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Date</p>
                            <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Department</p>
                            <p class="text-sm text-gray-900">{{ $appointment->doctor->department->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Prescription Form --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-gray-900">Prescription Information</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('doctor.prescriptions.store', $appointment) }}" method="POST">
                        @csrf

                        {{-- Diagnosis --}}
                        <div class="mb-6">
                            <label for="diagnosis" class="block text-sm font-medium text-gray-700 mb-1">Diagnosis <span class="text-red-500">*</span></label>
                            <textarea name="diagnosis" id="diagnosis" rows="3" required
                                class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm"
                                placeholder="Enter diagnosis...">{{ old('diagnosis') }}</textarea>
                            @error('diagnosis')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Notes --}}
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                            <textarea name="notes" id="notes" rows="2"
                                class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm"
                                placeholder="Additional notes...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Medicines --}}
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-3">
                                <label class="block text-sm font-medium text-gray-700">Medicines</label>
                                <button type="button" id="add-medicine"
                                    class="inline-flex items-center px-3 py-1.5 bg-teal-500 text-white text-xs font-medium rounded-lg hover:bg-teal-600 transition-colors">
                                    + Add Medicine
                                </button>
                            </div>

                            <div id="medicines-container" class="space-y-4">
                                <div class="medicine-row bg-slate-50 rounded-xl p-4 border border-slate-200">
                                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                        <div class="md:col-span-1">
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Medicine</label>
                                            <select name="medicines[0][medicine_id]" required
                                                class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm">
                                                <option value="">Select Medicine</option>
                                                @foreach($medicines as $medicine)
                                                    <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Dosage</label>
                                            <input type="text" name="medicines[0][dosage]" required
                                                class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm"
                                                placeholder="e.g., 500mg">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Duration</label>
                                            <input type="text" name="medicines[0][duration]" required
                                                class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm"
                                                placeholder="e.g., 7 days">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 mb-1">Frequency</label>
                                            <select name="medicines[0][frequency]" required
                                                class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm">
                                                <option value="">Select Frequency</option>
                                                <option value="Once daily">Once daily</option>
                                                <option value="Twice daily">Twice daily</option>
                                                <option value="Three times daily">Three times daily</option>
                                                <option value="Four times daily">Four times daily</option>
                                                <option value="Every 8 hours">Every 8 hours</option>
                                                <option value="Every 12 hours">Every 12 hours</option>
                                                <option value="As needed">As needed</option>
                                            </select>
                                        </div>
                                        <div class="flex items-end">
                                            <button type="button" class="remove-medicine px-3 py-2 bg-red-500 text-white text-xs font-medium rounded-lg hover:bg-red-600 transition-colors">
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('doctor.appointments.index') }}"
                                class="px-4 py-2 bg-slate-200 text-slate-700 text-sm font-medium rounded-xl hover:bg-slate-300 transition-colors">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-6 py-2 bg-teal-500 text-white text-sm font-medium rounded-xl hover:bg-teal-600 transition-colors">
                                Create Prescription
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let medicineIndex = 1;
            const container = document.getElementById('medicines-container');
            const addBtn = document.getElementById('add-medicine');
            const frequencies = [
                'Once daily', 'Twice daily', 'Three times daily',
                'Four times daily', 'Every 8 hours', 'Every 12 hours', 'As needed'
            ];

            addBtn.addEventListener('click', function() {
                const optionsHtml = @json($medicines->map(function($m) { return ['id' => $m->id, 'name' => $m->name]; }));
                const freqOptions = frequencies.map(f => `<option value="${f}">${f}</option>`).join('');

                const rowHtml = `
                    <div class="medicine-row bg-slate-50 rounded-xl p-4 border border-slate-200">
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                            <div class="md:col-span-1">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Medicine</label>
                                <select name="medicines[${medicineIndex}][medicine_id]" required
                                    class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm">
                                    <option value="">Select Medicine</option>
                                    ${optionsHtml.map(m => `<option value="${m.id}">${m.name}</option>`).join('')}
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Dosage</label>
                                <input type="text" name="medicines[${medicineIndex}][dosage]" required
                                    class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm"
                                    placeholder="e.g., 500mg">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Duration</label>
                                <input type="text" name="medicines[${medicineIndex}][duration]" required
                                    class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm"
                                    placeholder="e.g., 7 days">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Frequency</label>
                                <select name="medicines[${medicineIndex}][frequency]" required
                                    class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm">
                                    <option value="">Select Frequency</option>
                                    ${freqOptions}
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="button" class="remove-medicine px-3 py-2 bg-red-500 text-white text-xs font-medium rounded-lg hover:bg-red-600 transition-colors">
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                `;

                container.insertAdjacentHTML('beforeend', rowHtml);
                medicineIndex++;
            });

            container.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-medicine')) {
                    const row = e.target.closest('.medicine-row');
                    if (container.children.length > 1) {
                        row.remove();
                    } else {
                        alert('You must have at least one medicine.');
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
