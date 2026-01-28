<div>
    <x-atoms.breadcrumb currentPath="Footer" />
    
    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif
    
    <x-atoms.card className="mt-3">
        <div class="flex justify-between items-center mb-6">
            <x-atoms.title 
                text="Footer Website" 
                size="xl" 
                class="text-gray-900"
            />
            <x-atoms.button
                wire:click="edit"
                variant="primary"
                theme="dark"
                heroicon="pencil"
                class="bg-lime-600 hover:bg-lime-700"
            >
                {{ $footer ? 'Edit Footer' : 'Buat Footer' }}
            </x-atoms.button>
        </div>

        @if($footer)
            <div class="space-y-6">
                {{-- Informasi Dasar --}}
                <x-atoms.card className="bg-gray-50" padding="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <x-heroicon-o-information-circle class="w-5 h-5 text-lime-600 mr-2" />
                            <x-atoms.title 
                                text="Informasi Dasar" 
                                size="lg" 
                                class="text-gray-900"
                            />
                        </div>
                        <x-atoms.badge 
                            :text="$footer->is_active ? 'Aktif' : 'Nonaktif'"
                            :variant="$footer->is_active ? 'emerald' : 'danger'"
                        />
                    </div>
                    <div class="space-y-4">
                        <div>
                            <x-atoms.label>Judul Situs</x-atoms.label>
                            <x-atoms.description class="text-gray-700 font-medium">
                                {{ $footer->site_title }}
                            </x-atoms.description>
                        </div>
                        <div>
                            <x-atoms.label>Deskripsi Situs</x-atoms.label>
                            <x-atoms.description class="text-gray-700 leading-relaxed">
                                {{ $footer->site_description }}
                            </x-atoms.description>
                        </div>
                        <div>
                            <x-atoms.label>Copyright</x-atoms.label>
                            <x-atoms.description class="text-gray-700">
                                {{ $footer->formatted_copyright }}
                            </x-atoms.description>
                        </div>
                    </div>
                </x-atoms.card>

                {{-- Social Media --}}
                <x-atoms.card className="bg-gray-50" padding="p-6">
                    <div class="flex items-center mb-4">
                        <x-heroicon-o-share class="w-5 h-5 text-lime-600 mr-2" />
                        <x-atoms.title 
                            text="Media Sosial" 
                            size="lg" 
                            class="text-gray-900"
                        />
                    </div>
                    @if(count($footer->social_icons) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach($footer->social_icons as $social)
                                <div class="flex items-center gap-3 p-3 bg-white rounded-lg border">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        @switch($social['icon'])
                                            @case('twitter')
                                                <x-heroicon-o-hashtag class="w-6 h-6 text-blue-600" />
                                                @break
                                            @case('instagram')
                                                <x-heroicon-o-camera class="w-6 h-6 text-pink-600" />
                                                @break
                                            @case('youtube')
                                                <x-heroicon-o-play class="w-6 h-6 text-red-600" />
                                                @break
                                            @case('facebook')
                                                <x-heroicon-o-globe-alt class="w-6 h-6 text-blue-600" />
                                                @break
                                            @default
                                                <x-heroicon-o-link class="w-6 h-6 text-gray-600" />
                                        @endswitch
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <x-atoms.description size="sm" class="text-gray-500 mb-1">
                                            {{ $social['label'] }}
                                        </x-atoms.description>
                                        <x-atoms.description size="sm" class="text-gray-700 truncate">
                                            {{ $social['href'] }}
                                        </x-atoms.description>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <x-atoms.description class="text-gray-500 italic">
                            Belum ada media sosial yang dikonfigurasi
                        </x-atoms.description>
                    @endif
                </x-atoms.card>

                {{-- Footer Links --}}
                <x-atoms.card className="bg-gray-50" padding="p-6">
                    <div class="flex items-center mb-4">
                        <x-heroicon-o-link class="w-5 h-5 text-lime-600 mr-2" />
                        <x-atoms.title 
                            text="Link Footer" 
                            size="lg" 
                            class="text-gray-900"
                        />
                    </div>
                    @if(count($footer->footer_links) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach($footer->footer_links as $section)
                                <div class="bg-white rounded-lg border p-4">
                                    <x-atoms.title 
                                        :text="$section['title']"
                                        size="md" 
                                        class="text-gray-900 mb-3"
                                    />
                                    <ul class="space-y-2">
                                        @foreach($section['links'] as $link)
                                            <li class="flex items-center justify-between">
                                                <span class="text-sm text-gray-700">{{ $link['text'] }}</span>
                                                <span class="text-xs text-gray-500">{{ $link['href'] }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <x-atoms.description class="text-gray-500 italic">
                            Belum ada link footer yang dikonfigurasi
                        </x-atoms.description>
                    @endif
                </x-atoms.card>

                {{-- Legal Links --}}
                <x-atoms.card className="bg-gray-50" padding="p-6">
                    <div class="flex items-center mb-4">
                        <x-heroicon-o-document-text class="w-5 h-5 text-lime-600 mr-2" />
                        <x-atoms.title 
                            text="Link Legal" 
                            size="lg" 
                            class="text-gray-900"
                        />
                    </div>
                    @if(count($footer->legal_links) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($footer->legal_links as $legal)
                                <div class="flex items-center justify-between p-3 bg-white rounded-lg border">
                                    <span class="text-sm text-gray-700 font-medium">{{ $legal['text'] }}</span>
                                    <span class="text-xs text-gray-500">{{ $legal['href'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <x-atoms.description class="text-gray-500 italic">
                            Belum ada link legal yang dikonfigurasi
                        </x-atoms.description>
                    @endif
                </x-atoms.card>

                {{-- Timestamp Info --}}
                <div class="flex items-center justify-between text-sm text-gray-500 pt-4 border-t border-gray-200">
                    <div class="flex items-center gap-4">
                        <span class="flex items-center">
                            <x-heroicon-o-calendar class="w-4 h-4 mr-1" />
                            Dibuat: {{ $footer->created_at->format('d M Y H:i') }}
                        </span>
                        @if($footer->updated_at != $footer->created_at)
                            <span class="flex items-center">
                                <x-heroicon-o-arrow-path class="w-4 h-4 mr-1" />
                                Diperbarui: {{ $footer->updated_at->format('d M Y H:i') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <x-heroicon-o-bars-3-bottom-left class="w-12 h-12 text-gray-400" />
                </div>
                <x-atoms.title 
                    text="Belum Ada Footer" 
                    size="lg" 
                    class="text-gray-900 mb-2"
                />
                <x-atoms.description class="text-gray-600 mb-6">
                    Mulai dengan membuat footer untuk ditampilkan di halaman website
                </x-atoms.description>
                <x-atoms.button
                    wire:click="edit"
                    variant="primary"
                    theme="dark"
                    size="lg"
                    heroicon="plus"
                    class="bg-lime-600 hover:bg-lime-700"
                >
                    Buat Footer
                </x-atoms.button>
            </div>
        @endif
    </x-atoms.card>

    {{-- Modal Edit/Create --}}
    <x-atoms.modal 
        name="footer-modal" 
        maxWidth="5xl"
        :closeable="true"
    >
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <x-atoms.title 
                :text="$footer ? 'Edit Footer' : 'Buat Footer'"
                size="lg" 
                class="text-gray-900"
            />
        </div>

        <div class="p-6 max-h-[80vh] overflow-y-auto">
            <form wire:submit.prevent="save" class="space-y-8">
                {{-- Informasi Dasar --}}
                <div class="space-y-4">
                    <x-atoms.title text="Informasi Dasar" size="md" class="text-gray-900" />
                    
                    <x-molecules.input-field
                        label="Judul Situs"
                        name="site_title"
                        placeholder="Nama institusi/sekolah"
                        wire:model="site_title"
                        :error="$errors->first('site_title')"
                        required
                    />

                    <x-molecules.textarea-field
                        label="Deskripsi Situs"
                        name="site_description"
                        placeholder="Deskripsi singkat tentang institusi"
                        :rows="3"
                        wire:model="site_description"
                        :error="$errors->first('site_description')"
                        required
                    />

                    <x-molecules.input-field
                        label="Copyright Text"
                        name="copyright_text"
                        placeholder="© {year} Nama Institusi. All rights reserved."
                        wire:model="copyright_text"
                        :error="$errors->first('copyright_text')"
                        required
                    />
                    <x-atoms.description size="xs" class="text-gray-500">
                        Gunakan {year} untuk tahun otomatis
                    </x-atoms.description>

                    <div class="flex items-center gap-3">
                        <input 
                            type="checkbox" 
                            id="is_active" 
                            wire:model="is_active"
                            class="w-4 h-4 text-lime-600 bg-gray-100 border-gray-300 rounded focus:ring-lime-500"
                        >
                        <x-atoms.label for="is_active" className="mb-0">
                            Footer Aktif
                        </x-atoms.label>
                    </div>
                </div>

                {{-- Social Media --}}
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <x-atoms.title text="Media Sosial" size="md" class="text-gray-900" />
                        <x-atoms.button
                            wire:click="addSocialIcon"
                            variant="outline"
                            theme="dark"
                            size="sm"
                            heroicon="plus"
                        >
                            Tambah
                        </x-atoms.button>
                    </div>

                    @foreach($social_icons as $index => $social)
                        <div class="p-4 border border-gray-200 rounded-lg space-y-3">
                            <div class="flex items-center justify-between">
                                <x-atoms.title text="Social Media #{{ $index + 1 }}" size="sm" />
                                @if(count($social_icons) > 1)
                                    <x-atoms.button
                                        wire:click="removeSocialIcon({{ $index }})"
                                        variant="danger"
                                        size="sm"
                                        heroicon="trash"
                                    />
                                @endif
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                <x-molecules.select-field
                                    label="Icon"
                                    name="social_icons.{{ $index }}.icon"
                                    wire:model="social_icons.{{ $index }}.icon"
                                    :options="[
                                        ['value' => 'twitter', 'label' => 'Twitter'],
                                        ['value' => 'instagram', 'label' => 'Instagram'],
                                        ['value' => 'youtube', 'label' => 'YouTube'],
                                        ['value' => 'facebook', 'label' => 'Facebook'],
                                        ['value' => 'linkedin', 'label' => 'LinkedIn'],
                                        ['value' => 'tiktok', 'label' => 'TikTok'],
                                    ]"
                                    :error="$errors->first('social_icons.' . $index . '.icon')"
                                />
                                <x-molecules.input-field
                                    label="URL"
                                    name="social_icons.{{ $index }}.href"
                                    placeholder="https://..."
                                    wire:model="social_icons.{{ $index }}.href"
                                    :error="$errors->first('social_icons.' . $index . '.href')"
                                />
                                <x-molecules.input-field
                                    label="Label"
                                    name="social_icons.{{ $index }}.label"
                                    placeholder="Nama tampilan"
                                    wire:model="social_icons.{{ $index }}.label"
                                    :error="$errors->first('social_icons.' . $index . '.label')"
                                />
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Footer Links --}}
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <x-atoms.title text="Link Footer" size="md" class="text-gray-900" />
                        <x-atoms.button
                            wire:click="addFooterSection"
                            variant="outline"
                            theme="dark"
                            size="sm"
                            heroicon="plus"
                        >
                            Tambah Section
                        </x-atoms.button>
                    </div>

                    @foreach($footer_links as $sectionIndex => $section)
                        <div class="p-4 border border-gray-200 rounded-lg space-y-4">
                            <div class="flex items-center justify-between">
                                <x-atoms.title text="Section #{{ $sectionIndex + 1 }}" size="sm" />
                                @if(count($footer_links) > 1)
                                    <x-atoms.button
                                        wire:click="removeFooterSection({{ $sectionIndex }})"
                                        variant="danger"
                                        size="sm"
                                        heroicon="trash"
                                    />
                                @endif
                            </div>
                            
                            <x-molecules.input-field
                                label="Judul Section"
                                name="footer_links.{{ $sectionIndex }}.title"
                                placeholder="Contoh: Informasi"
                                wire:model="footer_links.{{ $sectionIndex }}.title"
                                :error="$errors->first('footer_links.' . $sectionIndex . '.title')"
                            />

                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <x-atoms.label>Links</x-atoms.label>
                                    <x-atoms.button
                                        wire:click="addFooterLink({{ $sectionIndex }})"
                                        variant="ghost"
                                        theme="dark"
                                        size="sm"
                                        heroicon="plus"
                                    >
                                        Tambah Link
                                    </x-atoms.button>
                                </div>

                                @foreach($section['links'] as $linkIndex => $link)
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 p-3 bg-gray-50 rounded">
                                        <x-molecules.input-field
                                            label="Teks"
                                            name="footer_links.{{ $sectionIndex }}.links.{{ $linkIndex }}.text"
                                            placeholder="Nama link"
                                            wire:model="footer_links.{{ $sectionIndex }}.links.{{ $linkIndex }}.text"
                                            :error="$errors->first('footer_links.' . $sectionIndex . '.links.' . $linkIndex . '.text')"
                                        />
                                        <div class="flex gap-2">
                                            <x-molecules.input-field
                                                label="URL"
                                                name="footer_links.{{ $sectionIndex }}.links.{{ $linkIndex }}.href"
                                                placeholder="/path atau https://..."
                                                wire:model="footer_links.{{ $sectionIndex }}.links.{{ $linkIndex }}.href"
                                                :error="$errors->first('footer_links.' . $sectionIndex . '.links.' . $linkIndex . '.href')"
                                                className="flex-1"
                                            />
                                            @if(count($section['links']) > 1)
                                                <div class="flex items-end">
                                                    <x-atoms.button
                                                        wire:click="removeFooterLink({{ $sectionIndex }}, {{ $linkIndex }})"
                                                        variant="danger"
                                                        size="sm"
                                                        heroicon="trash"
                                                        class="mb-1"
                                                    />
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Legal Links --}}
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <x-atoms.title text="Link Legal" size="md" class="text-gray-900" />
                        <x-atoms.button
                            wire:click="addLegalLink"
                            variant="outline"
                            theme="dark"
                            size="sm"
                            heroicon="plus"
                        >
                            Tambah
                        </x-atoms.button>
                    </div>

                    @foreach($legal_links as $index => $legal)
                        <div class="p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-between mb-3">
                                <x-atoms.title text="Legal Link #{{ $index + 1 }}" size="sm" />
                                @if(count($legal_links) > 1)
                                    <x-atoms.button
                                        wire:click="removeLegalLink({{ $index }})"
                                        variant="danger"
                                        size="sm"
                                        heroicon="trash"
                                    />
                                @endif
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <x-molecules.input-field
                                    label="Teks"
                                    name="legal_links.{{ $index }}.text"
                                    placeholder="Kebijakan Privasi"
                                    wire:model="legal_links.{{ $index }}.text"
                                    :error="$errors->first('legal_links.' . $index . '.text')"
                                />
                                <x-molecules.input-field
                                    label="URL"
                                    name="legal_links.{{ $index }}.href"
                                    placeholder="/privacy"
                                    wire:model="legal_links.{{ $index }}.href"
                                    :error="$errors->first('legal_links.' . $index . '.href')"
                                />
                            </div>
                        </div>
                    @endforeach
                </div>
            </form>
        </div>

        <div class="flex gap-3 p-6 border-t border-gray-200">
            <x-atoms.button
                wire:click="save"
                wire:loading.attr="disabled"
                wire:loading.class="opacity-50 cursor-not-allowed"
                variant="primary"
                theme="dark"
                heroicon="check"
                isFullWidth
                class="bg-lime-600 hover:bg-lime-700"
            >
                <span wire:loading.remove>{{ $footer ? 'Update' : 'Simpan' }}</span>
                <span wire:loading>Processing...</span>
            </x-atoms.button>
            <x-atoms.button
                wire:click="cancel"
                variant="secondary"
                theme="dark"
                heroicon="x-mark"
                isFullWidth
                class="bg-gray-500 hover:bg-gray-600"
            >
                Batal
            </x-atoms.button>
        </div>
    </x-atoms.modal>
</div>