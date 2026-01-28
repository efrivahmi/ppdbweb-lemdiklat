<div>
    <x-atoms.breadcrumb current-path="Data Siswa" />

    <x-atoms.card className="mt-4">
        <div class="flex flex-col mb-6 space-y-2">
            <x-atoms.title text="Data Siswa" size="xl" />
            <x-atoms.description size="sm" color="gray-600">
                Lengkapi data pribadi Anda dengan benar dan sesuai dokumen resmi
            </x-atoms.description>

            <!-- Progress bar -->
            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                <div class="bg-lime-600 h-2.5 rounded-full transition-all duration-300"
                    style="width: {{ $this->getProgress() }}%">
                </div>
            </div>
            <p class="text-sm text-gray-600">
                Progress: {{ $this->getProgress() }}%
            </p>
        </div>


        <!-- Form -->
        <form wire:submit.prevent="update" class="space-y-6">
            <!-- Data Identitas -->
            <div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-molecules.input-field
                        label="Nomor Kartu Keluarga (KK)"
                        name="nomor_kartu_keluarga"
                        wire:model.blur="nomor_kartu_keluarga"
                        placeholder="Masukkan 16 digit nomor KK"
                        :error="$errors->first('nomor_kartu_keluarga')"
                        icon="ri-id-card-line"
                        maxlength="16" />

                    <x-molecules.input-field
                        label="Tempat Lahir"
                        name="tempat_lahir"
                        wire:model.blur="tempat_lahir"
                        placeholder="Contoh: Jakarta"
                        :error="$errors->first('tempat_lahir')"
                        icon="ri-map-pin-line" />

                    <div>
                        <x-molecules.input-field
                            label="Tanggal Lahir"
                            name="tgl_lahir"
                            inputType="date"
                            wire:model.blur="tgl_lahir"
                            :error="$errors->first('tgl_lahir')"
                            icon="ri-calendar-line" />
                        <x-atoms.description size="sm" color="gray-500">
                            Urutan format: Bulan-Hari-Tahun (mm-dd-yyyy)
                        </x-atoms.description>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <x-atoms.label for="jenis_kelamin">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </x-atoms.label>
                        <div class="mt-2 space-y-3">
                            @foreach($jenisKelaminOptions as $value => $label)
                            <label class="flex items-center cursor-pointer group">
                                <input type="radio"
                                    wire:model.blur="jenis_kelamin"
                                    value="{{ $value }}"
                                    class="w-4 h-4 text-lime-600 bg-gray-100 border-gray-300 focus:ring-lime-500 focus:ring-2">
                                <div class="ml-3 flex items-center gap-2">
                                    <i class="ri-{{ $value === 'Laki-laki' ? 'men' : 'women' }}-line text-gray-500 group-hover:text-lime-600"></i>
                                    <span class="text-sm font-medium text-gray-900 group-hover:text-lime-600">{{ $label }}</span>
                                </div>
                            </label>
                            @endforeach
                        </div>
                        @error('jenis_kelamin')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Agama -->
                    <div>
                        <x-atoms.label for="agama">Agama <span class="text-red-500">*</span></x-atoms.label>
                        <div class="relative">
                            <select wire:model.blur="agama"
                                class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-lime-500 transition duration-200 appearance-none bg-white">
                                <option value="">-- Pilih Agama --</option>
                                @foreach($agamaOptions as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <i class="ri-book-line absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                <i class="ri-arrow-down-s-line text-gray-400"></i>
                            </div>
                        </div>
                        @error('agama')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            <!-- Data Fisik -->
            <div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-molecules.input-field
                        label="Berat Badan (kg)"
                        name="berat_badan"
                        inputType="number"
                        wire:model.blur="berat_badan"
                        placeholder="Contoh: 55"
                        :error="$errors->first('berat_badan')"
                        icon="ri-scales-3-line"
                        step="0.1"
                        min="1"
                        max="999" />

                    <x-molecules.input-field
                        label="Tinggi Badan (cm)"
                        name="tinggi_badan"
                        inputType="number"
                        wire:model.blur="tinggi_badan"
                        placeholder="Contoh: 165"
                        :error="$errors->first('tinggi_badan')"
                        icon="ri-ruler-line"
                        step="0.1"
                        min="50"
                        max="300" />

                </div>
            </div>

            <!-- Data Kontak & Alamat -->
            <div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-molecules.input-field
                        label="Nomor WhatsApp"
                        name="whatsapp"
                        wire:model.blur="whatsapp"
                        placeholder="Contoh: 081234567890"
                        :error="$errors->first('whatsapp')"
                        icon="ri-whatsapp-line" />

                    <x-molecules.input-field
                        label="Asal Sekolah"
                        name="asal_sekolah"
                        wire:model.blur="asal_sekolah"
                        placeholder="Contoh: SMP Negeri 1 Jakarta"
                        :error="$errors->first('asal_sekolah')"
                        icon="ri-school-line" />
                </div>

                <div class="mt-6">
                    <x-molecules.textarea-field
                        label="Alamat Lengkap"
                        name="alamat"
                        wire:model.blur="alamat"
                        placeholder="Masukkan alamat lengkap sesuai KTP/KK"
                        :rows="4"
                        :error="$errors->first('alamat')"
                        icon="ri-map-pin-line" />
                </div>
            </div>

            <!-- Data Kesehatan -->
            <div>
                <x-molecules.textarea-field
                    label="Riwayat Penyakit"
                    name="riwayat_penyakit"
                    wire:model.blur="riwayat_penyakit"
                    placeholder="Kosongkan jika tidak ada riwayat penyakit khusus"
                    :rows="3"
                    :error="$errors->first('riwayat_penyakit')"
                    icon="ri-medicine-bottle-line" />

                <div class="mt-2">
                    <p class="text-sm text-gray-500 flex items-start gap-2">
                        <i class="ri-information-line mt-0.5"></i>
                        <span>Sebutkan riwayat penyakit serius yang pernah dialami seperti asma, diabetes, jantung, dll. Informasi ini penting untuk penanganan medis darurat di sekolah.</span>
                    </p>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6">
                <button type="submit"
                    wire:loading.attr="disabled"
                    wire:target="update"
                    @disabled(!$this->checkAllFilled())
                    class="flex-1 bg-lime-500 hover:bg-lime-600 disabled:bg-gray-400 text-white py-3 px-6 rounded-lg transition duration-300 flex items-center justify-center gap-2 font-medium">
                    <span wire:loading.remove wire:target="update">
                        <i class="ri-save-line"></i>
                        Simpan Data
                    </span>
                    <span wire:loading wire:target="update" class="flex items-center gap-2">
                        <div class="animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent"></div>
                        Menyimpan...
                    </span>
                </button>
            </div>

        </form>
    </x-atoms.card>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
@endpush

@push('scripts')
<script>
    // Auto-calculate BMI when values change
    document.addEventListener('livewire:updated', function() {
        // Could add additional client-side validations here if needed
    });

    // Success/Error alerts
    window.addEventListener('alert', event => {
        const {
            type,
            message
        } = event.detail;

        // Replace with your preferred notification system
        if (type === 'success') {
            // Success notification
            console.log('Success:', message);

            // Show success toast (you can replace this with your toast library)
            const toast = document.createElement('div');
            toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
            toast.innerHTML = `
                <div class="flex items-center gap-2">
                    <i class="ri-check-circle-line"></i>
                    <span>${message}</span>
                </div>
            `;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3000);

        } else if (type === 'error') {
            // Error notification  
            console.log('Error:', message);

            // Show error toast
            const toast = document.createElement('div');
            toast.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
            toast.innerHTML = `
                <div class="flex items-center gap-2">
                    <i class="ri-error-warning-line"></i>
                    <span>${message}</span>
                </div>
            `;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3000);
        }
    });

    // Prevent form submission on Enter key in number inputs
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && (e.target.type === 'number' || e.target.type === 'text')) {
            e.preventDefault();
        }
    });

    // Format WhatsApp number input
    document.addEventListener('input', function(e) {
        if (e.target.name === 'whatsapp') {
            // Remove any non-numeric characters except +
            let value = e.target.value.replace(/[^\d+]/g, '');

            // If starts with 0, replace with +62
            if (value.startsWith('0')) {
                value = '+62' + value.slice(1);
            }

            e.target.value = value;
        }
    });

    // Format Nomor Kartu Keluarga input - only allow numbers
    document.addEventListener('input', function(e) {
        if (e.target.name === 'nomor_kartu_keluarga') {
            // Remove any non-numeric characters
            let value = e.target.value.replace(/[^\d]/g, '');
            
            // Limit to 16 digits
            if (value.length > 16) {
                value = value.slice(0, 16);
            }
            
            e.target.value = value;
        }
    });
</script>
@endpush