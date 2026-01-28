<div>
    <x-atoms.breadcrumb current-path="Data Orang Tua" />

    <x-atoms.card className="mt-4">
        <x-atoms.title
            text="Formulir Data Orang Tua"
            size="xl"
            class="mb-6" />

        <!-- Progress bar -->
        <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
            <div class="bg-lime-600 h-2.5 rounded-full transition-all duration-300"
                 style="width: {{ $this->getProgress() }}%">
            </div>
        </div>
        <p class="text-sm text-gray-600 mb-6">
            Progress: {{ $this->getProgress() }}%
        </p>

        <form wire:submit.prevent="update" class="flex flex-col">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div class="md:col-span-2">
                    <x-atoms.title
                        text="Data Ayah"
                        size="lg"
                        class="text-lime-700 flex items-center">
                        Data Ayah
                    </x-atoms.title>
                </div>

                <x-molecules.input-field
                    label="Nama Ayah"
                    inputType="text"
                    name="nama_ayah"
                    id="nama_ayah"
                    placeholder="Masukan nama lengkap ayah"
                    wire:model.live="nama_ayah"
                    :error="$errors->first('nama_ayah')" />

                <x-molecules.input-field
                    label="Pendidikan Ayah"
                    inputType="text"
                    name="pendidikan_ayah"
                    id="pendidikan_ayah"
                    placeholder="Contoh: S1, SMA, dll"
                    wire:model.live="pendidikan_ayah"
                    :error="$errors->first('pendidikan_ayah')" />

                <x-molecules.input-field
                    label="Nomor Telepon Ayah"
                    inputType="text"
                    name="telp_ayah"
                    id="telp_ayah"
                    placeholder="Contoh: 08123456789"
                    wire:model.live="telp_ayah"
                    :error="$errors->first('telp_ayah')" />

                <!-- Pekerjaan Ayah -->
                <div>
                    <x-atoms.label for="pekerjaan_ayah">Pekerjaan Ayah <span class="text-red-500">*</span></x-atoms.label>
                    <div class="relative">
                        <select wire:model.live="pekerjaan_ayah"
                            id="pekerjaan_ayah"
                            class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-lime-500 transition duration-200 appearance-none bg-white">
                            <option value="">-- Pilih Pekerjaan Ayah --</option>
                            @foreach($this->getPekerjaanOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <i class="ri-briefcase-line absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <i class="ri-arrow-down-s-line text-gray-400"></i>
                        </div>
                    </div>
                    @error('pekerjaan_ayah')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Penghasilan Ayah -->
                <div>
                    <x-atoms.label for="penghasilan_ayah">Penghasilan Ayah <span class="text-red-500">*</span></x-atoms.label>
                    <div class="relative">
                        <select wire:model.live="penghasilan_ayah"
                            id="penghasilan_ayah"
                            class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-lime-500 transition duration-200 appearance-none bg-white">
                            <option value="">-- Pilih Range Penghasilan --</option>
                            @foreach($this->getPenghasilanOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <i class="ri-money-dollar-circle-line absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <i class="ri-arrow-down-s-line text-gray-400"></i>
                        </div>
                    </div>
                    @error('penghasilan_ayah')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <x-molecules.textarea-field
                    label="Alamat Ayah"
                    name="alamat_ayah"
                    id="alamat_ayah"
                    rows="3"
                    placeholder="Masukan alamat lengkap ayah"
                    wire:model.live="alamat_ayah"
                    :error="$errors->first('alamat_ayah')"
                    class="md:col-span-1" />

                <div class="md:col-span-2 mt-6">
                    <x-atoms.title
                        text="Data Ibu"
                        size="lg"
                        class="text-lime-700 flex items-center">
                        Data Ibu
                    </x-atoms.title>
                </div>

                <x-molecules.input-field
                    label="Nama Ibu"
                    inputType="text"
                    name="nama_ibu"
                    id="nama_ibu"
                    placeholder="Masukan nama lengkap ibu"
                    wire:model.live="nama_ibu"
                    :error="$errors->first('nama_ibu')" />

                <x-molecules.input-field
                    label="Pendidikan Ibu"
                    inputType="text"
                    name="pendidikan_ibu"
                    id="pendidikan_ibu"
                    placeholder="Contoh: S1, SMA, dll"
                    wire:model.live="pendidikan_ibu"
                    :error="$errors->first('pendidikan_ibu')" />

                <x-molecules.input-field
                    label="Nomor Telepon Ibu"
                    inputType="text"
                    name="telp_ibu"
                    id="telp_ibu"
                    placeholder="Contoh: 08123456789"
                    wire:model.live="telp_ibu"
                    :error="$errors->first('telp_ibu')" />

                <!-- Pekerjaan Ibu -->
                <div>
                    <x-atoms.label for="pekerjaan_ibu">Pekerjaan Ibu <span class="text-red-500">*</span></x-atoms.label>
                    <div class="relative">
                        <select wire:model.live="pekerjaan_ibu"
                            id="pekerjaan_ibu"
                            class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-lime-500 transition duration-200 appearance-none bg-white">
                            <option value="">-- Pilih Pekerjaan Ibu --</option>
                            @foreach($this->getPekerjaanOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <i class="ri-briefcase-line absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <i class="ri-arrow-down-s-line text-gray-400"></i>
                        </div>
                    </div>
                    @error('pekerjaan_ibu')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Penghasilan Ibu -->
                <div>
                    <x-atoms.label for="penghasilan_ibu">Penghasilan Ibu <span class="text-red-500">*</span></x-atoms.label>
                    <div class="relative">
                        <select wire:model.live="penghasilan_ibu"
                            id="penghasilan_ibu"
                            class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-lime-500 transition duration-200 appearance-none bg-white">
                            <option value="">-- Pilih Range Penghasilan --</option>
                            @foreach($this->getPenghasilanOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <i class="ri-money-dollar-circle-line absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <i class="ri-arrow-down-s-line text-gray-400"></i>
                        </div>
                    </div>
                    @error('penghasilan_ibu')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <x-molecules.textarea-field
                    label="Alamat Ibu"
                    name="alamat_ibu"
                    id="alamat_ibu"
                    rows="3"
                    placeholder="Masukan alamat lengkap ibu"
                    wire:model.live="alamat_ibu"
                    :error="$errors->first('alamat_ibu')"
                    class="md:col-span-1" />

                <div class="md:col-span-2 mt-6">
                    <x-atoms.title
                        size="lg"
                        class="text-lime-700 flex items-center">
                        Data Wali
                        <span class="text-sm font-normal text-gray-500 ml-2">(Opsional)</span>
                    </x-atoms.title>
                </div>

                <x-molecules.input-field
                    label="Nama Wali"
                    inputType="text"
                    name="nama_wali"
                    id="nama_wali"
                    placeholder="Masukan nama lengkap wali"
                    wire:model.live="nama_wali"
                    :error="$errors->first('nama_wali')" />

                <x-molecules.input-field
                    label="Pendidikan Wali"
                    inputType="text"
                    name="pendidikan_wali"
                    id="pendidikan_wali"
                    placeholder="Contoh: S1, SMA, dll"
                    wire:model.live="pendidikan_wali"
                    :error="$errors->first('pendidikan_wali')" />

                <x-molecules.input-field
                    label="Nomor Telepon Wali"
                    inputType="text"
                    name="telp_wali"
                    id="telp_wali"
                    placeholder="Contoh: 08123456789"
                    wire:model.live="telp_wali"
                    :error="$errors->first('telp_wali')" />

                <!-- Pekerjaan Wali -->
                <div>
                    <x-atoms.label for="pekerjaan_wali">Pekerjaan Wali</x-atoms.label>
                    <div class="relative">
                        <select wire:model.live="pekerjaan_wali"
                            id="pekerjaan_wali"
                            class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-lime-500 transition duration-200 appearance-none bg-white">
                            <option value="">-- Pilih Pekerjaan Wali --</option>
                            @foreach($this->getPekerjaanOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <i class="ri-briefcase-line absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <i class="ri-arrow-down-s-line text-gray-400"></i>
                        </div>
                    </div>
                    @error('pekerjaan_wali')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Penghasilan Wali -->
                <div>
                    <x-atoms.label for="penghasilan_wali">Penghasilan Wali</x-atoms.label>
                    <div class="relative">
                        <select wire:model.live="penghasilan_wali"
                            id="penghasilan_wali"
                            class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-lime-500 transition duration-200 appearance-none bg-white">
                            <option value="">-- Pilih Range Penghasilan --</option>
                            @foreach($this->getPenghasilanOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <i class="ri-money-dollar-circle-line absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <i class="ri-arrow-down-s-line text-gray-400"></i>
                        </div>
                    </div>
                    @error('penghasilan_wali')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <x-molecules.textarea-field
                    label="Alamat Wali"
                    name="alamat_wali"
                    id="alamat_wali"
                    rows="3"
                    placeholder="Masukan alamat lengkap wali"
                    wire:model.live="alamat_wali"
                    :error="$errors->first('alamat_wali')"
                    class="md:col-span-1" />
            </div>
            <x-atoms.button
                type="submit"
                variant="success"
                size="md"
                class="w-full"
                heroicon="document-check"
                iconPosition="left"
                wire:loading.attr="disabled"
                wire:target="update"
                :disabled="!$this->isComplete">
                <span wire:loading.remove wire:target="update">Simpan & Lanjut</span>
                <span wire:loading wire:target="update">Menyimpan...</span>
            </x-atoms.button>

        </form>
    </x-atoms.card>

    <!-- Loading overlay -->
    <div wire:loading.flex wire:target="update" class="fixed inset-0 bg-black/50 z-50 items-center justify-center">
        <div class="bg-white rounded-lg p-6 flex items-center gap-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-lime-600"></div>
            <span class="text-gray-700">Menyimpan data orang tua...</span>
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
@endpush