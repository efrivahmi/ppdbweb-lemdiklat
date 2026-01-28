<div class="space-y-8">
  <div class="text-center">
    <x-atoms.title text="Buat Akun Baru" size="2xl" align="center" class="mb-2 text-gray-800" />
    <x-atoms.description align="center" color="gray-600" size="sm">
      Lengkapi informasi di bawah untuk membuat akun
    </x-atoms.description>
  </div>

  <form class="grid grid-cols-1 md:grid-cols-2 gap-6" wire:submit.prevent="register">
    <x-molecules.input-field label="Nama Lengkap" inputType="text" name="name" id="name"
      placeholder="Masukkan nama lengkap" wire:model.defer="name" :error="$errors->first('name')" required />

    <x-molecules.input-field label="Alamat Email" inputType="email" name="email" id="email"
      placeholder="contoh@email.com" wire:model.defer="email" :error="$errors->first('email')" required />

    <x-molecules.input-field label="NISN" inputType="text" name="nisn" id="nisn"
      placeholder="Masukkan NISN" wire:model.defer="nisn" :error="$errors->first('nisn')" required />

    <x-molecules.input-field label="Nomor Telepon" inputType="tel" name="telp" id="telp"
      placeholder="08xxxxxxxxxx" wire:model.defer="telp" :error="$errors->first('telp')" required />

    <x-molecules.input-field label="Kata Sandi" inputType="password" name="password" id="password"
      placeholder="Minimal 8 karakter" wire:model.defer="password" :error="$errors->first('password')" required />

    <x-molecules.input-field label="Konfirmasi Kata Sandi" inputType="password"
      name="password_confirmation" id="password_confirmation"
      placeholder="Ulangi kata sandi" wire:model.defer="password_confirmation" required />

    <div class="col-span-1 md:col-span-2">
      @if (optional($gelombangActive)->isPendaftaranAktif())
        <x-atoms.button type="submit" variant="success" size="lg" isFullWidth="true"
          rounded="full" shadow="lg" heroicon="user-plus"
          class="transform transition-all duration-200 hover:scale-[1.02] hover:shadow-xl">
          Daftar Sekarang
        </x-atoms.button>
      @else
        <x-atoms.button type="button" variant="danger" size="lg" isFullWidth="true"
          rounded="full" shadow="lg" heroicon="user-plus" disabled
          class="cursor-not-allowed">
          Pendaftaran sudah ditutup
        </x-atoms.button>
      @endif
    </div>
  </form>

  <div class="flex items-center my-6">
    <div class="flex-1 border-t border-gray-200"></div>
    <span class="px-4 text-sm text-gray-500 bg-white">atau</span>
    <div class="flex-1 border-t border-gray-200"></div>
  </div>

  <div class="text-center">
    <x-atoms.description align="center" color="gray-600" size="sm">
      Sudah memiliki akun?
      <a href="{{ route('login') }}"
        class="inline-block mt-2 text-lime-600 hover:text-lime-700 hover:bg-lime-50 transition-all duration-200">
        Masuk Sekarang
      </a>
    </x-atoms.description>

    <x-atoms.description align="center" color="gray-400" size="sm" class="mt-4">
      <a href="{{ url('/') }}" class="hover:text-lime-600 transition-colors duration-200">
        <x-heroicon-o-arrow-left class="w-4 h-4 inline-block" />
        Kembali ke Home
      </a>
    </x-atoms.description>
  </div>
</div>
