<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div><h1 class="text-2xl font-bold text-slate-800">Doctors</h1><p class="text-slate-500 mt-1">Manage medical staff</p></div>
        <a href="{{ route('admin.doctors.create') }}" class="inline-flex items-center gap-2 bg-teal-500 text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-teal-600 transition-colors shadow-md shadow-teal-500/20">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg> Add Doctor
        </a>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-200 flex flex-col sm:flex-row gap-3">
            <form action="{{ route('admin.doctors.index') }}" method="GET" class="flex gap-2 flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search doctors..." class="flex-1 rounded-xl border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500">
                <select name="department_id" class="rounded-xl border-slate-300 text-sm focus:border-teal-500 focus:ring-teal-500">
                    <option value="">All Departments</option>
                    @foreach($departments as $dept)<option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>@endforeach
                </select>
                <button type="submit" class="bg-slate-100 text-slate-600 px-4 py-2 rounded-xl text-sm font-medium hover:bg-slate-200">Filter</button>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50"><tr><th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Doctor</th><th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Department</th><th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Specialization</th><th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Fee</th><th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Actions</th></tr></thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($doctors as $doc)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4"><div class="flex items-center gap-3"><div class="w-9 h-9 rounded-full bg-gradient-to-br from-teal-400 to-blue-500 flex items-center justify-center text-white text-sm font-semibold">{{ substr($doc->user->name, 0, 2) }}</div><div><p class="font-medium text-slate-800">{{ $doc->user->name }}</p><p class="text-xs text-slate-400">{{ $doc->user->email }}</p></div></div></td>
                        <td class="px-6 py-4 text-slate-600">{{ $doc->department->name }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $doc->specialization }}</td>
                        <td class="px-6 py-4 text-slate-600">${{ number_format($doc->consultation_fee, 2) }}</td>
                        <td class="px-6 py-4 text-right"><div class="flex justify-end gap-1"><a href="{{ route('admin.doctors.edit', $doc) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a><form action="{{ route('admin.doctors.destroy', $doc) }}" method="POST" onsubmit="return confirm('Delete this doctor?')">@csrf @method('DELETE')<button class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></form></div></td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-6 py-12 text-center text-slate-400">No doctors found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-6">{{ $doctors->withQueryString()->links() }}</div>
</x-app-layout>
