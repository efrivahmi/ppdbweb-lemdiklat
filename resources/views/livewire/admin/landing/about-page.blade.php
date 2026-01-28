<div>
    {{-- Breadcrumb --}}
    <x-atoms.breadcrumb currentPath="Tentang Sekolah" />

    {{-- Loading State --}}
    @if($isLoading)
        <x-atoms.card className="mt-3">
            <div class="animate-pulse space-y-6">
                <div class="h-8 bg-gray-200 rounded w-1/3"></div>
                <div class="space-y-4">
                    <div class="h-4 bg-gray-200 rounded"></div>
                    <div class="h-4 bg-gray-200 rounded w-5/6"></div>
                    <div class="h-4 bg-gray-200 rounded w-4/6"></div>
                </div>
                <div class="h-32 bg-gray-200 rounded"></div>
            </div>
        </x-atoms.card>
    @else
        {{-- Main Content --}}
        <x-atoms.card className="mt-3">
            {{-- Header --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <x-atoms.title text="Edit Tentang Sekolah" size="xl" />
                    <x-atoms.description class="text-gray-600 mt-2">
                        Edit informasi tentang sekolah yang akan ditampilkan di halaman landing
                    </x-atoms.description>
                </div>

                <div class="flex gap-3">
                    <x-atoms.button 
                        wire:click="resetToDefault" 
                        onclick="return confirm('Yakin ingin mereset ke data default?')"
                        variant="outline" 
                        theme="dark" 
                        heroicon="arrow-path"
                        class="text-orange-600 border-orange-600 hover:bg-orange-600 hover:text-white">
                        Reset Default
                    </x-atoms.button>
                </div>
            </div>

            {{-- Form Content --}}
            <form wire:submit.prevent="save" class="space-y-8">
                {{-- Badge Section --}}
                <div class="space-y-4 p-6 bg-gray-50 rounded-lg">
                    <x-atoms.title text="Badge Configuration" size="lg" class="text-gray-800 flex items-center gap-2">
                        <x-heroicon-o-tag class="w-5 h-5 text-lime-600" />
                        Badge Configuration
                    </x-atoms.title>
                    
                    <x-molecules.input-field label="Badge Text" name="badge_text" placeholder="Tentang Kami"
                        wire:model="badge_text" :error="$errors->first('badge_text')" required />
                    
                    <x-atoms.description size="sm" class="text-gray-600">
                        Badge akan ditampilkan dengan style default (emerald, medium size)
                    </x-atoms.description>
                </div>

                {{-- Title Section --}}
                <div class="space-y-4 p-6 bg-gray-50 rounded-lg">
                    <x-atoms.title text="Title Configuration" size="lg" class="text-gray-800 flex items-center gap-2">
                        <x-heroicon-o-document-text class="w-5 h-5 text-lime-600" />
                        Title Configuration
                    </x-atoms.title>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-molecules.input-field label="Title Text" name="title_text" placeholder="Profil Sekolah"
                            wire:model="title_text" :error="$errors->first('title_text')" required />
                        
                        <x-molecules.input-field label="Title Highlight" name="title_highlight" placeholder="Kata yang dihighlight"
                            wire:model="title_highlight" :error="$errors->first('title_highlight')" />
                        
                        <div class="md:col-span-2">
                            <x-molecules.input-field label="CSS Class Name" name="title_class_name" placeholder="lg:text-5xl"
                                wire:model="title_class_name" :error="$errors->first('title_class_name')" />
                            <x-atoms.description size="xs" class="text-gray-500 mt-1">
                                Contoh: lg:text-5xl, text-4xl md:text-6xl, dll. Title akan menggunakan size default (3xl) jika class ini kosong.
                            </x-atoms.description>
                        </div>
                    </div>
                    
                    {{-- Title Preview --}}
                    <div class="mt-4">
                        <x-atoms.description size="sm" class="text-gray-600 mb-2">Preview:</x-atoms.description>
                        <x-atoms.title 
                            :text="$title_text" 
                            :highlight="$title_highlight"
                            size="3xl"
                            :className="$title_class_name"
                        />
                    </div>
                </div>

                {{-- Description Section --}}
                <div class="space-y-4 p-6 bg-gray-50 rounded-lg">
                    <x-atoms.title text="Description" size="lg" class="text-gray-800 flex items-center gap-2">
                        <x-heroicon-o-document-text class="w-5 h-5 text-lime-600" />
                        Description
                    </x-atoms.title>
                    
                    <x-molecules.textarea-field 
                        label="Deskripsi Sekolah" 
                        name="description" 
                        :rows="6"
                        placeholder="Masukkan deskripsi lengkap tentang sekolah..."
                        wire:model="description" 
                        :error="$errors->first('description')" 
                        required 
                    />
                    
                    <x-atoms.description size="xs" class="text-gray-500">
                        Maksimal 2000 karakter. Saat ini: {{ strlen($description) }} karakter
                    </x-atoms.description>
                </div>

                {{-- Image Section --}}
                <div class="space-y-4 p-6 bg-gray-50 rounded-lg">
                    <x-atoms.title text="Image Configuration" size="lg" class="text-gray-800 flex items-center gap-2">
                        <x-heroicon-o-photo class="w-5 h-5 text-lime-600" />
                        Image Configuration
                    </x-atoms.title>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-molecules.input-field label="Image URL" name="image_url" placeholder="https://example.com/image.jpg"
                            wire:model="image_url" :error="$errors->first('image_url')" />
                        
                        <x-molecules.file-field label="Upload New Image" name="new_image" accept="image/*" maxSize="2MB" 
                            wire:model="new_image" :error="$errors->first('new_image')" />
                        
                        <x-molecules.input-field label="Image Title" name="image_title" placeholder="Gedung Sekolah"
                            wire:model="image_title" :error="$errors->first('image_title')" required />
                        
                        <x-molecules.textarea-field label="Image Description" name="image_description" :rows="3"
                            placeholder="Deskripsi gambar..." wire:model="image_description" 
                            :error="$errors->first('image_description')" />
                    </div>
                    
                    {{-- Image Preview --}}
                    @if ($new_image)
                        <div class="mt-4">
                            <x-atoms.description size="sm" class="text-gray-600 mb-2">Preview gambar baru:</x-atoms.description>
                            <img src="{{ $new_image->temporaryUrl() }}" alt="Preview" class="w-48 h-32 object-cover rounded-lg border border-gray-200">
                        </div>
                    @elseif($image_url)
                        <div class="mt-4">
                            <x-atoms.description size="sm" class="text-gray-600 mb-2">Preview gambar saat ini:</x-atoms.description>
                            <img src="{{ $image_url }}" alt="Preview" class="w-48 h-32 object-cover rounded-lg border border-gray-200"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="w-48 h-32 bg-gray-100 rounded-lg border border-gray-200 flex items-center justify-center" style="display: none;">
                                <div class="text-center">
                                    <x-heroicon-o-photo class="w-8 h-8 text-gray-400 mx-auto mb-1" />
                                    <x-atoms.description size="xs" class="text-gray-400">Error loading image</x-atoms.description>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Contact Section --}}
                <div class="space-y-4 p-6 bg-gray-50 rounded-lg">
                    <x-atoms.title text="Contact Information" size="lg" class="text-gray-800 flex items-center gap-2">
                        <x-heroicon-o-phone class="w-5 h-5 text-lime-600" />
                        Contact Information
                    </x-atoms.title>
                    
                    <x-atoms.description size="sm" class="text-gray-600">
                        Kelola maksimal 2 informasi kontak yang akan ditampilkan di halaman tentang sekolah. Isi hanya yang diperlukan.
                    </x-atoms.description>
                    
                    <div class="space-y-4">
                        {{-- Contact 1 --}}
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <x-atoms.description size="sm" class="text-gray-700 font-medium mb-3">
                                Kontak Pertama:
                            </x-atoms.description>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                                <div>
                                    <x-atoms.label for="contact_1_icon">Icon</x-atoms.label>
                                    <select wire:model="contact_1_icon" id="contact_1_icon" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-lime-500">
                                        <option value="MapPinIcon">📍 Alamat</option>
                                        <option value="PhoneIcon">📞 Telepon</option>
                                        <option value="EnvelopeIcon">✉️ Email</option>
                                        <option value="GlobeAltIcon">🌐 Website</option>
                                        <option value="AcademicCapIcon">🎓 Program</option>
                                        <option value="TrophyIcon">🏆 Prestasi</option>
                                    </select>
                                    @error('contact_1_icon')
                                        <x-atoms.description size="xs" class="text-red-500 mt-1">{{ $message }}</x-atoms.description>
                                    @enderror
                                </div>
                                <div class="md:col-span-3">
                                    <x-atoms.label for="contact_1_text">Informasi Kontak (Opsional)</x-atoms.label>
                                    <x-atoms.input wire:model="contact_1_text" id="contact_1_text" placeholder="Contoh: Jl. Pendidikan No. 123, Jakarta Selatan" className="w-full" />
                                    @error('contact_1_text')
                                        <x-atoms.description size="xs" class="text-red-500 mt-1">{{ $message }}</x-atoms.description>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Contact 2 --}}
                        <div class="bg-white p-4 rounded-lg border border-gray-200">
                            <x-atoms.description size="sm" class="text-gray-700 font-medium mb-3">
                                Kontak Kedua:
                            </x-atoms.description>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                                <div>
                                    <x-atoms.label for="contact_2_icon">Icon</x-atoms.label>
                                    <select wire:model="contact_2_icon" id="contact_2_icon" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-lime-500">
                                        <option value="MapPinIcon">📍 Alamat</option>
                                        <option value="PhoneIcon">📞 Telepon</option>
                                        <option value="EnvelopeIcon">✉️ Email</option>
                                        <option value="GlobeAltIcon">🌐 Website</option>
                                        <option value="AcademicCapIcon">🎓 Program</option>
                                        <option value="TrophyIcon">🏆 Prestasi</option>
                                    </select>
                                    @error('contact_2_icon')
                                        <x-atoms.description size="xs" class="text-red-500 mt-1">{{ $message }}</x-atoms.description>
                                    @enderror
                                </div>
                                <div class="md:col-span-3">
                                    <x-atoms.label for="contact_2_text">Informasi Kontak (Opsional)</x-atoms.label>
                                    <x-atoms.input wire:model="contact_2_text" id="contact_2_text" placeholder="Contoh: (021) 1234-5678" className="w-full" />
                                    @error('contact_2_text')
                                        <x-atoms.description size="xs" class="text-red-500 mt-1">{{ $message }}</x-atoms.description>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Status Section --}}
                <div class="space-y-4 p-6 bg-gray-50 rounded-lg">
                    <x-atoms.title text="Status" size="lg" class="text-gray-800 flex items-center gap-2">
                        <x-heroicon-o-cog-6-tooth class="w-5 h-5 text-lime-600" />
                        Status
                    </x-atoms.title>
                    <div class="space-y-3">
                        <x-atoms.label>Status Aktif <span class="text-red-500">*</span></x-atoms.label>
                        <div class="flex items-center gap-6">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" wire:model="is_active" value="1" class="text-lime-600 focus:ring-lime-500 border-gray-300">
                                <span class="ml-2 text-sm text-gray-700 flex items-center">
                                    <x-heroicon-o-check-circle class="w-4 h-4 text-lime-600 mr-1" />
                                    Aktif (Ditampilkan di website)
                                </span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" wire:model="is_active" value="0" class="text-lime-600 focus:ring-lime-500 border-gray-300">
                                <span class="ml-2 text-sm text-gray-700 flex items-center">
                                    <x-heroicon-o-x-circle class="w-4 h-4 text-red-600 mr-1" />
                                    Tidak Aktif (Disembunyikan dari website)
                                </span>
                            </label>
                        </div>
                        @error('is_active')
                            <x-atoms.description size="xs" class="text-red-500">{{ $message }}</x-atoms.description>
                        @enderror
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="flex gap-4 pt-6 border-t border-gray-200">
                    <x-atoms.button 
                        type="submit" 
                        variant="primary" 
                        theme="dark" 
                        heroicon="check" 
                        :isLoading="$isSaving"
                        loadingText="Menyimpan..."
                        class="bg-lime-600 hover:bg-lime-700 flex-1"
                    >
                        Simpan Perubahan
                    </x-atoms.button>
                    
                    <x-atoms.button 
                        type="button" 
                        wire:click="loadData" 
                        variant="outline" 
                        theme="dark" 
                        heroicon="arrow-path"
                        class="text-gray-600 border-gray-600 hover:bg-gray-600 hover:text-white"
                    >
                        Batal
                    </x-atoms.button>
                </div>
            </form>
        </x-atoms.card>
    @endif

    {{-- Loading Overlay --}}
    <div wire:loading wire:target="save,resetToDefault,loadData" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 shadow-xl">
            <div class="flex items-center gap-3">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-lime-600"></div>
                <span class="text-gray-700">Memproses...</span>
            </div>
        </div>
    </div>
</div>