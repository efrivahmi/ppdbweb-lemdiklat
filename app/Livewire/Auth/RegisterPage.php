<?php

namespace App\Livewire\Auth;

use App\Models\Siswa\BerkasMurid;
use App\Models\Siswa\DataMurid;
use App\Models\Siswa\DataOrangTua;
use App\Models\User;
use App\Models\GelombangPendaftaran;
use App\Services\NotificationService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.auth")]
#[Title("Register")]
class RegisterPage extends Component
{
    public $name, $email, $nisn, $telp, $password, $password_confirmation;

    protected $rules = [
        "name" => "required|string|max:100",
        "email" => "required|email|unique:users,email",
        "nisn" => "required|numeric|unique:users,nisn|digits:10",
        "telp" => "required|string|max:15",
        "password" => "required|string|min:6|confirmed"
    ];

    protected $messages = [
        'name.required' => 'Nama wajib diisi.',
        'name.string' => 'Nama harus berupa teks.',
        'name.max' => 'Nama maksimal 100 karakter.',

        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email sudah terdaftar.',

        'nisn.required' => 'NISN wajib diisi.',
        'nisn.numeric' => 'NISN harus berupa angka.',
        'nisn.unique' => 'NISN sudah digunakan.',
        'nisn.digits' => 'NISN harus 10 digit',

        'telp.required' => 'Nomor telepon wajib diisi.',
        'telp.string' => 'Nomor telepon harus berupa teks.',
        'telp.max' => 'Nomor telepon maksimal 15 karakter.',

        'password.required' => 'Password wajib diisi.',
        'password.string' => 'Password harus berupa teks.',
        'password.min' => 'Password minimal 6 karakter.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.',
    ];

    public function render()
    {
        // Ambil gelombang yang sedang dalam periode pendaftaran
        $gelombangActive = GelombangPendaftaran::pendaftaranAktif()->first();
        
        return view('livewire.auth.register-page', [
            'gelombangActive' => $gelombangActive
        ]);
    }

    public function register(NotificationService $notificationService)
    {
        // Cek apakah pendaftaran masih buka
        $gelombangActive = GelombangPendaftaran::pendaftaranAktif()->first();
        
        if (!$gelombangActive || !$gelombangActive->isPendaftaranAktif()) {
            $this->dispatch("alert", message: "Pendaftaran sudah ditutup atau belum dibuka.", type: "error");
            return;
        }

        $this->validate();

        $user = DB::transaction(function () {
            $user = User::create([
                "name"=> $this->name,
                "email"=> $this->email,
                "nisn" => $this->nisn,
                "telp" => $this->telp,
                "password" => Hash::make($this->password),
                "role" => "siswa"
            ]);

            $id = $user->id;

            DataMurid::create([
                "user_id" => $id,
                "proses" => "0"
            ]);

            DataOrangTua::create([
                "user_id" => $id
            ]);

            BerkasMurid::create([
                "user_id" => $id
            ]);

            return $user;
        });

        // Send notifications (real-time + WhatsApp)
        $notificationService->notifyNewRegistration($user);

        $this->dispatch("alert", message: "Pendaftaran berhasil! Silakan login untuk melanjutkan.", type: "success");
        return redirect()->route('login');
    }
}