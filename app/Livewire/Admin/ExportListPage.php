<?php

namespace App\Livewire\Admin;

use App\Models\Admin\ExportJob;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class ExportListPage extends Component
{
    use WithPagination;

    public $search = '';

    public function delete($id)
    {
        $job = ExportJob::findOrFail($id);
        
        if ($job->file_path && Storage::disk('public')->exists($job->file_path)) {
            Storage::disk('public')->delete($job->file_path);
        }
        
        $job->delete();
        $this->dispatch('alert', message: 'Riwayat ekspor berhasil dihapus', type: 'success');
    }

    public function render()
    {
        $jobs = ExportJob::where('user_id', auth()->id())
            ->where(function($q) {
                $q->where('filename', 'like', '%' . $this->search . '%')
                  ->orWhere('type', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.export-list-page', compact('jobs'))
            ->layout('layouts.admin', ['title' => 'Hasil Ekspor Data']);
    }
}
