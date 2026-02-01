<section class="relative" x-data>
    @if($isLoading)
    <x-atoms.card>
        <div class="grid lg:grid-cols-2 gap-6 md:gap-12">
            <div class="space-y-4 md:space-y-6">
                <div class="animate-pulse">
                    <div class="h-5 md:h-6 bg-gray-200 rounded w-20 md:w-24 mb-2 md:mb-3"></div>
                    <div class="h-6 md:h-8 bg-gray-200 rounded w-3/4 mb-3 md:mb-4"></div>
                    <div class="space-y-2">
                        <div class="h-3 md:h-4 bg-gray-200 rounded"></div>
                        <div class="h-3 md:h-4 bg-gray-200 rounded w-5/6"></div>
                        <div class="h-3 md:h-4 bg-gray-200 rounded w-4/6"></div>
                    </div>
                </div>
            </div>
            <div class="animate-pulse">
                <div class="h-48 md:h-64 bg-gray-200 rounded-xl md:rounded-2xl"></div>
            </div>
        </div>
    </x-atoms.card>
    @else
    @if($errorMessage)
    <x-atoms.card>
        <div class="text-center flex flex-col justify-center py-6 md:py-8">
            <div class="mb-3 md:mb-4">
                <x-heroicon-o-exclamation-triangle class="w-10 h-10 md:w-12 md:h-12 text-red-500 mx-auto" />
            </div>
            <x-atoms.title 
                text="Terjadi Kesalahan" 
                size="md"
                mdSize="lg"
                class="text-red-600 mb-2" 
            />
            <x-atoms.description class="text-red-500 mb-3 md:mb-4 text-sm md:text-base px-4">
                {{ $errorMessage }}
            </x-atoms.description>
            <x-atoms.button
                variant="outline"
                theme="dark"
                wire:click="refreshData"
                heroicon="arrow-path"
                class="mx-auto">
                Muat Ulang
            </x-atoms.button>
        </div>
    </x-atoms.card>
    @else
    <x-atoms.card className="p-4 md:p-6">
        <div class="grid lg:grid-cols-2 gap-6 md:gap-12">
            <!-- Image Section - Order 2 on mobile, 1 on desktop -->
            <div class="relative order-2 lg:order-1" x-data>
                @if(isset($greetingData['principal']))
                <div class="relative">
                    <div class="relative rounded-xl md:rounded-2xl overflow-hidden shadow-lg md:shadow-2xl">
                        <div class="rounded-xl md:rounded-2xl overflow-hidden bg-gradient-to-br from-indigo-50 to-blue-50 h-64 md:h-96 lg:h-150">
                            <img
                                src="{{ $greetingData['principal']['image'] ?? 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80' }}"
                                alt="{{ $greetingData['principal']['name'] ?? 'Kepala Sekolah' }}"
                                class="w-full h-full object-cover object-center"
                                onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80';" />
                        </div>

                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/90 via-black/60 to-transparent p-4 md:p-6">
                            <div class="text-white">
                                <x-atoms.title
                                    :text="$greetingData['principal']['name'] ?? 'Kepala Sekolah'"
                                    size="md"
                                    mdSize="lg"
                                    color="white"
                                    class="mb-1 md:mb-2" 
                                />
                                <x-atoms.description
                                    size="xs"
                                    color="indigo-200"
                                    class="flex items-center gap-2">
                                    <x-heroicon-o-academic-cap class="w-4 h-4 md:w-5 md:h-5" />
                                    {{ $greetingData['principal']['title'] ?? 'Kepala Sekolah' }}
                                </x-atoms.description>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Quote Section -->
                @if(isset($greetingData['quote']))
                <div class="bg-gradient-to-r from-indigo-50 to-blue-50 border-l-4 border-indigo-600 rounded-r-lg md:rounded-r-xl p-4 md:p-6 mt-4 md:mt-6">
                    <div class="flex items-start gap-2 md:gap-3">
                        <x-heroicon-o-chat-bubble-left-right class="w-5 h-5 md:w-6 md:h-6 text-indigo-600 flex-shrink-0 mt-1" />
                        <div>
                            <p class="text-gray-800 italic text-sm md:text-base lg:text-lg mb-2 leading-relaxed">
                                "{{ $greetingData['quote']['text'] ?? '' }}"
                            </p>
                            <p class="text-indigo-700 font-medium text-xs md:text-sm">
                                — {{ $greetingData['quote']['author'] ?? '' }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Content Section - Order 1 on mobile, 2 on desktop -->
            <div class="relative space-y-4 md:space-y-6 order-1 lg:order-2" x-data>
                <!-- Header -->
                <div class="space-y-2 md:space-y-3">
                    @if(isset($greetingData['badge']))
                    <x-atoms.badge
                        :text="$greetingData['badge']['text'] ?? 'Sambutan'"
                        :variant="$greetingData['badge']['variant'] ?? 'indigo'"
                        size="sm" 
                    />
                    @endif

                    @if(isset($greetingData['title']))
                    <x-atoms.title
                        :text="$greetingData['title']['text'] ?? 'Sambutan Kepala Sekolah'"
                        :highlight="$greetingData['title']['highlight'] ?? ''"
                        size="xl"
                        mdSize="2xl"
                        class="lg:text-5xl leading-tight" 
                    />
                    @endif
                </div>

                <!-- Opening -->
                @if(isset($greetingData['greeting']['opening']))
                <div class="italic text-gray-700 text-sm md:text-base lg:text-lg font-medium">
                    {{ $greetingData['greeting']['opening'] }}
                </div>
                @endif

                <!-- Paragraphs -->
                @if(isset($greetingData['greeting']['paragraphs']) && is_array($greetingData['greeting']['paragraphs']))
                <div class="space-y-3 md:space-y-4 text-gray-600">
                    @foreach($greetingData['greeting']['paragraphs'] as $paragraph)
                    <x-atoms.description
                        size="xs"
                        class="md:text-sm lg:text-base text-justify leading-relaxed">
                        {{ $paragraph }}
                    </x-atoms.description>
                    @endforeach
                </div>
                @endif

                <!-- Closing -->
                @if(isset($greetingData['greeting']['closing']))
                <div class="text-gray-700 font-medium text-sm md:text-base lg:text-lg">
                    {{ $greetingData['greeting']['closing'] }}
                </div>
                @endif

                <!-- Signature -->
                @if(isset($greetingData['principal']['signature']))
                <div class="flex justify-end mt-4 md:mt-6">
                    <div class="text-right">
                        <img
                            src="{{ $greetingData['principal']['signature'] }}"
                            alt="Tanda Tangan"
                            class="h-12 md:h-16 mb-2 ml-auto" 
                        />
                        <x-atoms.description 
                            size="xs"
                            class="md:text-sm font-medium">
                            {{ $greetingData['principal']['name'] ?? '' }}
                        </x-atoms.description>
                        <x-atoms.description 
                            size="xs" 
                            class="text-gray-500">
                            {{ $greetingData['principal']['title'] ?? '' }}
                        </x-atoms.description>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </x-atoms.card>
    @endif
    @endif
</section>