<div>
    <x-atoms.breadcrumb current-path="Notifikasi" />

    <div class="mt-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Semua Notifikasi</h2>
            <p class="text-sm text-gray-500">Pemberitahuan dan riwayat aktivitas Anda</p>
        </div>
        
        @if($notifications->count() > 0)
        <button wire:click="clearAll" wire:confirm="Apakah Anda yakin ingin menghapus semua notifikasi?" class="text-sm text-red-600 hover:text-red-800 font-medium px-3 py-1.5 rounded-lg border border-red-200 hover:bg-red-50 transition-colors">
            <i class="ri-delete-bin-line mr-1"></i> Hapus Semua
        </button>
        @endif
    </div>

    <div class="mt-6 bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        @if($notifications->count() > 0)
            <div class="divide-y divide-gray-100">
                @foreach($notifications as $notification)
                    @php
                        $type = $notification->data['type'] ?? 'info';
                        $icon = $notification->data['icon'] ?? 'bell';
                        $title = match($type) {
                            'registration' => 'Pendaftar Baru',
                            'payment' => 'Pembayaran',
                            'status' => 'Status Diperbarui',
                            'reminder' => 'Pengingat',
                            'jadwal_ujian_khusus' => 'Jadwal Ujian Khusus',
                            default => 'Notifikasi',
                        };
                        $isExpanded = false; // Using Alpine for interactivity
                        
                        $bgColor = match($type) {
                            'registration' => 'bg-lime-100 text-lime-600',
                            'payment' => 'bg-green-100 text-green-600',
                            'status' => 'bg-blue-100 text-blue-600',
                            'reminder' => 'bg-orange-100 text-orange-600',
                            'jadwal_ujian_khusus' => 'bg-red-100 text-red-600',
                            default => 'bg-gray-100 text-gray-600',
                        };
                    @endphp

                    <div x-data="{ expanded: false }" class="p-4 sm:p-5 hover:bg-gray-50 transition-colors {{ is_null($notification->read_at) ? 'bg-blue-50/30' : '' }}">
                        <div class="flex items-start gap-4">
                            {{-- Icon --}}
                            <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center {{ $bgColor }}">
                                @if($icon === 'user-plus') <x-lucide-user-plus class="w-5 h-5" />
                                @elseif($icon === 'check-circle') <x-lucide-check-circle class="w-5 h-5" />
                                @elseif($icon === 'x-circle') <x-lucide-x-circle class="w-5 h-5" />
                                @elseif($icon === 'clock') <x-lucide-clock class="w-5 h-5" />
                                @elseif($icon === 'information-circle') <x-lucide-info class="w-5 h-5" />
                                @elseif($icon === 'calendar-check') <x-lucide-calendar-check class="w-5 h-5" />
                                @else <x-lucide-bell class="w-5 h-5" />
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start mb-1">
                                    <h4 class="text-sm font-semibold {{ is_null($notification->read_at) ? 'text-gray-900' : 'text-gray-700' }}">
                                        {{ $title }}
                                        @if(is_null($notification->read_at))
                                            <span class="inline-flex items-center px-2 py-0.5 ml-2 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                Baru
                                            </span>
                                        @endif
                                    </h4>
                                    <span class="text-xs text-gray-500 whitespace-nowrap ml-2">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                {{-- Message with Expandable Logic --}}
                                <div class="text-sm text-gray-600 mt-1">
                                    <p :class="expanded ? '' : 'line-clamp-2'">{{ $notification->data['message'] ?? 'Notifikasi baru' }}</p>
                                    
                                    {{-- "Baca Selengkapnya" Toggle if text is long (handled via Alpine roughly, or just display button) --}}
                                    @if(strlen($notification->data['message'] ?? '') > 120)
                                        <button @click="expanded = !expanded" class="text-blue-600 hover:text-blue-800 text-xs font-medium mt-1 focus:outline-none">
                                            <span x-show="!expanded">Baca Selengkapnya</span>
                                            <span x-show="expanded" x-cloak>Sembunyikan</span>
                                        </button>
                                    @endif
                                </div>

                                {{-- Action Button --}}
                                @if(!empty($notification->data['action_url']))
                                    <div class="mt-3">
                                        <a href="{{ $notification->data['action_url'] }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                            Buka Halaman <i class="ri-arrow-right-line ml-1"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="p-4 border-t border-gray-100 bg-gray-50">
                {{ $notifications->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <x-lucide-bell-off class="w-8 h-8 text-gray-400" />
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-1">Belum ada notifikasi</h3>
                <p class="text-gray-500">Notifikasi Anda akan muncul di sini.</p>
            </div>
        @endif
    </div>
</div>
