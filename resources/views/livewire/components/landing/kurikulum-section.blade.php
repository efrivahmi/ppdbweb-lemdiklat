<section class="relative bg-lime-500 py-12 rounded-3xl">
    @if($isLoading)
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="animate-pulse">
            <div class="grid lg:grid-cols-2 gap-8">
                <div class="aspect-video bg-lime-600 rounded-2xl"></div>
                <div class="space-y-6">
                    <div class="h-6 bg-lime-600 rounded w-24 mb-3"></div>
                    <div class="h-8 bg-lime-600 rounded w-3/4 mb-4"></div>
                    <div class="space-y-2">
                        <div class="h-4 bg-lime-600 rounded"></div>
                        <div class="h-4 bg-lime-600 rounded w-5/6"></div>
                        <div class="h-4 bg-lime-600 rounded w-4/6"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    @if($errorMessage)
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center py-8">
            <div class="mb-4">
                <x-heroicon-o-exclamation-triangle class="w-12 h-12 text-white mx-auto" />
            </div>
            <x-atoms.title text="Terjadi Kesalahan" size="lg" class="text-white mb-2" />
            <x-atoms.description class="text-lime-100 mb-4">
                {{ $errorMessage }}
            </x-atoms.description>
        </div>
    </div>
    @else
    <div class="max-w-7xl mx-auto px-5 sm:px-7 space-y-6">
        <div class="grid lg:grid-cols-2 gap-8">

            <div class="space-y-2 text-left text-white">
                <div class="space-y-4">
                    @if($kurikulum?->badge_text)
                    <div class="inline-block bg-white/20 backdrop-blur-sm rounded-full px-4 py-2">
                        <span class="text-white text-sm font-medium">
                            {{ $kurikulum->badge_text }}
                        </span>
                    </div>
                    @endif

                    <x-atoms.title
                        :text="$kurikulum->title_text ?? 'Kurikulum Sekolah'"
                        :size="$kurikulum->title_size ?? '3xl'"
                        class="text-white leading-tight" />
                </div>

                @if($kurikulum?->descriptions)
                <div class="space-y-4">
                    @php
                    $descriptions = is_array($kurikulum->descriptions)
                    ? $kurikulum->descriptions
                    : [$kurikulum->descriptions];
                    @endphp
                    @foreach($descriptions as $description)
                    <p class=" text-base sm:text-lg leading-relaxed">
                        {{ $description }}
                    </p>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="relative order-1 lg:order-none">
                @if($kurikulum?->image_url)
                <div class="relative rounded-2xl overflow-hidden">
                    <div class="h-120 rounded-2xl overflow-hidden">
                        <img
                            src="{{ $kurikulum->image_url }}"
                            alt="{{ $kurikulum->image_title ?? 'Ilustrasi Kurikulum' }}"
                            class="w-full h-full object-cover" />
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4 sm:p-6">
                        <div class="text-white">
                            <x-atoms.title
                                :text="$kurikulum->image_title ?? 'Ilustrasi Kurikulum'"
                                size="sm"
                                class="text-white mb-2" />
                            <x-atoms.description size="xs" class="text-lime-100">
                                {{ $kurikulum->image_description ?? 'Representasi kurikulum modern dan adaptif' }}
                            </x-atoms.description>
                        </div>
                    </div>
                </div>
                @else
                <div class="aspect-[16/10] sm:aspect-video bg-lime-600 rounded-2xl flex items-center justify-center">
                    <x-heroicon-o-academic-cap class="w-16 h-16 text-white opacity-50" />
                </div>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 ">
            @foreach (range(1, 4) as $i)
            @php
            $photoUrl = $kurikulum?->{'photo_'.$i.'_url'};
            $photoTitle = $kurikulum?->{'photo_'.$i.'_title'};
            @endphp
            @if($photoUrl)
            <div class="rounded-2xl overflow-hidden shadow-lg bg-white backdrop-blur-sm p-2.5">
                <img src="{{ $photoUrl }}" alt="{{ $photoTitle }}" class="w-full h-40 sm:h-48 object-cover rounded-xl">
                <p class="text-center mt-3 font-medium text-sm sm:text-base">
                    {{ $photoTitle }}
                </p>
            </div>
            @endif
            @endforeach
        </div>
    </div>
    @endif
    @endif
</section>