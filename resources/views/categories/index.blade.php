<x-app-layout>
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-800">Category Management</h1>
            <p class="text-gray-400 mt-1">Manage pet categories for the shelter</p>
        </div>
        <a href="{{ route('categories.create') }}"
           class="inline-flex items-center gap-2 bg-gradient-to-r from-violet-600 to-fuchsia-500 text-black text-sm font-semibold px-5 py-2.5 rounded-2xl shadow-lg shadow-violet-200 hover:shadow-xl hover:shadow-violet-300 transition-all duration-300 hover:-translate-y-0.5 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Add New Category
        </a>
    </div>

    {{-- Categories List --}}
    <div class="bg-white/70 backdrop-blur-sm rounded-3xl border-2 border-violet-100 shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b-2 border-violet-100 bg-violet-50/30 text-xs font-bold text-gray-400 uppercase tracking-wider">
                    <th class="px-6 py-4">Category Name</th>
                    <th class="px-6 py-4 text-center">Pets Count</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y-2 divide-violet-100">
                @forelse($categories as $category)
                    <tr class="hover:bg-violet-50/30 transition-colors group">
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-gray-700">{{ $category->category_name }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-violet-50 text-violet-700 border border-violet-200">
                                {{ $category->pets_count }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('categories.edit', $category) }}"
                                   class="p-2 text-amber-600 hover:bg-amber-50 rounded-xl border border-amber-200 transition" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('categories.destroy', $category) }}" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete this category?')"
                                            class="p-2 text-red-500 hover:bg-red-50 rounded-xl border border-red-200 transition {{ $category->pets_count > 0 ? 'opacity-30 cursor-not-allowed' : '' }}"
                                            {{ $category->pets_count > 0 ? 'disabled' : '' }}
                                            title="{{ $category->pets_count > 0 ? 'Cannot delete category with pets' : '' }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center text-gray-400">
                            No categories found. Click "Add New Category" to get started.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
