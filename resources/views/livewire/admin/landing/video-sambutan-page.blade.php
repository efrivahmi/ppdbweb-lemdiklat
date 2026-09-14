<div class="p-6">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Video Sambutan (Lokal)</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola video sambutan yang akan tampil di halaman depan. Maksimal 30MB.</p>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Form Pengaturan -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-6">
                <form wire:submit.prevent="save">
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Aktif</label>
                        <div class="flex items-center">
                            <input type="checkbox" wire:model="video_is_active" class="h-4 w-4 text-lime-600 focus:ring-lime-500 border-gray-300 rounded">
                            <label class="ml-2 block text-sm text-gray-900">
                                Tampilkan video ini di halaman depan
                            </label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Video</label>
                        <input type="text" wire:model="video_title" class="w-full rounded-md border-gray-300 shadow-sm focus:border-lime-500 focus:ring-lime-500" placeholder="Contoh: Sambutan Kepala Sekolah">
                        @error('video_title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                        <textarea wire:model="video_description" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-lime-500 focus:ring-lime-500" placeholder="Deskripsi opsional untuk mendampingi video..."></textarea>
                        @error('video_description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">File Video (.mp4, max 30MB)</label>
                        
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-lime-600 hover:text-lime-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-lime-500">
                                        <span>Upload a file</span>
                                        <input id="file-upload" wire:model="video_file" type="file" accept="video/mp4,video/webm,video/ogg" class="sr-only">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    MP4, WebM up to 30MB
                                </p>
                            </div>
                        </div>
                        
                        <div wire:loading wire:target="video_file" class="mt-2 text-sm text-lime-600">
                            Mengunggah video... mohon tunggu.
                        </div>
                        
                        @if ($video_file)
                            <div class="mt-2 text-sm text-green-600">
                                File siap disimpan: {{ $video_file->getClientOriginalName() }}
                            </div>
                        @endif
                        
                        @error('video_file') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-lime-600 text-white rounded hover:bg-lime-700 focus:outline-none focus:ring-2 focus:ring-lime-500 focus:ring-offset-2 flex items-center" wire:loading.attr="disabled">
                            <i class="ri-save-line mr-2"></i> Simpan Pengaturan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Preview Video -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Preview Video Saat Ini</h3>
                
                @if($local_video_path)
                    <div class="w-full aspect-video bg-black rounded-lg overflow-hidden relative">
                        <video class="w-full h-full object-cover" controls>
                            <source src="{{ asset('storage/' . $local_video_path) }}" type="video/mp4">
                            Browser Anda tidak mendukung tag video.
                        </video>
                    </div>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="text-sm text-gray-500 truncate max-w-[200px]" title="{{ $local_video_path }}">{{ basename($local_video_path) }}</span>
                        <button wire:click="deleteVideo" onclick="confirm('Yakin ingin menghapus video ini?') || event.stopImmediatePropagation()" class="text-red-600 hover:text-red-800 text-sm flex items-center">
                            <i class="ri-delete-bin-line mr-1"></i> Hapus Video
                        </button>
                    </div>
                @else
                    <div class="w-full aspect-video bg-gray-100 rounded-lg flex flex-col items-center justify-center text-gray-400 border-2 border-dashed border-gray-300">
                        <i class="ri-vidicon-line text-4xl mb-2"></i>
                        <p>Belum ada video yang diunggah</p>
                    </div>
                @endif
                
                <div class="mt-6 bg-blue-50 p-4 rounded-md border border-blue-100">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="ri-information-line text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Tips Optimasi Video</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>Gunakan format <b>.mp4</b> dengan codec H.264 untuk kompatibilitas terbaik di semua HP.</li>
                                    <li>Kompres video menggunakan <a href="https://handbrake.fr/" target="_blank" class="underline">Handbrake</a> atau <a href="https://www.freeconvert.com/video-compressor" target="_blank" class="underline">FreeConvert</a> sebelum diunggah.</li>
                                    <li>Durasi ideal untuk landing page adalah 1-2 menit.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
