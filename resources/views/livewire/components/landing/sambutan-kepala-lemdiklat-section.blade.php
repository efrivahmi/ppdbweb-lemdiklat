<section class="relative" x-data>
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
                <div class="aspect-[3/4] bg-gray-200 rounded-2xl"></div>
            </div>
        </div>
    </x-atoms.card>
    @else
    @if($errorMessage)
    <x-atoms.card>
        <div class="text-center flex flex-col justify-center py-8">
            <div class="mb-4">
                <x-heroicon-o-exclamation-triangle class="w-12 h-12 text-red-500 mx-auto" />
            </div>
            <x-atoms.title text="Terjadi Kesalahan" size="lg" class="text-red-600 mb-2" align="center" />
            <x-atoms.description class="text-red-500 mb-4">
                {{ $errorMessage }}
            </x-atoms.description>
            <x-atoms.button
                variant="outline"
                theme="dark"
                wire:click="refreshData"
                heroicon="arrow-path">
                Muat Ulang
            </x-atoms.button>
        </div>
    </x-atoms.card>
    @else
    <x-atoms.card>
        <div class="grid lg:grid-cols-2 gap-12">
            {{-- Left Column: Greeting Content --}}
            <div class="relative space-y-6 order-1 lg:order-1" x-data>
                <div class="space-y-3">
                    @if(isset($greetingData['badge']))
                    <x-atoms.badge
                        :text="$greetingData['badge']['text'] ?? 'Sambutan'"
                        :variant="$greetingData['badge']['variant'] ?? 'indigo'"
                        :size="$greetingData['badge']['size'] ?? 'md'" />
                    @endif

                    @if(isset($greetingData['title']))
                    <x-atoms.title
                        :text="$greetingData['title']['text'] ?? 'Sambutan Kepala Lemdiklat'"
                        :highlight="$greetingData['title']['highlight'] ?? ''"
                        :size="$greetingData['title']['size'] ?? '3xl'"
                        :className="$greetingData['title']['className'] ?? 'lg:text-5xl'" />
                    @endif
                </div>

                @if(isset($greetingData['greeting']['opening']))
                <div class="italic text-gray-700 text-lg font-medium">
                    {{ $greetingData['greeting']['opening'] }}
                </div>
                @endif

                @if(isset($greetingData['greeting']['paragraphs']) && is_array($greetingData['greeting']['paragraphs']))
                <div class="space-y-4 text-gray-600">
                    @foreach($greetingData['greeting']['paragraphs'] as $paragraph)
                    <x-atoms.description
                        size="sm"
                        class="lg:text-base text-justify leading-relaxed">
                        {{ $paragraph }}
                    </x-atoms.description>
                    @endforeach
                </div>
                @endif

                @if(isset($greetingData['greeting']['closing']))
                <div class="text-gray-700 font-medium text-lg">
                    {{ $greetingData['greeting']['closing'] }}
                </div>
                @endif



                @if(isset($greetingData['principal']['signature']))
                <div class="flex justify-end mt-6">
                    <div class="text-right">
                        <img
                            src="{{ $greetingData['principal']['signature'] }}"
                            alt="Tanda Tangan"
                            class="h-16 mb-2 ml-auto" />
                        <x-atoms.description size="sm" class="font-medium">
                            {{ $greetingData['principal']['name'] ?? '' }}
                        </x-atoms.description>
                        <x-atoms.description size="xs" color="gray-500">
                            {{ $greetingData['principal']['title'] ?? '' }}
                        </x-atoms.description>
                    </div>
                </div>
                @endif
            </div>

            {{-- Right Column: Principal Photo --}}
            <div class="relative order-2 lg:order-2" x-data>
                @if(isset($greetingData['principal']))
                <div class="relative">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                        <div class="aspect-[4/4] rounded-2xl overflow-hidden bg-gradient-to-br from-indigo-50 to-blue-50">
                            <img
                                src="{{ $greetingData['principal']['image'] ?? 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80' }}"
                                alt="{{ $greetingData['principal']['name'] ?? 'Kepala Lemdiklat' }}"
                                class="w-full h-full object-cover"
                                onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80';" />
                        </div>

                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/90 via-black/60 to-transparent p-6">
                            <div class="text-white">
                                <x-atoms.title
                                    :text="$greetingData['principal']['name'] ?? 'Kepala Lemdiklat'"
                                    size="lg"
                                    color="white"
                                    class="mb-2" />
                                <x-atoms.description
                                    size="sm"
                                    color="indigo-200"
                                    class="flex items-center gap-2">
                                    <x-heroicon-o-academic-cap class="w-5 h-5" />
                                    {{ $greetingData['principal']['title'] ?? 'Kepala Lemdiklat' }}
                                </x-atoms.description>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if(isset($greetingData['quote']))
                <div class="bg-gradient-to-r from-indigo-50 to-blue-50 border-l-4 border-indigo-600 rounded-r-xl p-6 mt-6">
                    <div class="flex items-start gap-3">
                        <x-heroicon-o-chat-bubble-left-right class="w-6 h-6 text-indigo-600 flex-shrink-0 mt-1" />
                        <div>
                            <p class="text-gray-800 italic text-lg mb-2 leading-relaxed">
                                "{{ $greetingData['quote']['text'] ?? '' }}"
                            </p>
                            <p class="text-indigo-700 font-medium text-sm">
                                — {{ $greetingData['quote']['author'] ?? '' }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

    </x-atoms.card>
    @endif
    @endif
</section>