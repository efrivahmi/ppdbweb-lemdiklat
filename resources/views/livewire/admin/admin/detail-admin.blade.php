<div class="space-y-6">
    <x-atoms.breadcrumb current-path="Detail Admin" />

    {{-- Admin Profile Card --}}
    <div class="bg-white p-6 rounded-lg shadow border">
        <div class="flex flex-col lg:flex-row gap-6">
            {{-- Profile Photo --}}
            <div class="lg:w-1/4">
                <div class="text-center">
                    <div class="w-32 h-32 mx-auto bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                            <img src="{{ $admin->profile_photo_url }}" 
                                 class="w-32 h-32 rounded-full object-cover border-4 border-indigo-500">

                    </div>
                    
                    @if($admin->foto_profile)
                        <button wire:click="deletePhoto" 
                                onclick="return confirm('Yakin ingin menghapus foto profil?')"
                                class="text-sm text-red-600 hover:text-red-800">
                            <i class="ri-delete-bin-line mr-1"></i>Hapus Foto
                        </button>
                    @endif
                </div>
            </div>

            {{-- Profile Info --}}
            <div class="lg:w-3/4">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $admin->name }}</h1>
                        <p class="text-gray-600 text-lg">{{ $admin->email }}</p>
                        <div class="flex items-center gap-4 mt-2 text-sm text-gray-600">
                            <span><i class="ri-phone-line mr-1"></i> {{ $admin->telp ?? 'Tidak ada' }}</span>
                            <span><i class="ri-calendar-line mr-1"></i> Bergabung {{ $admin->created_at->format('d M Y') }}</span>
                            @if($admin->id === auth()->id())
                                <span class="px-2 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-semibold">
                                    Akun Anda
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex gap-2">
                        <button wire:click="toggleEditModal" 
                                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            <i class="ri-edit-line mr-1"></i>Edit Profil
                        </button>
                        <button wire:click="togglePasswordModal" 
                                class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                            <i class="ri-lock-line mr-1"></i>Ubah Password
                        </button>
                    </div>
                </div>

                {{-- Admin Stats --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="ri-user-line text-2xl text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Role</p>
                                <p class="text-lg font-semibold text-gray-900">Administrator</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="ri-shield-check-line text-2xl text-purple-600"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Status</p>
                                <p class="text-lg font-semibold text-green-600">Aktif</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Activity Log --}}
    <div class="bg-white p-6 rounded-lg shadow border">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Log Aktivitas</h2>
        <div class="space-y-3">
            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">Akun admin dibuat</p>
                    <p class="text-xs text-gray-500">{{ $admin->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">Terakhir update profil</p>
                    <p class="text-xs text-gray-500">{{ $admin->updated_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    @if($showEditModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Edit Profil Admin</h3>
                <button wire:click="toggleEditModal" class="text-gray-500 hover:text-gray-700">
                    <i class="ri-close-line text-xl"></i>
                </button>
            </div>

            <form wire:submit.prevent="updateAdmin" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" wire:model="name" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                  @error('name') border-red-500 @enderror">
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" wire:model="email" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                  @error('email') border-red-500 @enderror">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                    <input type="text" wire:model="telp" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('telp') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto Profil</label>
                    <input type="file" wire:model="foto_profile" accept="image/*"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                                  file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 
                                  file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 
                                  hover:file:bg-indigo-100 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('foto_profile') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" 
                            class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        <i class="ri-save-line mr-1"></i>Simpan
                    </button>
                    <button type="button" wire:click="toggleEditModal"
                            class="flex-1 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- Password Modal --}}
    @if($showPasswordModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Ubah Password</h3>
                <button wire:click="togglePasswordModal" class="text-gray-500 hover:text-gray-700">
                    <i class="ri-close-line text-xl"></i>
                </button>
            </div>

            <form wire:submit.prevent="updatePassword" class="space-y-4">
                @if($admin->id === auth()->id())
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password Saat Ini</label>
                    <input type="password" wire:model="current_password" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                  @error('current_password') border-red-500 @enderror">
                    @error('current_password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                    <input type="password" wire:model="password" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                  @error('password') border-red-500 @enderror">
                    @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                    <input type="password" wire:model="password_confirmation" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" 
                            class="flex-1 px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                        <i class="ri-lock-line mr-1"></i>Ubah Password
                    </button>
                    <button type="button" wire:click="togglePasswordModal"
                            class="flex-1 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>