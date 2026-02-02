@props([
    'canUploadPayment' => false,
    'buktiTransfer' => null,
    'transfer_picture' => null,
])

<div class="bg-white border border-gray-300 shadow-md rounded-md p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        <i class="ri-upload-cloud-line mr-2 text-lime-600"></i>
        Bukti Transfer
    </h3>

    @if(!$canUploadPayment)
        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg text-center">
            <i class="ri-lock-line text-3xl text-yellow-600 mb-2 block"></i>
            <p class="text-yellow-800 font-medium">Upload Bukti Transfer Belum Tersedia</p>
            <p class="text-yellow-700 text-sm mt-1">Lengkapi semua data terlebih dahulu untuk dapat mengupload bukti transfer.</p>
        </div>
    @elseif($buktiTransfer)
        <div class="text-center">
            <div class="mb-4">
                @if($buktiTransfer->status == 'pending')
                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-sm">
                        <i class="ri-time-line mr-1"></i>Menunggu Verifikasi
                    </div>
                @elseif($buktiTransfer->status == 'success')
                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-800 text-sm">
                        <i class="ri-check-line mr-1"></i>Pembayaran Diterima
                    </div>
                @else
                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-800 text-sm">
                        <i class="ri-close-line mr-1"></i>Pembayaran Ditolak
                    </div>
                @endif
            </div>
            
            <div class="mb-4">
                <a href="{{ asset('storage/' . $buktiTransfer->transfer_picture) }}" 
                   target="_blank" 
                   class="inline-block">
                    <img src="{{ asset('storage/' . $buktiTransfer->transfer_picture) }}" 
                         alt="Bukti Transfer" 
                         class="max-w-full h-40 object-cover rounded-lg border border-gray-300 hover:shadow-lg transition">
                </a>
                <p class="text-gray-500 font-medium">Atas Nama: {{ $buktiTransfer->atas_nama }}</p>
                <p class="text-gray-500 font-medium">No Rekening: {{ $buktiTransfer->no_rek }}</p>
            </div>
            
            @if($buktiTransfer->status != 'success')
                <button wire:click="deleteBuktiTransfer" 
                        onclick="return confirm('Yakin ingin menghapus bukti transfer?')"
                        class="text-red-600 hover:text-red-800 text-sm">
                    <i class="ri-delete-bin-line mr-1"></i>Hapus & Upload Ulang
                </button>
            @endif
        </div>
    @else
        <form wire:submit.prevent="uploadBuktiTransfer" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Upload Bukti Transfer *
                </label>
                <input type="file" 
                       wire:model="transfer_picture" 
                       accept="image/*"
                       class="block w-full border border-gray-300 rounded-md px-3 py-2 text-sm
                       file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm 
                       file:font-semibold file:bg-lime-50 file:text-lime-700 
                       hover:file:bg-lime-100 @error('transfer_picture') border-red-500 @enderror">
                @error('transfer_picture')
                    <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span>
                @enderror
                @if($transfer_picture)
                    <div class="mt-2 text-sm text-lime-600 flex items-center gap-1">
                        <i class="ri-check-line"></i>
                        File terpilih: {{ $transfer_picture->getClientOriginalName() }}
                    </div>
                @endif
            </div>
            <x-molecules.input-field name="atas_nama" wire:model='atas_nama' id="atas_nama" label="Atas Nama" inputType="text" placeholder="Atas Nama sesuai bank/e-wallet pengirim" :required="true" />
            <x-molecules.input-field name="no_rek" wire:model='no_rek' id="no_rek" label="No Rekening/E-Wallet" inputType="text" placeholder="Nomor rekening/e-wallet pengirim" :required="true" />
            
            <div class="text-center">
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-lime-600 text-white rounded-md hover:bg-lime-700 transition"
                        wire:loading.attr="disabled">
                    <i class="ri-upload-line mr-1"></i>
                    <span wire:loading.remove>Upload Bukti</span>
                    <span wire:loading>Mengupload...</span>
                </button>
            </div>
        </form>
    @endif
</div>