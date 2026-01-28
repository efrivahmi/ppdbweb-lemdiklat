<div class="space-y-8" x-data="{ errorMessage: '' }" x-on:error.window="errorMessage = $event.detail.message">

  <div class="text-center">
    <x-atoms.title text="Selamat Datang" size="2xl" align="center" class="mb-2 text-gray-800" />
    <x-atoms.description align="center" color="gray-600" size="sm">
      Masuk ke akun Anda untuk melanjutkan
    </x-atoms.description>
  </div>

  <!-- Alert Error -->
  <template x-if="errorMessage">
    <div class="bg-red-500 text-white p-2 rounded text-center">
      <span x-text="errorMessage"></span>
    </div>
  </template>

  <form class="space-y-6" wire:submit.prevent="login">
    <x-molecules.input-field label="Email atau NISN" inputType="text" name="credentials" id="credentials"
      placeholder="Masukkan email atau NISN Anda" wire:model.defer="credentials"
      :error="$errors->first('credentials')" required />

    <x-molecules.input-field label="Kata Sandi" inputType="password" name="password" id="password"
      placeholder="Masukkan kata sandi Anda" wire:model.defer="password" :error="$errors->first('password')"
      required />

    <x-atoms.button type="submit" variant="success" size="lg" isFullWidth="true" rounded="full"
      shadow="lg" heroicon="arrow-right-on-rectangle"
      class="transform transition-all duration-200 hover:scale-[1.02] hover:shadow-xl">
      Masuk
    </x-atoms.button>
  </form>

  <div class="flex items-center my-4">
    <div class="flex-1 border-t border-gray-200"></div>
    <span class="px-4 text-sm text-gray-500 bg-white">atau</span>
    <div class="flex-1 border-t border-gray-200"></div>
  </div>

  <div class="text-center">
    <x-atoms.description align="center" color="gray-600" size="sm">
      Belum memiliki akun?
      <a href="{{ route('register') }}"
        class="inline-block mt-2 text-lime-600 hover:text-lime-700 hover:bg-lime-50 transition-all duration-200">
        Daftar Sekarang
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
