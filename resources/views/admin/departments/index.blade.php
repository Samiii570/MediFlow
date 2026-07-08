<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div><h1 class="text-2xl font-bold text-slate-800">Departments</h1><p class="text-slate-500 mt-1">Manage hospital departments</p></div>
        <a href="{{ route('admin.departments.create') }}" class="inline-flex items-center gap-2 bg-teal-500 text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-teal-600 transition-colors shadow-md shadow-teal-500/20">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg> Add Department
        </a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($departments as $dept)
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="font-semibold text-slate-800">{{ $dept->name }}</h3>
                    <p class="text-sm text-slate-500 mt-1">{{ $dept->description ?: 'No description' }}</p>
                    <p class="text-xs text-slate-400 mt-2">{{ $dept->doctors_count }} doctor(s)</p>
                </div>
                <div class="flex gap-1">
                    <a href="{{ route('admin.departments.edit', $dept) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>
                    <form action="{{ route('admin.departments.destroy', $dept) }}" method="POST" onsubmit="return confirm('Delete this department?')">@csrf @method('DELETE')<button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 bg-white rounded-2xl border border-slate-200 p-12 text-center">
            <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            <p class="text-slate-500">No departments found</p>
        </div>
        @endforelse
    </div>
    <div class="mt-6">{{ $departments->links() }}</div>
</x-app-layout>
