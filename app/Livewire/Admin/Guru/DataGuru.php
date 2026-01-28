<?php

namespace App\Livewire\Admin\Guru;

use App\Models\Mapel;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.admin")]
#[Title("Data Guru")]
class DataGuru extends Component
{
    use WithPagination;
    
    public $search = '';

    public $mapels;
    public $name, $email, $telp, $password, $password_confirmation, $mapel_id;
    
    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'telp' => 'nullable|string|max:20',
        'password' => 'required|string|min:8|confirmed',
        'mapel_id' => 'nullable|exists:mapels,id',

    ];
    
    protected $messages = [
        'name.required' => 'Nama wajib diisi',
        'email.required' => 'Email wajib diisi',
        'email.email' => 'Format email tidak valid',
        'email.unique' => 'Email sudah digunakan',
        'password.required' => 'Password wajib diisi',
        'password.min' => 'Password minimal 8 karakter',
        'password.confirmed' => 'Konfirmasi password tidak cocok',
    ];

    public function mount()
    {
        $this->mapels = Mapel::all();
    }
    
    public function openCreateModal()
    {
        $this->resetForm();
        $this->dispatch('open-modal', name: 'create-guru');
    }
    
    public function closeCreateModal()
    {
        $this->dispatch('close-modal', name: 'create-guru');
        $this->resetForm();
    }
    
    public function detail($id){
        return redirect()->route('admin.guru.detail', $id);
    }
    
    public function resetForm()
    {
        $this->reset(['name', 'email', 'telp', 'password', 'password_confirmation', 'mapel_id']);
        $this->resetErrorBag();
    }
    
    public function createGuru()
    {
        $this->validate();
        
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'telp' => $this->telp,
            'role' => 'guru',
            'password' => bcrypt($this->password),
            'mapel_id' => $this->mapel_id
        ]);
        
        $this->closeCreateModal();
        $this->dispatch("alert", message: "Berhasil menambahkan guru", type: "success");
        
        $this->resetPage();
    }
    
    public function deleteGuru($id)
    {
        $guru = User::findOrFail($id);
        
        if ($guru->role !== 'guru') {
            $this->dispatch("alert", message: "Hanya dapat menghapus akun guru.", type: "warning");
            return;
        }
        
        $guru->delete();
        $this->dispatch("alert", message: "Berhasil menghapus admin", type: "success");
    }
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $gurus = User::where('role', 'guru', 'mapel')
            ->where(function ($query) {
                $query
                    ->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('telp', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);
        
        return view('livewire.admin.guru.data-guru', ['gurus' => $gurus, "mapels" => $this->mapels]);
    }
}