<div>
    @if($show)
    <div class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-0">
        <!-- Backdrop -->
        <div class="fixed inset-0 transition-opacity duration-300 bg-slate-900/40 backdrop-blur-sm" wire:click="close"></div>

        <!-- Modal Content -->
        <div class="relative w-full max-w-md overflow-hidden transition-all duration-300 transform bg-white shadow-2xl rounded-2xl ring-1 ring-slate-900/5 sm:my-8" x-data="{}" x-init="setTimeout(() => { $el.classList.remove('scale-95', 'opacity-0'); }, 100)" class="scale-95 opacity-0 transition-all duration-300">
            
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <h3 class="text-lg font-bold text-slate-800">
                    <i class="mr-2 text-indigo-500 ri-chat-smile-3-line"></i>Beri Kami Penilaian
                </h3>
                <button wire:click="close" class="text-slate-400 hover:text-rose-500 transition-colors">
                    <i class="ri-close-large-line"></i>
                </button>
            </div>

            @if(!$submitted)
            <!-- Form -->
            <div class="p-6">
                <p class="mb-6 text-sm text-center text-slate-500">
                    Bagaimana pengalaman Anda mendaftar hari ini?
                </p>

                <!-- Emoji Rating System -->
                <div class="flex justify-between max-w-xs mx-auto mb-8">
                    @php
                        $emojis = [
                            1 => ['icon' => 'ri-emotion-sad-line', 'color' => 'text-rose-500', 'bg' => 'peer-checked:bg-rose-50 peer-checked:text-rose-600 peer-checked:border-rose-200'],
                            2 => ['icon' => 'ri-emotion-unhappy-line', 'color' => 'text-orange-500', 'bg' => 'peer-checked:bg-orange-50 peer-checked:text-orange-600 peer-checked:border-orange-200'],
                            3 => ['icon' => 'ri-emotion-normal-line', 'color' => 'text-amber-500', 'bg' => 'peer-checked:bg-amber-50 peer-checked:text-amber-600 peer-checked:border-amber-200'],
                            4 => ['icon' => 'ri-emotion-smile-line', 'color' => 'text-lime-500', 'bg' => 'peer-checked:bg-lime-50 peer-checked:text-lime-600 peer-checked:border-lime-200'],
                            5 => ['icon' => 'ri-emotion-happy-line', 'color' => 'text-emerald-500', 'bg' => 'peer-checked:bg-emerald-50 peer-checked:text-emerald-600 peer-checked:border-emerald-200'],
                        ];
                    @endphp

                    @foreach($emojis as $value => $emoji)
                    <label class="relative cursor-pointer group">
                        <input type="radio" wire:model="rating" value="{{ $value }}" class="sr-only peer">
                        <div class="flex items-center justify-center w-12 h-12 transition-all duration-300 border-2 border-transparent rounded-full hover:scale-110 peer-checked:scale-110 {{ $emoji['bg'] }} hover:bg-slate-50">
                            <i class="text-3xl {{ $emoji['icon'] }} {{ $emoji['color'] }} opacity-50 group-hover:opacity-100 peer-checked:opacity-100 transition-opacity"></i>
                        </div>
                    </label>
                    @endforeach
                </div>
                
                @error('rating')
                    <p class="mb-4 text-xs text-center text-rose-500">{{ $message }}</p>
                @enderror

                <!-- Feedback Text -->
                <div class="mb-6">
                    <label class="block mb-2 text-xs font-semibold uppercase tracking-wider text-slate-500">Pesan (Opsional)</label>
                    <textarea wire:model="message" rows="3" class="w-full px-4 py-3 text-sm transition-colors border-gray-200 rounded-xl bg-slate-50 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500" placeholder="Ceritakan pengalaman atau saran Anda..."></textarea>
                </div>

                <!-- Submit Button -->
                <button wire:click="submit" class="w-full py-3 text-sm font-bold text-white transition-all shadow-lg rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 hover:shadow-indigo-500/30">
                    Kirim Penilaian
                </button>
            </div>
            @else
            <!-- Success State -->
            <div class="p-8 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 mb-6 bg-emerald-100 rounded-full">
                    <i class="text-4xl text-emerald-500 ri-check-double-line animate-bounce"></i>
                </div>
                <h4 class="mb-2 text-xl font-bold text-slate-800">Terima Kasih!</h4>
                <p class="mb-6 text-sm text-slate-500">Ulasan Anda sangat berarti untuk meningkatkan layanan kami.</p>
                <button wire:click="close" class="px-6 py-2.5 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                    Tutup
                </button>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>
