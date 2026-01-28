<div>
    <x-atoms.breadcrumb current-path="Profile" />

    <div class="bg-white border border-gray-300 shadow-md rounded-md mt-4">
        <div class="bg-gradient-to-r from-indigo-500 to-blue-600 text-white p-6 rounded-t-md">
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <img src="{{ $user->profile_photo_url }}" alt="Profile"
                        class="w-20 h-20 rounded-full border-4 border-white object-cover">
                    <div
                        class="absolute -bottom-1 -right-1 bg-green-500 w-6 h-6 rounded-full border-2 border-white flex items-center justify-center">
                        <i class="ri-check-line text-white text-xs"></i>
                    </div>
                </div>
                <div>
                    <h2 class="text-2xl font-semibold">{{ $name }}</h2>
                    <p class="text-indigo-200 text-sm">{{ $email }}</p>
                </div>
            </div>
        </div>

        {{-- Tabs Navigation --}}
        <div class="border-b border-gray-200">
            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                <button wire:click="setActiveTab('profile')"
                    class="py-4 px-1 border-b-2 font-medium text-sm transition-colors
                    {{ $activeTab === 'profile' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <i class="ri-user-line mr-2"></i>
                    Informasi Profile
                </button>
                <button wire:click="setActiveTab('password')"
                    class="py-4 px-1 border-b-2 font-medium text-sm transition-colors
                    {{ $activeTab === 'password' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <i class="ri-lock-line mr-2"></i>
                    Ganti Password
                </button>
            </nav>
        </div>

        {{-- Tab Content --}}
        <div class="p-6">
            {{-- Profile Tab --}}
            @if ($activeTab === 'profile')
                <form wire:submit.prevent="updateProfile" class="space-y-6">
                    {{-- Photo Upload Section --}}
                    <div class="flex items-start space-x-6">
                        <div class="flex-shrink-0">
                            <img src="{{ auth()->user()->getProfilePhotoUrlAttribute() }}" alt="Profile"
                            class="w-24 h-24 rounded-full object-cover border border-gray-300">
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Foto Profile
                            </label>
                            <div class="flex items-center space-x-3">
                                <input type="file" wire:model="new_foto_profile" accept="image/*"
                                    class="block text-sm text-gray-500
                                       file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 
                                       file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 
                                       hover:file:bg-indigo-100">
                                @if ($foto_profile)
                                    <button type="button" wire:click="deletePhoto"
                                        onclick="return confirm('Yakin ingin menghapus foto profile?')"
                                        class="text-red-600 hover:text-red-800 text-sm">
                                        <i class="ri-delete-bin-line mr-1"></i>Hapus
                                    </button>
                                @endif
                            </div>
                            @error('new_foto_profile')
                                <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Maksimal 2MB.</p>
                        </div>
                    </div>

                    {{-- Form Fields --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nama Lengkap --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Nama Lengkap *
                            </label>
                            <input type="text" wire:model="name" id="name"
                                class="border border-gray-300 px-3 py-2 w-full rounded-md focus:outline-indigo-500 focus:border-indigo-500 transition @error('name') border-red-500 @enderror">
                            @error('name')
                                <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                Email *
                            </label>
                            <input type="email" wire:model="email" id="email"
                                class="border border-gray-300 px-3 py-2 w-full rounded-md focus:outline-indigo-500 focus:border-indigo-500 transition @error('email') border-red-500 @enderror">
                            @error('email')
                                <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Nomor Telepon --}}
                        <div>
                            <label for="telp" class="block text-sm font-medium text-gray-700 mb-1">
                                Nomor Telepon
                            </label>
                            <input type="text" wire:model="telp" id="telp" placeholder="Contoh: 08123456789"
                                class="border border-gray-300 px-3 py-2 w-full rounded-md focus:outline-indigo-500 focus:border-indigo-500 transition @error('telp') border-red-500 @enderror">
                            @error('telp')
                                <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition"
                            wire:loading.attr="disabled">
                            <i class="ri-save-line mr-2"></i>
                            <span wire:loading.remove>Simpan Perubahan</span>
                            <span wire:loading>Menyimpan...</span>
                        </button>
                    </div>
                </form>
            @endif

            {{-- Password Tab --}}
            @if ($activeTab === 'password')
                <form wire:submit.prevent="changePassword" class="space-y-6 max-w-md">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Ganti Password</h3>
                        <p class="text-sm text-gray-600">Pastikan password baru Anda aman dan mudah diingat.</p>
                    </div>

                    {{-- Current Password --}}
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">
                            Password Saat Ini *
                        </label>
                        <input type="password" wire:model="current_password" id="current_password"
                            class="border border-gray-300 px-3 py-2 w-full rounded-md focus:outline-indigo-500 focus:border-indigo-500 transition @error('current_password') border-red-500 @enderror">
                        @error('current_password')
                            <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- New Password --}}
                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">
                            Password Baru *
                        </label>
                        <input type="password" wire:model="new_password" id="new_password"
                            class="border border-gray-300 px-3 py-2 w-full rounded-md focus:outline-indigo-500 focus:border-indigo-500 transition @error('new_password') border-red-500 @enderror">
                        @error('new_password')
                            <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                @endif
                <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter</p>
            </div>

            {{-- Confirm New Password --}}
            <div>
                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                    Konfirmasi Password Baru *
                </label>
                <input type="password" wire:model="new_password_confirmation" id="new_password_confirmation"
                    class="border border-gray-300 px-3 py-2 w-full rounded-md focus:outline-indigo-500 focus:border-indigo-500 transition">
            </div>



            {{-- Submit Button --}}
            <div class="flex justify-end">
                <button type="submit"
                    class="inline-flex items-center px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition"
                    wire:loading.attr="disabled">
                    <i class="ri-lock-line mr-2"></i>
                    <span wire:loading.remove>Ubah Password</span>
                    <span wire:loading>Mengubah...</span>
                </button>
            </div>
            </form>
            @endif
        </div>
    </div>


    </div>
