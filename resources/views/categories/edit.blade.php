<x-app-layout>
    <div class="max-w-2xl mx-auto">
        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('categories.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-violet-600 hover:text-violet-700 transition mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Categories
            </a>
            <h1 class="text-3xl font-extrabold text-gray-800">Edit Category</h1>
            <p class="text-gray-400 mt-1">Update the classification name</p>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('categories.update', $category) }}" class="bg-white/70 backdrop-blur-sm rounded-3xl border-2 border-violet-100 shadow-sm p-8">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                {{-- Category Name --}}
                <div>
                    <label for="category_name" class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">Category Name</label>
                    <input type="text" name="category_name" id="category_name" value="{{ old('category_name', $category->category_name) }}" 
                           class="w-full rounded-2xl border-2 border-violet-100 bg-violet-50/50 text-sm text-gray-700 focus:ring-violet-300 focus:border-violet-300 px-4 py-3" required autofocus />
                    @error('category_name')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4">
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-violet-600 to-fuchsia-500 text-black font-bold py-3.5 rounded-2xl shadow-lg border border-violet-700 hover:shadow-xl hover:shadow-violet-300 transition-all duration-300 hover:-translate-y-0.5 cursor-pointer">
                        Update Category
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
