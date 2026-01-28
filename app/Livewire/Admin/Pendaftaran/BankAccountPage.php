<?php

namespace App\Livewire\Admin\Pendaftaran;

use App\Models\BankAccount;
use Livewire\Component;
use Livewire\WithPagination;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.admin")]
#[Title("Rekening Bank")]
class BankAccountPage extends Component
{
    use WithPagination;
    
    public $search = '';
    public $editMode = false;
    public $selectedId = null;
    
    public $bank_name, $account_number, $account_holder;
    
    protected $rules = [
        'bank_name' => 'required|string|max:100',
        'account_number' => 'required|string|max:50',
        'account_holder' => 'required|string|max:100',
    ];
    
    protected $messages = [
        'bank_name.required' => 'Nama bank wajib diisi',
        'bank_name.max' => 'Nama bank maksimal 100 karakter',
        'account_number.required' => 'Nomor rekening wajib diisi',
        'account_number.max' => 'Nomor rekening maksimal 50 karakter',
        'account_holder.required' => 'Nama pemegang rekening wajib diisi',
        'account_holder.max' => 'Nama pemegang rekening maksimal 100 karakter',
    ];
    
    public function openModal()
    {
        $this->dispatch('open-modal', name: 'bank-account');
    }
    
    public function closeModal()
    {
        $this->dispatch('close-modal', name: 'bank-account');
        $this->resetForm();
    }
    
    public function resetForm()
    {
        $this->reset(['bank_name', 'account_number', 'account_holder', 'editMode', 'selectedId']);
        $this->resetErrorBag();
    }
    
    public function create()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->openModal();
    }
    
    public function edit($id)
    {
        $bankAccount = BankAccount::findOrFail($id);
        $this->selectedId = $id;
        $this->bank_name = $bankAccount->bank_name;
        $this->account_number = $bankAccount->account_number;
        $this->account_holder = $bankAccount->account_holder;
        $this->editMode = true;
        $this->openModal();
    }
    
    public function save()
    {
        $this->validate();
        
        if ($this->editMode) {
            $bankAccount = BankAccount::findOrFail($this->selectedId);
            $bankAccount->update([
                'bank_name' => $this->bank_name,
                'account_number' => $this->account_number,
                'account_holder' => $this->account_holder,
            ]);
            $message = 'Rekening bank berhasil diperbarui';
        } else {
            BankAccount::create([
                'bank_name' => $this->bank_name,
                'account_number' => $this->account_number,
                'account_holder' => $this->account_holder,
            ]);
            $message = 'Rekening bank berhasil ditambahkan';
        }
        
        $this->closeModal();
        $this->dispatch("alert", message: $message, type: "success");
        
        $this->resetPage();
    }
    
    public function delete($id)
    {
        try {
            $bankAccount = BankAccount::findOrFail($id);
            $bankAccount->delete();
            $this->dispatch("alert", message: "Rekening berhasil di hapus", type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Tidak dapat menghapus rekening", type: "error");
        }
    }
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $bankAccounts = BankAccount::where(function($query) {
                $query->where('bank_name', 'like', '%' . $this->search . '%')
                      ->orWhere('account_number', 'like', '%' . $this->search . '%')
                      ->orWhere('account_holder', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);
        
        return view('livewire.admin.pendaftaran.bank-account-page', ['bankAccounts' => $bankAccounts]);
    }
}