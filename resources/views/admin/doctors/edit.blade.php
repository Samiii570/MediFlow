<x-app-layout>
    <div class="max-w-2xl mx-auto">
        <div class="mb-6"><h1 class="text-2xl font-bold text-slate-800">Edit Doctor</h1></div>
        <form action="{{ route('admin.doctors.update', $doctor) }}" method="POST" class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-5">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div><label class="block text-sm font-medium text-slate-700 mb-1.5">Full Name *</label><input type="text" name="name" value="{{ old('name', $doctor->user->name) }}" class="w-full rounded-xl border-slate-300 focus:border-teal-500 focus:ring-teal-500" required></div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1.5">Email *</label><input type="email" name="email" value="{{ old('email', $doctor->user->email) }}" class="w-full rounded-xl border-slate-300 focus:border-teal-500 focus:ring-teal-500" required></div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1.5">Phone</label><input type="text" name="phone" value="{{ old('phone', $doctor->user->phone) }}" class="w-full rounded-xl border-slate-300 focus:border-teal-500 focus:ring-teal-500"></div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1.5">Department *</label><select name="department_id" class="w-full rounded-xl border-slate-300 focus:border-teal-500 focus:ring-teal-500" required><option value="">Select...</option>@foreach($departments as $d)<option value="{{ $d->id }}" {{ old('department_id', $doctor->department_id) == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>@endforeach</select></div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1.5">Specialization</label><input type="text" name="specialization" value="{{ old('specialization', $doctor->specialization) }}" class="w-full rounded-xl border-slate-300 focus:border-teal-500 focus:ring-teal-500"></div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1.5">Qualification</label><input type="text" name="qualification" value="{{ old('qualification', $doctor->qualification) }}" class="w-full rounded-xl border-slate-300 focus:border-teal-500 focus:ring-teal-500"></div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1.5">Consultation Fee *</label><input type="number" step="0.01" name="consultation_fee" value="{{ old('consultation_fee', $doctor->consultation_fee) }}" class="w-full rounded-xl border-slate-300 focus:border-teal-500 focus:ring-teal-500" required></div>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-teal-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-teal-600 transition-colors">Update Doctor</button>
                <a href="{{ route('admin.doctors.index') }}" class="bg-slate-100 text-slate-600 px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-200 transition-colors">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
