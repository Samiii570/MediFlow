<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-slate-800 leading-tight">Book Appointment</h2>
                <p class="text-sm text-slate-500 mt-1">Schedule a new appointment</p>
            </div>
            <a href="{{ route('patient.appointments.index') }}" class="text-sm text-slate-600 hover:text-slate-800 font-medium">
                &larr; Back to Appointments
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('patient.appointments.store') }}" method="POST" id="appointmentForm">
                @csrf
                <input type="hidden" name="doctor_id" id="doctor_id" value="{{ old('doctor_id') }}">
                <input type="hidden" name="department_id" id="department_id" value="{{ old('department_id') }}">

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Step 1: Select Department</h3>
                    <div class="mb-2">
                        <select name="department_select" id="department_select"
                            class="w-full rounded-lg border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm @error('department_id') border-red-500 @enderror">
                            <option value="">-- Select Department --</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_select') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('department_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6" id="doctorSection" style="display: none;">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Step 2: Select Doctor</h3>
                    <div id="doctorLoading" class="hidden py-4 text-center">
                        <svg class="animate-spin h-6 w-6 text-teal-600 mx-auto" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="text-slate-500 text-sm mt-2">Loading doctors...</p>
                    </div>
                    <div id="doctorList" class="space-y-3">
                        <p class="text-slate-500 text-sm">Please select a department first</p>
                    </div>
                    <div id="doctorInfo" class="hidden mt-4 p-4 bg-teal-50 rounded-xl border border-teal-200">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-teal-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800" id="selectedDoctorName">-</p>
                                <p class="text-sm text-slate-600" id="selectedDoctorSpecialization">-</p>
                                <p class="text-sm text-teal-700 font-medium" id="selectedDoctorFee">-</p>
                            </div>
                        </div>
                    </div>
                    @error('doctor_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6" id="dateSection" style="display: none;">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Step 3: Select Date</h3>
                    <input type="date" name="appointment_date" id="appointment_date"
                        min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"
                        value="{{ old('appointment_date') }}"
                        class="w-full rounded-lg border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm @error('appointment_date') border-red-500 @enderror">
                    @error('appointment_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end" id="submitSection" style="display: none;">
                    <button type="submit" id="submitBtn"
                        class="px-6 py-3 bg-teal-600 text-white font-medium rounded-lg hover:bg-teal-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        Book Appointment
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const departmentSelect = document.getElementById('department_select');
            const departmentIdInput = document.getElementById('department_id');
            const doctorIdInput = document.getElementById('doctor_id');
            const doctorSection = document.getElementById('doctorSection');
            const doctorLoading = document.getElementById('doctorLoading');
            const doctorList = document.getElementById('doctorList');
            const doctorInfo = document.getElementById('doctorInfo');
            const dateSection = document.getElementById('dateSection');
            const submitSection = document.getElementById('submitSection');

            departmentSelect.addEventListener('change', function() {
                const departmentId = this.value;
                departmentIdInput.value = departmentId;
                doctorIdInput.value = '';

                if (!departmentId) {
                    doctorSection.style.display = 'none';
                    dateSection.style.display = 'none';
                    submitSection.style.display = 'none';
                    return;
                }

                doctorSection.style.display = 'block';
                doctorLoading.classList.remove('hidden');
                doctorList.innerHTML = '';
                doctorInfo.classList.add('hidden');
                dateSection.style.display = 'none';
                submitSection.style.display = 'none';

                fetch(`/patient/doctors/${departmentId}`)
                    .then(response => response.json())
                    .then(data => {
                        doctorLoading.classList.add('hidden');
                        if (data.length === 0) {
                            doctorList.innerHTML = '<p class="text-slate-500 text-sm py-2">No doctors available in this department</p>';
                            return;
                        }

                        let html = '';
                        data.forEach(doctor => {
                            html += `
                                <label class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl cursor-pointer hover:border-teal-400 transition doctor-card" data-doctor='${JSON.stringify(doctor)}'>
                                    <input type="radio" name="doctor_radio" value="${doctor.id}" class="text-teal-600 focus:ring-teal-500">
                                    <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-slate-800">Dr. ${doctor.name}</p>
                                        <p class="text-xs text-slate-500">${doctor.specialization || ''}</p>
                                    </div>
                                    <span class="ml-auto text-sm font-medium text-teal-700">LKR ${doctor.consultation_fee || 'N/A'}</span>
                                </label>
                            `;
                        });
                        doctorList.innerHTML = html;

                        document.querySelectorAll('.doctor-card').forEach(card => {
                            card.addEventListener('click', function() {
                                const doctor = JSON.parse(this.dataset.doctor);
                                doctorIdInput.value = doctor.id;

                                document.getElementById('selectedDoctorName').textContent = 'Dr. ' + doctor.name;
                                document.getElementById('selectedDoctorSpecialization').textContent = doctor.specialization || 'General';
                                document.getElementById('selectedDoctorFee').textContent = 'Fee: LKR ' + (doctor.consultation_fee || 'N/A');

                                doctorInfo.classList.remove('hidden');
                                dateSection.style.display = 'block';
                                submitSection.style.display = 'block';

                                document.querySelectorAll('.doctor-card').forEach(c => c.classList.remove('border-teal-400', 'bg-teal-50'));
                                this.classList.add('border-teal-400', 'bg-teal-50');
                            });
                        });
                    })
                    .catch(error => {
                        doctorLoading.classList.add('hidden');
                        doctorList.innerHTML = '<p class="text-red-500 text-sm py-2">Error loading doctors. Please try again.</p>';
                    });
            });

            if (departmentSelect.value) {
                departmentSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
</x-app-layout>
