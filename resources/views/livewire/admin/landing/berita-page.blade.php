<div>
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <x-atoms.title text="Manajemen Berita" class="text-gray-900" />
            <x-atoms.description text="Kelola berita, artikel, dan pengumuman sekolah." class="text-gray-500 mt-1" />
        </div>
        <x-atoms.button wire:click="create" variant="primary" class="flex items-center gap-2 shadow-lg shadow-lime-900/10 hover:shadow-lime-900/20">
            <x-heroicon-o-plus class="w-5 h-5" />
            Tambah Berita
        </x-atoms.button>
    </div>

    <x-atoms.card class="border-0 shadow-xl shadow-gray-200/40 ring-1 ring-gray-900/5">
        <div class="p-4 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row gap-4 justify-between items-center">
            <div class="relative w-full sm:w-72">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <x-heroicon-o-magnifying-glass class="h-5 w-5 text-gray-400" />
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" 
                    class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-lime-500 sm:text-sm transition duration-150 ease-in-out" 
                    placeholder="Cari judul berita..." />
            </div>
            
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <select wire:model.live="filterKategori" class="block w-full sm:w-auto pl-3 pr-10 py-2 text-base border-gray-200 focus:outline-none focus:ring-lime-500 focus:border-lime-500 sm:text-sm rounded-lg">
                    <option value="">Semua Kategori</option>
                    @foreach($allKategoris as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->name }}</option>
                    @endforeach
                </select>
                
                <select wire:model.live="filterStatus" class="block w-full sm:w-auto pl-3 pr-10 py-2 text-base border-gray-200 focus:outline-none focus:ring-lime-500 focus:border-lime-500 sm:text-sm rounded-lg">
                    <option value="">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="inactive">Tidak Aktif</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Thumbnail
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Judul & Ringkasan
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Kategori
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-48">
                            Statistik
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($beritas as $index => $berita)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $beritas->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="h-12 w-20 rounded-lg overflow-hidden bg-gray-100 border border-gray-200 group-hover:shadow-md transition-all">
                                    @if ($berita->thumbnail)
                                        <img src="{{ str_starts_with($berita->thumbnail, 'http') ? $berita->thumbnail : asset('storage/' . $berita->thumbnail) }}" alt=""
                                            class="h-full w-full object-cover">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center text-gray-400">
                                            <x-heroicon-o-photo class="h-6 w-6" />
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="max-w-xs">
                                    <x-atoms.title text="{{ $berita->title }}" size="sm" class="text-gray-900 mb-1 group-hover:text-lime-600 transition-colors line-clamp-2" />
                                    <x-atoms.description size="xs" class="text-gray-500 line-clamp-2">
                                        {{ $berita->description ?? Str::limit(strip_tags($berita->content), 80) }}
                                    </x-atoms.description>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-atoms.badge :text="$berita->kategori->name" :variant="'gray'" size="sm" class="font-medium" />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col gap-1.5">
                                    <div class="flex items-center gap-2 text-xs text-gray-500" title="Dilihat">
                                        <x-heroicon-o-eye class="w-3.5 h-3.5" />
                                        <span>{{ number_format($berita->views_count) }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-xs text-gray-500" title="Suka / Tidak Suka">
                                        <x-heroicon-o-hand-thumb-up class="w-3.5 h-3.5 text-lime-600" />
                                        <span>{{ number_format($berita->likes_count) }}</span>
                                        <span class="text-gray-300">/</span>
                                        <x-heroicon-o-hand-thumb-down class="w-3.5 h-3.5 text-red-400" />
                                        <span>{{ number_format($berita->dislikes_count) }}</span>
                                    </div>
                                    <button wire:click="toggleComments({{ $berita->id }})" 
                                            class="flex items-center gap-2 text-xs font-semibold {{ $berita->comments_count > 0 ? 'text-blue-600 hover:text-blue-700' : 'text-gray-400 hover:text-gray-600' }} transition-colors text-left mt-1">
                                        <x-heroicon-o-chat-bubble-left-right class="w-3.5 h-3.5" />
                                        {{ $berita->comments_count }} Komentar
                                        @if($berita->comments()->where('is_approved', false)->count() > 0)
                                            <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                                        @endif
                                    </button>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <button
                                        wire:click="toggleStatus({{ $berita->id }})"
                                        type="button"
                                        class="{{ $berita->is_active ? 'bg-lime-600' : 'bg-gray-200' }} relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-lime-600 focus:ring-offset-2"
                                        role="switch"
                                        aria-checked="{{ $berita->is_active ? 'true' : 'false' }}">
                                        <span
                                            aria-hidden="true"
                                            class="{{ $berita->is_active ? 'translate-x-5' : 'translate-x-0' }} pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out">
                                        </span>
                                    </button>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex justify-center gap-2">
                                    <button wire:click="edit({{ $berita->id }})" class="p-1 text-gray-400 hover:text-lime-600 transition-colors" title="Edit">
                                        <x-heroicon-o-pencil-square class="w-5 h-5" />
                                    </button>
                                    <button wire:click="delete({{ $berita->id }})" 
                                            onclick="confirm('Yakin ingin menghapus berita ini?') || event.stopImmediatePropagation()"
                                            class="p-1 text-gray-400 hover:text-red-600 transition-colors" title="Hapus">
                                        <x-heroicon-o-trash class="w-5 h-5" />
                                    </button>
                                </div>
                            </td>
                        </tr>

                        {{-- Comment Moderation Row --}}
                        @if($showComments === $berita->id)
                            <tr class="bg-gray-50/50 shadow-inner">
                                <td colspan="7" class="px-6 py-4">
                                    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                                        <div class="px-4 py-3 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                                            <h4 class="text-sm font-bold text-gray-700 flex items-center gap-2">
                                                <x-heroicon-o-chat-bubble-left-right class="w-4 h-4 text-blue-500" />
                                                Moderasi Komentar: <span class="text-gray-900">{{ Str::limit($berita->title, 40) }}</span>
                                            </h4>
                                            <button wire:click="$set('showComments', null)" class="text-gray-400 hover:text-gray-600">
                                                <x-heroicon-o-x-mark class="w-5 h-5" />
                                            </button>
                                        </div>
                                        
                                        @php $allComments = $berita->comments()->latest()->get(); @endphp
                                        
                                        <div class="divide-y divide-gray-100 max-h-96 overflow-y-auto">
                                            @forelse($allComments as $comment)
                                                <div class="p-4 flex gap-4 hover:bg-gray-50 transition-colors">
                                                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-500 flex-shrink-0">
                                                        {{ strtoupper(substr($comment->name, 0, 1)) }}
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-center gap-2 mb-1 flex-wrap">
                                                            <span class="text-sm font-semibold text-gray-900">{{ $comment->name }}</span>
                                                            <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                                            <span class="text-[10px] px-1.5 py-0.5 rounded-full font-medium {{ $comment->is_approved ? 'bg-lime-100 text-lime-700' : 'bg-orange-100 text-orange-700' }}">
                                                                {{ $comment->is_approved ? 'Disetujui' : 'Menunggu' }}
                                                            </span>
                                                        </div>
                                                        <p class="text-sm text-gray-600 mb-2">{{ $comment->message }}</p>
                                                        
                                                        <div class="flex gap-2">
                                                            @if(!$comment->is_approved)
                                                                <button wire:click="approveComment({{ $comment->id }})" 
                                                                        class="text-xs font-medium text-lime-600 hover:text-lime-700 hover:underline flex items-center gap-1">
                                                                    <x-heroicon-o-check class="w-3.5 h-3.5" /> Setujui
                                                                </button>
                                                            @endif
                                                            <button wire:click="deleteComment({{ $comment->id }})" 
                                                                    onclick="confirm('Hapus komentar ini?') || event.stopImmediatePropagation()"
                                                                    class="text-xs font-medium text-red-500 hover:text-red-700 hover:underline flex items-center gap-1">
                                                                <x-heroicon-o-trash class="w-3.5 h-3.5" /> Hapus
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="p-8 text-center text-gray-400 text-sm">
                                                    Belum ada komentar untuk berita ini.
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endif

                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <x-heroicon-o-newspaper class="w-12 h-12 text-gray-300 mb-4" />
                                    <h3 class="text-lg font-medium text-gray-900">Belum ada berita</h3>
                                    <p class="text-gray-500 mt-1 max-w-sm">Mulai dengan menambahkan berita baru untuk ditampilkan di halaman depan.</p>
                                    <button wire:click="create" class="mt-4 text-lime-600 font-medium hover:text-lime-700 hover:underline">
                                        Tambah Berita Baru
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $beritas->links() }}
        </div>
    </x-atoms.card>

    {{-- Create/Edit Modal with CKEditor --}}
    <x-atoms.modal name="berita-modal" maxWidth="5xl" :closeable="true">
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <x-atoms.title :text="$editMode ? 'Edit Berita' : 'Tambah Berita'" size="lg" class="text-gray-900" />
            <button wire:click="$dispatch('close-modal', { name: 'berita-modal' })" class="text-gray-400 hover:text-gray-600">
                <x-heroicon-o-x-mark class="w-6 h-6" />
            </button>
        </div>

        <div class="p-6 max-h-[75vh] overflow-y-auto bg-gray-50/50">
            <form wire:submit.prevent="save" class="space-y-6">
                {{-- Row 1: Title & Category --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <x-molecules.input-field label="Judul Berita" name="title" placeholder="Masukan judul berita"
                        wire:model="title" :error="$errors->first('title')" required />

                    <x-molecules.select-field label="Kategori" name="kategori_id" wire:model="kategori_id"
                        :options="collect([['value' => '', 'label' => '-- Pilih Kategori --']])
                            ->concat($allKategoris->map(fn($k) => ['value' => $k->id, 'label' => $k->name]))
                            ->toArray()" :error="$errors->first('kategori_id')" required />
                </div>

                {{-- Row 2: Description --}}
                <div>
                    <x-molecules.textarea-field
                        label="Deskripsi Singkat (untuk kartu & preview)"
                        name="description"
                        placeholder="Tulis deskripsi singkat yang menarik untuk ditampilkan di kartu berita dan preview sosial media... (maks 500 karakter)"
                        :rows="3"
                        wire:model="description"
                        :error="$errors->first('description')" />
                    <p class="text-xs text-gray-400 mt-1">Opsional. Jika kosong, akan menggunakan potongan konten artikel.</p>
                </div>

                {{-- Row 3: Content --}}
                <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Konten Artikel <span class="text-red-500">*</span>
                    </label>
                    <div wire:ignore>
                        <div id="ckeditor-container" class="w-full border border-gray-200 rounded-lg overflow-hidden min-h-[400px]">
                            {!! $content !!}
                        </div>
                    </div>

                    {{-- File Attachment Button --}}
                    <div class="flex items-center gap-3 mt-3 pt-3 border-t border-gray-100">
                        <button type="button" onclick="document.getElementById('file-attach-input').click()"
                                class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                            <x-heroicon-o-paper-clip class="w-4 h-4" />
                            Lampirkan Dokumen (PDF, Word, Excel)
                        </button>
                        <span id="file-attach-status" class="text-xs text-gray-400"></span>
                        <input type="file" id="file-attach-input" class="hidden"
                               accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.csv,.zip,.rar"
                               onchange="attachFile(this)" />
                    </div>

                    @error('content')
                        <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Row 4: Thumbnail & Status --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                        <x-atoms.label for="new_thumbnail">
                            Thumbnail Berita
                        </x-atoms.label>
                        <div class="flex items-start gap-4 mt-2">
                            <div class="w-24 h-24 rounded-lg overflow-hidden bg-gray-100 border border-gray-200 flex-shrink-0">
                                @if ($new_thumbnail)
                                    <img src="{{ $new_thumbnail->temporaryUrl() }}" class="w-full h-full object-cover">
                                @elseif($thumbnail)
                                    <img src="{{ str_starts_with($thumbnail, 'http') ? $thumbnail : asset('storage/' . $thumbnail) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <x-heroicon-o-photo class="w-8 h-8" />
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <input type="file" wire:model="new_thumbnail" id="new_thumbnail" class="block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-xs file:font-semibold
                                    file:bg-lime-50 file:text-lime-700
                                    hover:file:bg-lime-100
                                    transition-all mb-2" />
                                <p class="text-xs text-gray-400">Format: JPG, PNG, WEBP. Maks: 2MB.</p>
                                @error('new_thumbnail') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Status Publikasi</label>
                        <div class="flex items-center gap-8">
                            <label class="inline-flex items-center cursor-pointer group">
                                <input type="checkbox" wire:model="is_active" class="form-checkbox h-5 w-5 text-lime-600 rounded border-gray-300 focus:ring-lime-500 transition duration-150 ease-in-out">
                                <span class="ml-2 text-gray-700 group-hover:text-gray-900 transition-colors">Aktifkan Berita</span>
                            </label>
                            
                            <label class="inline-flex items-center cursor-pointer group">
                                <input type="checkbox" wire:model="is_priority" class="form-checkbox h-5 w-5 text-amber-500 rounded border-gray-300 focus:ring-amber-500 transition duration-150 ease-in-out">
                                <span class="ml-2 text-gray-700 group-hover:text-gray-900 transition-colors">Berita Prioritas (Highlight)</span>
                            </label>
                        </div>
                        <p class="text-xs text-gray-400 mt-3">
                            <span class="text-lime-600 font-medium">Aktif</span>: Berita dapat dilihat publik.<br>
                            <span class="text-amber-500 font-medium">Prioritas</span>: Berita akan muncul di carousel utama.
                        </p>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                    <x-atoms.button type="button" variant="secondary" wire:click="$dispatch('close-modal', { name: 'berita-modal' })">
                        Batal
                    </x-atoms.button>
                    <x-atoms.button type="submit" variant="primary" class="bg-gradient-to-r from-lime-600 to-lime-500 hover:from-lime-700 hover:to-lime-600 shadow-lg shadow-lime-900/10">
                        <span wire:loading.remove>Simpan Berita</span>
                        <span wire:loading>Menyimpan...</span>
                    </x-atoms.button>
                </div>
            </form>
        </div>
    </x-atoms.modal>
</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
    let editorInstance = null;

    document.addEventListener('DOMContentLoaded', initCKEditor);
    document.addEventListener('livewire:navigated', initCKEditor);

    // Re-init when modal opens
    window.addEventListener('open-modal', function() {
        setTimeout(initCKEditor, 300);
    });
    
    // Close modal event
    window.addEventListener('close-modal', function() {
        if (editorInstance) {
            // Optional: clear data if strictly needed
        }
    });

    // Custom upload adapter for image uploads
    class MyUploadAdapter {
        constructor(loader) {
            this.loader = loader;
        }
        upload() {
            return this.loader.file.then(file => new Promise((resolve, reject) => {
                const formData = new FormData();
                formData.append('file', file);

                fetch('/admin/upload-media', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.url) {
                        resolve({ default: data.url });
                    } else {
                        reject('Upload gagal');
                    }
                })
                .catch(() => reject('Upload gagal'));
            }));
        }
        abort() {}
    }

    function MyUploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => new MyUploadAdapter(loader);
    }

    function initCKEditor() {
        const el = document.getElementById('ckeditor-container');
        if (!el) return;

        // Destroy previous instance if exists to prevent duplicates
        if (editorInstance) {
            editorInstance.destroy().catch(e => console.warn(e));
            editorInstance = null;
        }

        ClassicEditor
            .create(el, {
                extraPlugins: [MyUploadAdapterPlugin],
                toolbar: [
                    'heading', '|',
                    'bold', 'italic', '|',
                    'bulletedList', 'numberedList', '|',
                    'outdent', 'indent', '|',
                    'link', 'uploadImage', 'insertTable', 'blockQuote', '|',
                    'undo', 'redo'
                ],
                image: {
                    toolbar: ['imageTextAlternative', 'imageStyle:inline', 'imageStyle:block', 'imageStyle:side']
                },
                table: {
                    contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                },
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' }
                    ]
                }
            })
            .then(editor => {
                editorInstance = editor;

                // Load initial data from Livewire (fixing empty editor on Edit)
                const initialData = @this.get('content');
                if (initialData) {
                    editor.setData(initialData);
                }

                // Sync content to Livewire on every change
                editor.model.document.on('change:data', () => {
                    @this.set('content', editor.getData());
                });

                // Also sync on blur as fallback
                editor.ui.focusTracker.on('change:isFocused', (evt, name, isFocused) => {
                    if (!isFocused) {
                        @this.set('content', editor.getData());
                    }
                });
            })
            .catch(error => {
                console.error('CKEditor init error:', error);
            });
    }

    // File attachment handler — uploads doc and inserts download link
    function attachFile(input) {
        const file = input.files[0];
        if (!file) return;

        const status = document.getElementById('file-attach-status');
        status.textContent = 'Mengupload ' + file.name + '...';

        const formData = new FormData();
        formData.append('file', file);

        fetch('/admin/upload-media', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.url && editorInstance) {
                const fileName = data.filename || file.name;
                const ext = fileName.split('.').pop().toUpperCase();
                
                // Build HTML link for the attachment
                const html = '<p>📎 <a href="' + data.url + '" target="_blank" rel="noopener"><strong>' + fileName + '</strong></a> (' + ext + ')</p>';
                
                const viewFragment = editorInstance.data.processor.toView(html);
                const modelFragment = editorInstance.data.toModel(viewFragment);
                editorInstance.model.insertContent(modelFragment);

                // Sync to Livewire
                @this.set('content', editorInstance.getData());

                status.textContent = '✓ Berhasil dilampirkan';
                setTimeout(() => status.textContent = '', 3000);
            } else {
                status.textContent = '✗ Upload gagal';
            }
        })
        .catch(() => {
            status.textContent = '✗ Upload gagal';
        });
        
        // Reset input
        input.value = '';
    }
</script>

<style>
    .ck-editor__editable {
        min-height: 400px;
        max-height: 600px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        font-size: 15px;
        line-height: 1.7;
        color: #374151;
        padding: 0 20px;
    }
    .ck-editor__editable:focus {
        border-color: #84cc16 !important;
        box-shadow: 0 0 0 2px rgba(132, 204, 22, 0.2) !important;
    }
    /* Fix toolbar wrapping */
    .ck-toolbar {
        flex-wrap: wrap !important;
    }
</style>
@endpush
