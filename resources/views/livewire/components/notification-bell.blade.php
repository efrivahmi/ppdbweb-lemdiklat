<div 
    class="relative" 
    x-data="{ 
        open: @entangle('isOpen'),
        init() {
            // Livewire handles the listeners via #[On] attributes
        }
    }"
>
    {{-- Notification Bell Button --}}
    <button 
        wire:click="toggleDropdown"
        class="relative p-2 text-gray-400 hover:text-lime-500 transition-colors duration-200 rounded-lg hover:bg-lime-500/10"
        title="Notifikasi"
    >
        <x-lucide-bell class="w-6 h-6" />
        
        {{-- Unread Badge --}}
        @if($unreadCount > 0)
            <span class="absolute -top-1 -right-1 flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full animate-pulse">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </button>

    {{-- Notification Dropdown --}}
    <div 
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        @click.outside="open = false"
        class="absolute right-0 mt-2 w-80 bg-white border border-gray-200 rounded-xl shadow-2xl overflow-hidden z-50"
    >
        {{-- Header --}}
        <div class="px-4 py-3 bg-gradient-to-r from-lime-500/10 to-green-500/10 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-800">Notifikasi Real-time</h3>
                @if(count($notifications) > 0)
                    <button 
                        wire:click="clearAll"
                        class="text-xs text-gray-500 hover:text-red-500 transition-colors"
                    >
                        Hapus Semua
                    </button>
                @endif
            </div>
        </div>

        {{-- Notifications List --}}
        <div class="max-h-[25rem] overflow-y-auto w-full">
            @forelse($notifications as $notification)
                <div x-data="{ expanded: false }" class="px-4 py-3 border-b border-gray-100 hover:bg-lime-50 transition-colors {{ is_null($notification['read_at']) ? 'bg-blue-50/20' : '' }}">
                    <div class="flex items-start gap-3">
                        {{-- Icon --}}
                        <div @class([
                            'flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center',
                            'bg-lime-100 text-lime-600' => $notification['type'] === 'registration',
                            'bg-green-100 text-green-600' => $notification['type'] === 'payment',
                            'bg-blue-100 text-blue-600' => $notification['type'] === 'status',
                        ])>
                            @if($notification['icon'] === 'user-plus')
                                <x-lucide-user-plus class="w-4 h-4" />
                            @elseif($notification['icon'] === 'check-circle')
                                <x-lucide-check-circle class="w-4 h-4" />
                            @elseif($notification['icon'] === 'x-circle')
                                <x-lucide-x-circle class="w-4 h-4" />
                            @elseif($notification['icon'] === 'clock')
                                <x-lucide-clock class="w-4 h-4" />
                            @else
                                <x-lucide-bell class="w-4 h-4" />
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold {{ is_null($notification['read_at']) ? 'text-gray-900' : 'text-lime-700' }}">{{ $notification['title'] }}</p>
                            
                            <div class="mt-1 text-sm text-gray-700 leading-snug break-words relative">
                                <p :class="expanded ? '' : 'line-clamp-2'">{{ $notification['message'] }}</p>
                                @if(strlen($notification['message']) > 90)
                                    <button @click.prevent="expanded = !expanded" class="text-xs text-blue-600 hover:text-blue-800 font-medium inline-block mt-1 focus:outline-none z-10 relative">
                                        <span x-show="!expanded">Selengkapnya</span>
                                        <span x-show="expanded" x-cloak>Tutup</span>
                                    </button>
                                @endif
                            </div>

                            {{-- Action Button --}}
                            @if(!empty($notification['action_url']))
                                <a href="{{ $notification['action_url'] }}" class="inline-block mt-2 px-3 py-1 bg-lime-100 text-lime-700 hover:bg-lime-200 text-xs font-medium rounded-md transition-colors w-max">
                                    Lihat Detail &rarr;
                                </a>
                            @endif

                            <p class="text-[11px] text-gray-400 mt-1">
                                {{ \Carbon\Carbon::parse($notification['timestamp'])->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-4 py-8 text-center">
                    <x-lucide-bell-off class="w-12 h-12 mx-auto text-gray-300 mb-3" />
                    <p class="text-sm text-gray-500">Tidak ada notifikasi</p>
                    <p class="text-xs text-gray-400 mt-1">Notifikasi akan muncul secara real-time</p>
                </div>
            @endforelse
        </div>

        {{-- Footer with Live Indicator & See All Link --}}
        <div class="bg-gray-50 border-t border-gray-100 flex flex-col">
            @if(auth()->user()->isSiswa())
            <a href="{{ route('siswa.notifications') }}" class="block px-4 py-3 text-center text-sm text-lime-600 hover:text-lime-700 hover:bg-lime-50 font-medium transition-colors cursor-pointer border-b border-gray-100">
                Lihat Semua Notifikasi
            </a>
            @endif
            <div class="px-4 py-2 flex items-center justify-center gap-2">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-lime-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-lime-500"></span>
                </span>
                <p class="text-xs text-gray-500">Live - Pusher Connected</p>
            </div>
        </div>
    </div>
</div>
