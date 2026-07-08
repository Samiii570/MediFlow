<x-app-layout>
    <div class="max-w-2xl mx-auto">
        <div class="mb-6"><h1 class="text-2xl font-bold text-slate-800">Edit Department</h1></div>
        <form action="{{ route('admin.departments.update', $department) }}" method="POST" class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm space-y-5">
            @csrf @method('PUT')
            <div><label class="block text-sm font-medium text-slate-700 mb-1.5">Department Name *</label><input type="text" name="name" value="{{ old('name', $department->name) }}" class="w-full rounded-xl border-slate-300 focus:border-teal-500 focus:ring-teal-500" required>@error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
            <div><label class="block text-sm font-medium text-slate-700 mb-1.5">Description</label><textarea name="description" rows="3" class="w-full rounded-xl border-slate-300 focus:border-teal-500 focus:ring-teal-500">{{ old('description', $department->description) }}</textarea></div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-teal-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-teal-600 transition-colors">Update Department</button>
                <a href="{{ route('admin.departments.index') }}" class="bg-slate-100 text-slate-600 px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-200 transition-colors">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
