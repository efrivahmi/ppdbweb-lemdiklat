<?php

namespace App\Livewire\Admin\Landing;

use App\Models\Landing\About;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.admin")]
#[Title("Tentang Sekolah")]
class AboutPage extends Component
{
    use WithFileUploads;
    
    public $aboutRecord;
    public $isLoading = true;
    public $isSaving = false;

    // Badge properties
    public $badge_text = 'Tentang Kami';

    // Title properties
    public $title_text;
    public $title_highlight;
    public $title_class_name = 'lg:text-5xl';

    // Content properties
    public $description = '';

    // Image properties
    public $image_url;
    public $image_title;
    public $image_description;
    public $new_image;

    // Contact properties - Fixed 2 contacts
    public $contact_1_icon = 'MapPinIcon';
    public $contact_1_text = '';
    public $contact_2_icon = 'PhoneIcon';
    public $contact_2_text = '';

    // Status properties
    public $is_active = true;

    protected $rules = [
        'badge_text' => 'required|string|max:50',
        'title_text' => 'required|string|max:255',
        'title_highlight' => 'nullable|string|max:100',
        'title_class_name' => 'nullable|string|max:100',
        'description' => 'required|string|max:2000',
        'image_url' => 'nullable|string',
        'image_title' => 'required|string|max:255',
        'image_description' => 'nullable|string|max:500',
        'new_image' => 'nullable|image|max:2048',
        'contact_1_icon' => 'required|string',
        'contact_1_text' => 'nullable|string|max:255',
        'contact_2_icon' => 'required|string',
        'contact_2_text' => 'nullable|string|max:255',
        'is_active' => 'required|boolean',
    ];

    protected $messages = [
        'badge_text.required' => 'Teks badge wajib diisi',
        'badge_text.max' => 'Teks badge maksimal 50 karakter',
        'title_text.required' => 'Judul wajib diisi',
        'title_text.max' => 'Judul maksimal 255 karakter',
        'description.required' => 'Deskripsi wajib diisi',
        'description.max' => 'Deskripsi maksimal 2000 karakter',
        'image_title.required' => 'Judul gambar wajib diisi',
        'new_image.image' => 'File harus berupa gambar',
        'new_image.max' => 'Ukuran gambar maksimal 2MB',
        'contact_1_icon.required' => 'Icon kontak pertama wajib dipilih',
        'contact_1_text.max' => 'Teks kontak pertama maksimal 255 karakter',
        'contact_2_icon.required' => 'Icon kontak kedua wajib dipilih',
        'contact_2_text.max' => 'Teks kontak kedua maksimal 255 karakter',
    ];

    public function mount()
    {
        // Set default contact icons
        $this->contact_1_icon = 'MapPinIcon';
        $this->contact_2_icon = 'PhoneIcon';
        
        $this->loadData();
    }

    public function loadData()
    {
        try {
            $this->isLoading = true;
            
            // Get or create single record
            $this->aboutRecord = About::getSingle();
            
            if ($this->aboutRecord) {
                $this->loadFromRecord($this->aboutRecord);
            }
            
            $this->isLoading = false;
        } catch (\Exception $e) {
            $this->isLoading = false;
            $this->dispatch("alert", message: "Gagal memuat data.", type: "error");
        }
    }

    private function loadFromRecord($record)
    {
        // Badge data
        $this->badge_text = $record->badge_text;
        
        // Title data
        $this->title_text = $record->title_text;
        $this->title_highlight = $record->title_highlight;
        $this->title_class_name = $record->title_class_name;
        
        // Content data
        $this->description = $record->description ?? '';
        
        // Image data
        $this->image_url = $record->image_url;
        $this->image_title = $record->image_title;
        $this->image_description = $record->image_description;
        
        // Contact data - Load fixed 2 contacts only
        $contactInfo = $record->contact_info ?? [];
        
        // Initialize with defaults
        $this->contact_1_icon = 'MapPinIcon';
        $this->contact_1_text = '';
        $this->contact_2_icon = 'PhoneIcon';
        $this->contact_2_text = '';
        
        // Load contact 1 if exists
        if (isset($contactInfo[0])) {
            $this->contact_1_icon = $contactInfo[0]['icon'] ?? 'MapPinIcon';
            $this->contact_1_text = $contactInfo[0]['text'] ?? '';
        }
        
        // Load contact 2 if exists
        if (isset($contactInfo[1])) {
            $this->contact_2_icon = $contactInfo[1]['icon'] ?? 'PhoneIcon';
            $this->contact_2_text = $contactInfo[1]['text'] ?? '';
        }
        
        // Status data
        $this->is_active = $record->is_active;
    }

    public function save()
    {
        try {
            $this->isSaving = true;
            $this->validate();

            // Prepare contact info array from fixed contacts
            $contactInfo = [];
            
            // Add contact 1 if text is not empty
            if (trim($this->contact_1_text) !== '') {
                $contactInfo[] = [
                    'icon' => $this->contact_1_icon,
                    'text' => trim($this->contact_1_text)
                ];
            }
            
            // Add contact 2 if text is not empty
            if (trim($this->contact_2_text) !== '') {
                $contactInfo[] = [
                    'icon' => $this->contact_2_icon,
                    'text' => trim($this->contact_2_text)
                ];
            }

            $data = [
                'badge_text' => $this->badge_text,
                'title_text' => $this->title_text,
                'title_highlight' => $this->title_highlight,
                'title_class_name' => $this->title_class_name,
                'description' => $this->description,
                'image_title' => $this->image_title,
                'image_description' => $this->image_description,
                'contact_info' => $contactInfo,
                'is_active' => $this->is_active,
                'is_single' => true,
            ];

            // Handle image upload
            if ($this->new_image) {
                $imagePath = $this->new_image->store('about', 'public');
                $data['image_url'] = asset('storage/' . $imagePath);
            } else {
                $data['image_url'] = $this->image_url;
            }

            // Update single record
            $this->aboutRecord = About::updateSingle($data);
            
            $this->new_image = null;
            $this->isSaving = false;
            $this->dispatch("alert", message: "Data sekolah berhasil disimpan.", type: "success");
            
        } catch (\Exception $e) {
            $this->isSaving = false;
            $this->dispatch("alert", message: "Data sekolah gagal disimpan.", type: "error");
        }
    }

    public function resetToDefault()
    {
        try {
            $defaultData = About::getDefaultData();
            About::updateSingle($defaultData);
            $this->loadData();
            $this->dispatch("alert", message: "Data sekolah di reset ke default", type: "success");
        } catch (\Exception $e) {
            $this->dispatch("alert", message: "Gagal reset data sekolah.", type: "error");
        }
    }

    public function render()
    {
        return view('livewire.admin.landing.about-page');
    }
}