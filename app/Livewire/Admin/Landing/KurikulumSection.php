<?php

namespace App\Livewire\Admin\Landing;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Landing\Kurikulum;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout("layouts.admin")]
#[Title("Kurikulum")]
class KurikulumSection extends Component
{
    use WithFileUploads;

    // Data umum
    public $badge_text;
    public $badge_variant;
    public $badge_size;
    public $title_text;
    public $title_highlight;
    public $title_size;
    public $title_class;
    public $descriptions;

    // Gambar utama
    public $image;
    public $image_url;
    public $image_title;
    public $image_description;

    // Empat foto wajib
    public $photo_1;
    public $photo_2;
    public $photo_3;

    public $photo_1_url;
    public $photo_2_url;
    public $photo_3_url;

    public $photo_1_title;
    public $photo_2_title;
    public $photo_3_title;

    public $is_active = true;
    public $isLoading = true;
    public $isSaving = false;

    protected $rules = [
        'badge_text' => 'nullable|string|max:255',
        'badge_variant' => 'nullable|string|max:50',
        'badge_size' => 'nullable|string|max:50',
        'title_text' => 'required|string|max:255',
        'title_highlight' => 'nullable|string|max:255',
        'title_size' => 'nullable|string|max:50',
        'title_class' => 'nullable|string|max:255',
        'descriptions' => 'nullable|string|max:2000',

        // Gambar utama
        'image' => 'nullable|image|max:2048',
        'image_title' => 'nullable|string|max:255',
        'image_description' => 'nullable|string|max:500',

        // Foto tambahan
        'photo_1' => 'nullable|image|max:2048',
        'photo_2' => 'nullable|image|max:2048',
        'photo_3' => 'nullable|image|max:2048',

        'photo_1_title' => 'nullable|string|max:255',
        'photo_2_title' => 'nullable|string|max:255',
        'photo_3_title' => 'nullable|string|max:255',

        'is_active' => 'boolean',
    ];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->isLoading = true;
        $record = Kurikulum::where('is_single', true)->first();
        if ($record) {
            $this->fill($record->toArray());
        }
        $this->isLoading = false;
    }

    public function save()
    {
        $this->validate();
        $this->isSaving = true;

        // Upload gambar utama
        if ($this->image) {
            $path = $this->image->store('uploads/kurikulum', 'public');
            $this->image_url = '/storage/' . $path;
        }

        // Upload empat foto wajib
        if ($this->photo_1) $this->photo_1_url = '/storage/' . $this->photo_1->store('uploads/kurikulum', 'public');
        if ($this->photo_2) $this->photo_2_url = '/storage/' . $this->photo_2->store('uploads/kurikulum', 'public');
        if ($this->photo_3) $this->photo_3_url = '/storage/' . $this->photo_3->store('uploads/kurikulum', 'public');

        Kurikulum::updateOrCreate(
            ['is_single' => true],
            [
                'badge_text' => $this->badge_text,
                'badge_variant' => $this->badge_variant,
                'badge_size' => $this->badge_size,
                'title_text' => $this->title_text,
                'title_highlight' => $this->title_highlight,
                'title_size' => $this->title_size,
                'title_class' => $this->title_class,
                'descriptions' => $this->descriptions,

                'image_url' => $this->image_url,
                'image_title' => $this->image_title,
                'image_description' => $this->image_description,

                'photo_1_url' => $this->photo_1_url,
                'photo_2_url' => $this->photo_2_url,
                'photo_3_url' => $this->photo_3_url,

                'photo_1_title' => $this->photo_1_title,
                'photo_2_title' => $this->photo_2_title,
                'photo_3_title' => $this->photo_3_title,

                'is_active' => $this->is_active,
                'is_single' => true,
            ]
        );

        $this->isSaving = false;
        session()->flash('success', 'Kurikulum berhasil disimpan!');
        $this->loadData();
    }

    public function render()
    {
        return view('livewire.admin.landing.kurikulum-section', [
            'kurikulum' => Kurikulum::first(),
        ]);
    }
}
