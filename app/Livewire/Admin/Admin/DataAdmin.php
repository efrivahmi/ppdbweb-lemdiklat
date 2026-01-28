<?php

namespace App\Livewire\Admin\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.admin")]
#[Title("Data Admin")]
class DataAdmin extends Component
{
    use WithPagination;
    
    public $search = '';
    
    public $name, $email, $telp, $password, $password_confirmation;
    
    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'telp' => 'nullable|string|max:20',
        'password' => 'required|string|min:8|confirmed',
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
    
    public function openCreateModal()
    {
        $this->resetForm();
        $this->dispatch('open-modal', name: 'create-admin');
    }
    
    public function closeCreateModal()
    {
        $this->dispatch('close-modal', name: 'create-admin');
        $this->resetForm();
    }
    public function detail($id){
        return redirect()->route('admin.admin.detail', $id);
    }
    
    public function resetForm()
    {
        $this->reset(['name', 'email', 'telp', 'password', 'password_confirmation']);
        $this->resetErrorBag();
    }
    
    public function createAdmin()
    {
        $this->validate();
        
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'telp' => $this->telp,
            'role' => 'admin',
            'password' => bcrypt($this->password),
        ]);
        
        $this->closeCreateModal();
        $this->dispatch("alert", message: "Berhasil menambahkan admin", type: "success");
        
        $this->resetPage();
    }
    
    public function deleteAdmin($id)
    {
        $admin = User::findOrFail($id);
        
        if ($admin->id === Auth::id()) {
            $this->dispatch("alert", message: "Tidak dapat menghapus akun sendiri.", type: "warning");
            return;
        }
        
        $admin->delete();
        $this->dispatch("alert", message: "Berhasil menghapus admin", type: "success");
    }
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $admins = User::where('role', 'admin')
            ->where(function ($query) {
                $query
                    ->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('telp', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);
        
        return view('livewire.admin.admin.data-admin', ['admins' => $admins]);
    }
}