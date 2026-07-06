<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.tasks.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                🔧 Edit Tugas
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-6 py-5">
                    <h3 class="text-white font-bold text-lg">Edit Tugas</h3>
                    <p class="text-amber-100 text-sm mt-1">Perbarui informasi tugas di bawah ini.</p>
                </div>

                <form action="{{ route('admin.tasks.update', $task) }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    @method('PUT')

                    {{-- Judul --}}
                    <div>
                        <label for="title" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Judul Tugas <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="title" name="title"
                            value="{{ old('title', $task->title) }}"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-300 focus:border-amber-400 outline-none transition @error('title') border-red-400 @enderror">
                        @error('title')
                            <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Deskripsi <span class="text-red-500">*</span>
                        </label>
                        <textarea id="description" name="description" rows="4"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-300 focus:border-amber-400 outline-none transition resize-none @error('description') border-red-400 @enderror">{{ old('description', $task->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Assign ke Pegawai --}}
                    <div>
                        <label for="assigned_to" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Ditugaskan Kepada <span class="text-red-500">*</span>
                        </label>
                        <select id="assigned_to" name="assigned_to"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-300 focus:border-amber-400 outline-none transition @error('assigned_to') border-red-400 @enderror">
                            <option value="">-- Pilih Pegawai --</option>
                            @foreach($pegawai as $p)
                                <option value="{{ $p->id }}" {{ old('assigned_to', $task->assigned_to) == $p->id ? 'selected' : '' }}>
                                    {{ $p->name }} ({{ $p->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('assigned_to')
                            <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Deadline + Status --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="deadline" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Deadline <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="deadline" name="deadline"
                                value="{{ old('deadline', $task->deadline->format('Y-m-d')) }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-300 focus:border-amber-400 outline-none transition @error('deadline') border-red-400 @enderror">
                            @error('deadline')
                                <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select id="status" name="status"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-amber-300 focus:border-amber-400 outline-none transition">
                                <option value="pending" {{ old('status', $task->status) === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                <option value="progress" {{ old('status', $task->status) === 'progress' ? 'selected' : '' }}>🔄 Progress</option>
                                <option value="completed" {{ old('status', $task->status) === 'completed' ? 'selected' : '' }}>✅ Completed</option>
                            </select>
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit"
                            class="flex-1 bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2.5 rounded-xl transition-colors shadow-sm">
                            Perbarui Tugas
                        </button>
                        <a href="{{ route('admin.tasks.index') }}"
                            class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 rounded-xl transition-colors">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

