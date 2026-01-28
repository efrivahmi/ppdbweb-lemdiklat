<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.auth")]
#[Title("Login")]
class LoginPage extends Component
{

    public $credentials, $password;
    protected $rules = [
        "credentials" => "required",
        "password" => "required",
    ];

    protected $messages = [
        "credentials.required" => "Email atau NISN harus diisi",
        "password.required" => "Password harus diisi",
    ];
    public function render()
    {
        return view('livewire.auth.login-page');
    }

    public function login()
    {
        $this->validate();
        $user = User::where('email', $this->credentials)->orWhere('nisn', $this->credentials)->first();
        // Jika user tidak ditemukan
        if(!$user) {
            $this->dispatch("alert", message: "Email atau NISN tidak ditemukan", type: "error");
        } elseif(!Hash::check($this->password, $user->password)) {
            // Jika password tidak sama
            $this->dispatch("alert", message: "Password salah", type: "error");
        } else {
            Auth::login($user);
            // Cek Role
            if($user->isAdmin()){
                return redirect()->route('admin.dashboard');
            } elseif($user->isGuru()){
                return redirect()->route('guru.dashboard');
            } else {
                return redirect()->route('siswa.dashboard');
            }
        }
    }
}
