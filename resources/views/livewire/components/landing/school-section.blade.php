<section class="relative" x-data>
    {{-- Loading State --}}
    @if($isLoading)
        <x-atoms.card>
            <div class="grid lg:grid-cols-2 gap-12">
                <div class="space-y-6">
                    <div class="animate-pulse">
                        <div class="h-6 bg-gray-200 rounded w-24 mb-3"></div>
                        <div class="h-8 bg-gray-200 rounded w-3/4 mb-4"></div>
                        <div class="space-y-2">
                            <div class="h-4 bg-gray-200 rounded"></div>
                            <div class="h-4 bg-gray-200 rounded w-5/6"></div>
                            <div class="h-4 bg-gray-200 rounded w-4/6"></div>
                        </div>
                    </div>
                </div>
                <div class="animate-pulse">
                    <div class="aspect-video bg-gray-200 rounded-2xl"></div>
                </div>
            </div>
        </x-atoms.card>
    @else
        {{-- Error State --}}
        @if($errorMessage)
            <x-atoms.card>
                <div class="text-center py-8">
                    <div class="mb-4">
                        <x-heroicon-o-exclamation-triangle class="w-12 h-12 text-red-500 mx-auto" />
                    </div>
                    <x-atoms.title text="Terjadi Kesalahan" size="lg" class="text-red-600 mb-2" />
                    <x-atoms.description class="text-red-500 mb-4">
                        {{ $errorMessage }}
                    </x-atoms.description>
                    <x-atoms.button 
                        variant="outline" 
                        theme="dark" 
                        wire:click="refreshData"
                        heroicon="arrow-path"
                    >
                        Muat Ulang
                    </x-atoms.button>
                </div>
            </x-atoms.card>
        @else
            {{-- Main Content --}}
            <x-atoms.card>
                <div class="grid lg:grid-cols-5 gap-8">
                    {{-- Left Column: Text Content & Contact (2 columns) --}}
                    <div class="lg:col-span-2 space-y-6" x-data>
                        <div class="space-y-3">
                            @if(isset($profileData['badge']))
                                <x-atoms.badge
                                    :text="$profileData['badge']['text'] ?? 'Tentang Kami'"
                                    :variant="$profileData['badge']['variant'] ?? 'emerald'"
                                    :size="$profileData['badge']['size'] ?? 'md'"
                                />
                            @endif

                            @if(isset($profileData['title']))
                                <x-atoms.title
                                    :text="$profileData['title']['text'] ?? 'Profil Sekolah'"
                                    :highlight="$profileData['title']['highlight'] ?? ''"
                                    :size="$profileData['title']['size'] ?? '3xl'"
                                    :className="$profileData['title']['className'] ?? 'lg:text-5xl'"
                                />
                            @endif
                        </div>

                        @if(isset($profileData['descriptions']) && is_array($profileData['descriptions']))
                            <div class="space-y-4 text-gray-600">
                                @foreach($profileData['descriptions'] as $index => $description)
                                    <x-atoms.description
                                        size="sm"
                                        class="lg:text-base"
                                    >
                                        {{ $description }}
                                    </x-atoms.description>
                                @endforeach
                            </div>
                        @endif

                        {{-- Contact di kolom kiri --}}
                        @if(isset($profileData['contact']) && is_array($profileData['contact']))
                            <div class="space-y-3 pt-4">
                                @foreach($profileData['contact'] as $index => $contact)
                                    @php
                                        // Extended icon mapping untuk mendukung icon dari seeder
                                        $contactIconMap = [
                                            'MapPinIcon' => 'map-pin',
                                            'PhoneIcon' => 'phone',
                                            'EnvelopeIcon' => 'envelope',
                                            'GlobeAltIcon' => 'globe-alt',
                                            'AcademicCapIcon' => 'academic-cap',
                                            'TrophyIcon' => 'trophy',
                                        ];
                                        $contactIconName = $contactIconMap[$contact['icon'] ?? ''] ?? 'star';
                                    @endphp

                                    <x-atoms.info-item
                                        :text="$contact['text'] ?? ''"
                                    >
                                        <x-slot name="iconSlot">
                                            <x-dynamic-component
                                                :component="'heroicon-o-' . $contactIconName"
                                                class="w-5 h-5 text-lime-600"
                                            />
                                        </x-slot>
                                    </x-atoms.info-item>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Right Column: Image Besar (3 columns) --}}
                    <div class="lg:col-span-3" x-data>
                        @if(isset($profileData['image']))
                            <div class="relative rounded-2xl overflow-hidden shadow-2xl h-full">
                                <div class="min-h-[400px] sm:min-h-[500px] lg:aspect-auto lg:h-full rounded-2xl overflow-hidden">
                                    <img
                                        src="{{ $profileData['image']['url'] ?? 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80' }}"
                                        alt="{{ $profileData['image']['title'] ?? 'Gedung Sekolah' }}"
                                        class="w-full h-full object-cover opacity-90"
                                        onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80';"
                                    />
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6 lg:p-8">
                                    <div class="text-white">
                                        <x-atoms.title
                                            :text="$profileData['image']['title'] ?? 'Gedung Sekolah'"
                                            size="lg"
                                            color="white"
                                            class="mb-2 text-xl lg:text-2xl"
                                        />
                                        <x-atoms.description
                                            size="sm"
                                            color="sky-200"
                                            class="text-base lg:text-lg"
                                        >
                                            {{ $profileData['image']['description'] ?? 'Fasilitas modern untuk mendukung proses pembelajaran' }}
                                        </x-atoms.description>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Admin Actions (optional, bisa dihilangkan di production) --}}
                @if(config('app.debug') && auth()->check() && auth()->user()->is_admin ?? false)
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <x-atoms.description class="text-xs text-gray-400">
                                Admin Actions (Debug Mode)
                            </x-atoms.description>
                            <div class="flex gap-2">
                                <x-atoms.button
                                    variant="ghost"
                                    size="sm"
                                    wire:click="refreshData"
                                    heroicon="arrow-path"
                                >
                                    Refresh
                                </x-atoms.button>
                            </div>
                        </div>
                    </div>
                @endif
            </x-atoms.card>
        @endif
    @endif
</section>