<x-app-layout>
    {{-- Header --}}
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('pets.index') }}"
           class="p-2 rounded-2xl bg-white text-gray-500 hover:text-violet-600 hover:bg-violet-50 border-2 border-violet-100 shadow-sm transition-all duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-3xl font-extrabold text-gray-800">Add New Pet</h1>
            <p class="text-sm text-gray-400 mt-1">Register a new adoptable pet to the shelter</p>
        </div>
    </div>

    {{-- Form Container --}}
    <div class="max-w-4xl bg-white/80 backdrop-blur-xl rounded-3xl border-2 border-violet-100 shadow-lg overflow-hidden">
        <form method="POST" action="{{ route('pets.store') }}" enctype="multipart/form-data" class="p-8 sm:p-10">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                
                {{-- Name --}}
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Pet Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="What is the pet's name?"
                           class="w-full rounded-2xl border-2 border-violet-100 bg-violet-50/30 text-gray-800 placeholder-gray-400 focus:bg-white focus:ring-4 focus:ring-violet-500/20 focus:border-violet-400 px-5 py-3.5 transition-all @error('name') border-red-300 bg-red-50 focus:ring-red-500/20 focus:border-red-400 @enderror"/>
                    @error('name')<p class="mt-2 text-sm font-medium text-red-500">{{ $message }}</p>@enderror
                </div>

                {{-- Category --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Category <span class="text-red-500">*</span></label>
                    <select name="category_id" 
                            class="w-full rounded-2xl border-2 border-violet-100 bg-violet-50/30 text-gray-800 focus:bg-white focus:ring-4 focus:ring-violet-500/20 focus:border-violet-400 px-5 py-3.5 transition-all @error('category_id') border-red-300 bg-red-50 focus:ring-red-500/20 focus:border-red-400 @enderror" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="mt-2 text-sm font-medium text-red-500">{{ $message }}</p>@enderror
                </div>

                {{-- Breed --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Breed <span class="text-red-500">*</span></label>
                    <input type="text" name="breed" value="{{ old('breed') }}" placeholder="e.g. Golden Retriever"
                           class="w-full rounded-2xl border-2 border-violet-100 bg-violet-50/30 text-gray-800 placeholder-gray-400 focus:bg-white focus:ring-4 focus:ring-violet-500/20 focus:border-violet-400 px-5 py-3.5 transition-all @error('breed') border-red-300 bg-red-50 focus:ring-red-500/20 focus:border-red-400 @enderror"/>
                    @error('breed')<p class="mt-2 text-sm font-medium text-red-500">{{ $message }}</p>@enderror
                </div>

                {{-- Age --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Age (years) <span class="text-red-500">*</span></label>
                    <input type="number" name="age" value="{{ old('age') }}" min="0" max="99" placeholder="e.g. 2"
                           class="w-full rounded-2xl border-2 border-violet-100 bg-violet-50/30 text-gray-800 placeholder-gray-400 focus:bg-white focus:ring-4 focus:ring-violet-500/20 focus:border-violet-400 px-5 py-3.5 transition-all @error('age') border-red-300 bg-red-50 focus:ring-red-500/20 focus:border-red-400 @enderror"/>
                    @error('age')<p class="mt-2 text-sm font-medium text-red-500">{{ $message }}</p>@enderror
                </div>

                {{-- Gender --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Gender <span class="text-red-500">*</span></label>
                    <select name="gender"
                            class="w-full rounded-2xl border-2 border-violet-100 bg-violet-50/30 text-gray-800 focus:bg-white focus:ring-4 focus:ring-violet-500/20 focus:border-violet-400 px-5 py-3.5 transition-all @error('gender') border-red-300 bg-red-50 focus:ring-red-500/20 focus:border-red-400 @enderror">
                        <option value="">Select gender</option>
                        <option value="Male"   {{ old('gender') === 'Male'   ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('gender')<p class="mt-2 text-sm font-medium text-red-500">{{ $message }}</p>@enderror
                </div>

                {{-- Health Status --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Health Status</label>
                    <input type="text" name="health_status" value="{{ old('health_status') }}" placeholder="e.g. Vaccinated, Healthy"
                           class="w-full rounded-2xl border-2 border-violet-100 bg-violet-50/30 text-gray-800 placeholder-gray-400 focus:bg-white focus:ring-4 focus:ring-violet-500/20 focus:border-violet-400 px-5 py-3.5 transition-all"/>
                    @error('health_status')<p class="mt-2 text-sm font-medium text-red-500">{{ $message }}</p>@enderror
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                    <select name="status"
                            class="w-full rounded-2xl border-2 border-violet-100 bg-violet-50/30 text-gray-800 focus:bg-white focus:ring-4 focus:ring-violet-500/20 focus:border-violet-400 px-5 py-3.5 transition-all">
                        <option value="Available" {{ old('status', 'Available') === 'Available' ? 'selected' : '' }}>Available</option>
                        <option value="Adopted"   {{ old('status') === 'Adopted'   ? 'selected' : '' }}>Adopted</option>
                        <option value="Archived"  {{ old('status') === 'Archived'  ? 'selected' : '' }}>Archived</option>
                    </select>
                    @error('status')<p class="mt-2 text-sm font-medium text-red-500">{{ $message }}</p>@enderror
                </div>

                {{-- Description --}}
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="4" placeholder="Tell us about the pet's personality and background..."
                              class="w-full rounded-2xl border-2 border-violet-100 bg-violet-50/30 text-gray-800 placeholder-gray-400 focus:bg-white focus:ring-4 focus:ring-violet-500/20 focus:border-violet-400 px-5 py-3.5 transition-all resize-y">{{ old('description') }}</textarea>
                    @error('description')<p class="mt-2 text-sm font-medium text-red-500">{{ $message }}</p>@enderror
                </div>

                {{-- Image Upload --}}
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Pet Photo</label>
                    <div class="mt-1 flex items-center gap-6">
                        <div id="imagePreviewContainer" class="hidden shrink-0">
                            <img id="imagePreview" src="#" alt="Preview" class="w-24 h-24 rounded-2xl object-cover ring-2 ring-violet-200 shadow-sm"/>
                        </div>
                        <div class="flex-1">
                            <input id="imageInput" type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" onchange="previewImage(event)"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-2 file:border-violet-100 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100 transition-all cursor-pointer @error('image') border-red-300 @enderror"/>
                            <p class="mt-2 text-xs text-gray-400">JPEG, PNG, JPG, GIF or WEBP. Max 10MB.</p>
                            <p id="imageSizeError" class="mt-2 text-sm font-medium text-red-500 hidden">File is too large. Please select an image under 10MB.</p>
                            @error('image')<p class="mt-2 text-sm font-medium text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="mt-10 flex items-center justify-end gap-4 pt-6 border-t-2 border-violet-100">
                <a href="{{ route('pets.index') }}"
                   class="px-6 py-3 rounded-2xl text-sm font-bold text-gray-500 hover:text-gray-700 hover:bg-gray-100 border-2 border-transparent hover:border-gray-200 transition-all">
                    Cancel
                </a>
                <button type="submit"
                        class="px-8 py-3 rounded-2xl text-sm font-bold text-black bg-gradient-to-r from-violet-600 to-fuchsia-500 shadow-lg border border-violet-700 hover:shadow-xl hover:-translate-y-0.5 transition-all cursor-pointer">
                    Save Pet Profile
                </button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (!file) return;

            const sizeError = document.getElementById('imageSizeError');
            const maxBytes = 10 * 1024 * 1024; // 10MB

            if (file.size > maxBytes) {
                sizeError.classList.remove('hidden');
                event.target.value = '';
                document.getElementById('imagePreviewContainer').classList.add('hidden');
                return;
            }
            sizeError.classList.add('hidden');

            const reader = new FileReader();
            reader.onload = function () {
                const img = document.getElementById('imagePreview');
                img.src = reader.result;
                document.getElementById('imagePreviewContainer').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    </script>
</x-app-layout>
