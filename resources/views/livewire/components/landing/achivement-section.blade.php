@if (count($this->achievements) > 0)
    <section class="space-y-8">
        <div class="flex flex-col md:flex-row justify-between lg:items-end space-y-4">
            <div class="space-y-3">
                <x-atoms.badge :text="$sectionData['badge']['text']" :variant="$sectionData['badge']['variant']" class="inline-block" />
                <x-atoms.title :text="$sectionData['title']['text']" :highlight="$sectionData['title']['highlight']" :size="$sectionData['title']['size']" :className="$sectionData['title']['className']" />
            </div>

            <a href="{{ $sectionData['button']['href'] }}">
                <x-atoms.button :variant="$sectionData['button']['variant']" :theme="$sectionData['button']['theme']" :heroicon="$sectionData['button']['icon']" :iconPosition="$sectionData['button']['iconPosition']"
                    :className="$sectionData['button']['className']">
                    {{ $sectionData['button']['text'] }}
                </x-atoms.button>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @foreach ($this->achievements as $index => $achievement)
                <div wire:key="achievement-{{ $achievement['id'] }}">
                    <x-molecules.achivement-card :achievement="$achievement" :index="$index" buttonText="Lihat Detail"
                        className="h-full" />
                </div>
            @endforeach
        </div>
    </section>
@else
    <section class="text-center py-16">
        <div class="w-24 h-24 mx-auto mb-6 text-gray-300 flex items-center justify-center bg-gray-100 rounded-full">
            <x-heroicon-o-trophy class="w-12 h-12" />
        </div>
        <x-atoms.title text="Belum Ada Prestasi" size="xl" align="center" class="text-gray-500 mb-3" />
        <x-atoms.description size="md" color="gray-400" class="max-w-md mx-auto">
            Prestasi siswa akan ditampilkan di sini setelah data tersedia.
        </x-atoms.description>
    </section>
@endif

@push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('achievement-detail-requested', (event) => {
                const achievement = event.detail || event;
                console.log('Achievement detail requested:', achievement);

                alert(`Viewing details for: ${achievement.title}`);
            });

            Livewire.on('achievements-updated', () => {
                console.log('Achievements list updated');

                setTimeout(() => {
                    const newItems = document.querySelectorAll(
                        '[wire\\:key^="achievement-"]:nth-last-child(-n+3)');
                    if (newItems.length > 0) {
                        newItems[0].scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                }, 100);
            });
        });
    </script>
@endpush
