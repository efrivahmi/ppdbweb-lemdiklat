<?php

namespace App\Livewire\Admin\Landing;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Landing\ProfileSekolah;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;

#[Title('Video Sambutan')]
class VideoSambutanPage extends Component
{
    use WithFileUploads;

    public $profileId;
    public $video_title;
    public $video_description;
    public $video_is_active = false;
    public $local_video_path; // existing path
    
    public $video_file; // new file to upload

    public function mount()
    {
        $profile = ProfileSekolah::first();
        if ($profile) {
            $this->profileId = $profile->id;
            $this->video_title = $profile->video_title ?? 'Sambutan';
            $this->video_description = $profile->video_description;
            $this->video_is_active = (bool) $profile->video_is_active;
            $this->local_video_path = $profile->local_video_path;
        } else {
            $profile = ProfileSekolah::create(['title' => 'Profile Sekolah', 'content' => '']);
            $this->profileId = $profile->id;
        }
    }

    public function rules()
    {
        return [
            'video_title' => 'nullable|string|max:255',
            'video_description' => 'nullable|string',
            'video_is_active' => 'boolean',
            'video_file' => 'nullable|mimes:mp4,webm,ogg|max:30720', // max 30MB
        ];
    }

    public function messages()
    {
        return [
            'video_file.mimes' => 'Format video harus mp4, webm, atau ogg.',
            'video_file.max' => 'Ukuran video maksimal adalah 30MB.',
        ];
    }

    public function save()
    {
        $this->validate();

        $profile = ProfileSekolah::find($this->profileId);
        
        if ($this->video_file) {
            // Delete old video if exists
            if ($profile->local_video_path && Storage::disk('public')->exists($profile->local_video_path)) {
                Storage::disk('public')->delete($profile->local_video_path);
            }
            
            $path = $this->video_file->store('landing/videos', 'public');
            $profile->local_video_path = $path;
            $this->local_video_path = $path;
        }

        $profile->video_title = $this->video_title;
        $profile->video_description = $this->video_description;
        $profile->video_is_active = $this->video_is_active;
        $profile->save();

        // reset file input
        $this->video_file = null;

        session()->flash('success', 'Pengaturan Video Sambutan berhasil disimpan!');
    }

    public function deleteVideo()
    {
        $profile = ProfileSekolah::find($this->profileId);
        if ($profile->local_video_path && Storage::disk('public')->exists($profile->local_video_path)) {
            Storage::disk('public')->delete($profile->local_video_path);
        }
        $profile->local_video_path = null;
        $profile->save();
        $this->local_video_path = null;
        
        session()->flash('success', 'Video berhasil dihapus!');
    }

    public function render()
    {
        return view('livewire.admin.landing.video-sambutan-page')
            ->layout('layouts.app', ['title' => 'Video Sambutan']);
    }
}
