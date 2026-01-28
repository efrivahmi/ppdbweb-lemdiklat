<div>
    <x-atoms.breadcrumb current-path="Profile" />

    <x-atoms.card className="mt-4" padding="p-0">
        <div class="bg-gradient-to-r from-lime-500 to-green-600 text-white p-6 rounded-t-3xl">
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <img src="{{ auth()->user()->getProfilePhotoUrlAttribute() }}" 
                    alt="Profile" 
                    class="w-20 h-20 rounded-full border-4 border-white object-cover">
                    <div class="absolute -bottom-1 -right-1 bg-green-500 w-6 h-6 rounded-full border-2 border-white flex items-center justify-center">
                        <x-heroicon-o-check class="w-3 h-3 text-white" />
                    </div>
                </div>
                <div>
                    <x-atoms.title 
                        :text="$name" 
                        size="2xl" 
                        class="text-white mb-1"
                    />
                    <x-atoms.description class="text-lime-100">
                        NISN: {{ $nisn }}
                    </x-atoms.description>
                    <x-atoms.description size="sm" class="text-lime-200">
                        {{ $email }}
                    </x-atoms.description>
                </div>
            </div>
        </div>

        <div class="border-b border-gray-200">
            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                <button wire:click="setActiveTab('profile')"
                    class="py-4 px-1 border-b-2 font-medium text-sm transition-colors flex items-center
                    {{ $activeTab === 'profile' ? 'border-lime-500 text-lime-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <x-heroicon-o-user class="w-4 h-4 mr-2" />
                    Informasi Profile
                </button>
                <button wire:click="setActiveTab('password')"
                    class="py-4 px-1 border-b-2 font-medium text-sm transition-colors flex items-center
                    {{ $activeTab === 'password' ? 'border-lime-500 text-lime-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <x-heroicon-o-lock-closed class="w-4 h-4 mr-2" />
                    Ganti Password
                </button>
            </nav>
        </div>

        <div class="p-6">
            @if($activeTab === 'profile')
                <form wire:submit.prevent="updateProfile" class="space-y-6">
                    <div class="flex items-start space-x-6">
                        <div class="flex-shrink-0">
                            <img src="{{ auth()->user()->getProfilePhotoUrlAttribute() }}" 
                            alt="Profile" 
                            class="w-24 h-24 rounded-full object-cover border border-gray-300">
                        </div>
                        <div class="flex-1">
                            <x-atoms.label class="mb-2">
                                Foto Profile
                            </x-atoms.label>
                            <div class="flex items-center space-x-3">
                                <input type="file" 
                                       wire:model="new_foto_profile" 
                                       accept="image/*"
                                       class="block text-sm text-gray-500
                                       file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 
                                       file:text-sm file:font-semibold file:bg-lime-50 file:text-lime-700 
                                       hover:file:bg-lime-100">
                                @if($foto_profile)
                                    <x-atoms.button
                                        type="button"
                                        variant="ghost"
                                        theme="dark"
                                        size="sm"
                                        wire:click="deletePhoto"
                                        onclick="return confirm('Yakin ingin menghapus foto profile?')"
                                        heroicon="trash"
                                        className="text-red-600 hover:text-red-800"
                                    >
                                        Hapus
                                    </x-atoms.button>
                                @endif
                            </div>
                            @error('new_foto_profile')
                                <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                            <x-atoms.description size="xs" color="gray-500" class="mt-1">
                                Format: JPG, PNG. Maksimal 2MB.
                            </x-atoms.description>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-molecules.input-field
                            label="Nama Lengkap"
                            name="name"
                            wire:model="name"
                            :error="$errors->first('name')"
                            required
                        />

                        <x-molecules.input-field
                            label="Email"
                            inputType="email"
                            name="email"
                            wire:model="email"
                            :error="$errors->first('email')"
                            required
                        />

                        {{-- NISN Field - Disabled --}}
                        <div class="mb-4">
                            <x-atoms.label for="nisn">
                                NISN
                                <x-atoms.badge 
                                    text="Tidak dapat diubah" 
                                    variant="light" 
                                    size="sm"
                                    class="ml-2"
                                />
                            </x-atoms.label>
                            <x-atoms.input
                                type="text"
                                name="nisn"
                                id="nisn"
                                wire:model="nisn"
                                disabled
                                className="bg-gray-100 cursor-not-allowed"
                            />
                            <x-atoms.description size="xs" color="gray-500" class="mt-1">
                                NISN tidak dapat diubah setelah registrasi
                            </x-atoms.description>
                        </div>

                        <x-molecules.input-field
                            label="Nomor Telepon"
                            name="telp"
                            wire:model="telp"
                            placeholder="Contoh: 08123456789"
                            :error="$errors->first('telp')"
                        />
                    </div>

                    <div class="flex justify-end">
                        <x-atoms.button
                            type="submit"
                            variant="success"
                            heroicon="check-circle"
                            :isLoading="false"
                            loadingText="Menyimpan..."
                        >
                            Simpan Perubahan
                        </x-atoms.button>
                    </div>
                </form>
            @endif

            @if($activeTab === 'password')
                <form wire:submit.prevent="changePassword" class="space-y-6 max-w-md">
                    <div class="mb-6">
                        <x-atoms.title 
                            text="Ganti Password" 
                            size="lg" 
                            class="mb-2"
                        />
                        <x-atoms.description size="sm" color="gray-600">
                            Pastikan password baru Anda aman dan mudah diingat.
                        </x-atoms.description>
                    </div>

                    <x-molecules.input-field
                        label="Password Saat Ini"
                        inputType="password"
                        name="current_password"
                        wire:model="current_password"
                        :error="$errors->first('current_password')"
                        required
                    />

                    <div>
                        <x-molecules.input-field
                            label="Password Baru"
                            inputType="password"
                            name="new_password"
                            wire:model="new_password"
                            :error="$errors->first('new_password')"
                            required
                        />
                        <x-atoms.description size="xs" color="gray-500" class="mt-1">
                            Minimal 8 karakter
                        </x-atoms.description>
                    </div>

                    <x-molecules.input-field
                        label="Konfirmasi Password Baru"
                        inputType="password"
                        name="new_password_confirmation"
                        wire:model="new_password_confirmation"
                        required
                    />

                    <div class="flex justify-end">
                        <x-atoms.button
                            type="submit"
                            variant="success"
                            heroicon="lock-closed"
                            :isLoading="false"
                            loadingText="Mengubah..."
                        >
                            Ubah Password
                        </x-atoms.button>
                    </div>
                </form>
            @endif
        </div>
    </x-atoms.card>

    <x-atoms.card className="mt-6">
        <x-atoms.title 
            text="Informasi Akun" 
            size="lg" 
            class="mb-4"
        />
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-atoms.title 
                    text="Status Akun" 
                    size="sm" 
                    class="mb-2 text-gray-700"
                />
                <div class="flex items-center text-green-600">
                    <x-heroicon-o-check-circle class="w-5 h-5 mr-2" />
                    <x-atoms.description size="sm">
                        Akun Aktif
                    </x-atoms.description>
                </div>
            </div>
            <div>
                <x-atoms.title 
                    text="Tanggal Bergabung" 
                    size="sm" 
                    class="mb-2 text-gray-700"
                />
                <x-atoms.description size="sm" color="gray-600">
                    {{ Auth::user()->created_at->format('d M Y') }}
                </x-atoms.description>
            </div>
            <div>
                <x-atoms.title 
                    text="Terakhir Login" 
                    size="sm" 
                    class="mb-2 text-gray-700"
                />
                <x-atoms.description size="sm" color="gray-600">
                    {{ now()->format('d M Y H:i') }}
                </x-atoms.description>
            </div>
            <div>
                <x-atoms.title 
                    text="Role" 
                    size="sm" 
                    class="mb-2 text-gray-700"
                />
                <x-atoms.badge 
                    text="{{ ucfirst(Auth::user()->role) }}" 
                    variant="emerald" 
                    size="sm"
                    class="flex items-center w-fit"
                >
                    <x-heroicon-o-user class="w-4 h-4 mr-1" />
                    {{ ucfirst(Auth::user()->role) }}
                </x-atoms.badge>
            </div>
        </div>
    </x-atoms.card>
</div>