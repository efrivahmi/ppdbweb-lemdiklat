<?php

namespace App\Livewire\Admin\Landing;

use App\Models\Landing\Footer;
use Livewire\Component;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.admin")]
#[Title("Footer")]
class FooterPage extends Component
{
    public $footer;

    // Form properties sesuai dengan database structure
    public $site_title, $site_description, $copyright_text, $is_active = true;
    
    // Social icons
    public $social_icons = [];
    
    // Footer links
    public $footer_links = [];
    
    // Legal links  
    public $legal_links = [];

    protected $rules = [
        'site_title' => 'required|string|max:255',
        'site_description' => 'required|string|max:1000',
        'copyright_text' => 'required|string|max:255',
        'is_active' => 'boolean',
        'social_icons.*.icon' => 'nullable|string|max:50',
        'social_icons.*.href' => 'nullable|url|max:255',
        'social_icons.*.label' => 'nullable|string|max:50',
        'footer_links.*.title' => 'nullable|string|max:100',
        'footer_links.*.links.*.text' => 'nullable|string|max:100',
        'footer_links.*.links.*.href' => 'nullable|string|max:255',
        'legal_links.*.text' => 'nullable|string|max:100',
        'legal_links.*.href' => 'nullable|string|max:255',
    ];

    protected $messages = [
        'site_title.required' => 'Judul situs wajib diisi',
        'site_description.required' => 'Deskripsi situs wajib diisi',
        'copyright_text.required' => 'Teks copyright wajib diisi',
        'social_icons.*.icon.required' => 'Nama icon wajib diisi',
        'social_icons.*.href.required' => 'URL wajib diisi',
        'social_icons.*.href.url' => 'Format URL tidak valid',
        'social_icons.*.label.required' => 'Label wajib diisi',
        'footer_links.*.title.required' => 'Judul section wajib diisi',
        'footer_links.*.links.*.text.required' => 'Teks link wajib diisi',
        'footer_links.*.links.*.href.required' => 'URL link wajib diisi',
        'legal_links.*.text.required' => 'Teks link legal wajib diisi',
        'legal_links.*.href.required' => 'URL link legal wajib diisi',
    ];

    public function mount()
    {
        $this->loadFooter();
    }

    public function loadFooter()
    {
        $this->footer = Footer::first();
        
        if ($this->footer) {
            $this->site_title = $this->footer->site_title;
            $this->site_description = $this->footer->site_description;
            $this->copyright_text = $this->footer->copyright_text;
            $this->is_active = $this->footer->is_active;
            $this->social_icons = $this->footer->social_icons ?: [];
            $this->footer_links = $this->footer->footer_links ?: [];
            $this->legal_links = $this->footer->legal_links ?: [];
        } else {
            $this->setDefaultData();
        }
    }

    public function setDefaultData()
    {
        $this->social_icons = [
            ['icon' => 'twitter', 'href' => '', 'label' => 'Twitter'],
            ['icon' => 'instagram', 'href' => '', 'label' => 'Instagram'],
            ['icon' => 'youtube', 'href' => '', 'label' => 'YouTube'],
            ['icon' => 'facebook', 'href' => '', 'label' => 'Facebook'],
        ];

        $this->footer_links = [
            [
                'title' => 'Informasi',
                'links' => [
                    ['text' => 'Berita', 'href' => '/news'],
                    ['text' => 'Prestasi', 'href' => '/achievement'],
                    ['text' => 'Persyaratan', 'href' => '/requirement']
                ]
            ],
            [
                'title' => 'Akademik',
                'links' => [
                    ['text' => 'Fasilitas', 'href' => '/facility'],
                    ['text' => 'Program Studi', 'href' => '/program-studi'],
                    ['text' => 'Kurikulum', 'href' => '/kurikulum']
                ]
            ],
            [
                'title' => 'Kontak',
                'links' => [
                    ['text' => 'Alamat Sekolah', 'href' => '/kontak'],
                    ['text' => 'Telepon', 'href' => '/kontak'],
                    ['text' => 'Email', 'href' => '/kontak']
                ]
            ]
        ];

        $this->legal_links = [
            ['text' => 'Kebijakan Privasi', 'href' => '/privacy'],
            ['text' => 'Syarat & Ketentuan', 'href' => '/terms']
        ];
    }

    public function openModal()
    {
        $this->dispatch('open-modal', name: 'footer-modal');
    }

    public function closeModal()
    {
        $this->dispatch('close-modal', name: 'footer-modal');
        $this->resetErrorBag();
    }

    public function edit()
    {
        $this->loadFooter();
        $this->resetErrorBag();
        $this->openModal();
    }

    public function addSocialIcon()
    {
        $this->social_icons[] = ['icon' => '', 'href' => '', 'label' => ''];
    }

    public function removeSocialIcon($index)
    {
        unset($this->social_icons[$index]);
        $this->social_icons = array_values($this->social_icons);
    }

    public function addFooterSection()
    {
        $this->footer_links[] = [
            'title' => '',
            'links' => [
                ['text' => '', 'href' => '']
            ]
        ];
    }

    public function removeFooterSection($index)
    {
        unset($this->footer_links[$index]);
        $this->footer_links = array_values($this->footer_links);
    }

    public function addFooterLink($sectionIndex)
    {
        $this->footer_links[$sectionIndex]['links'][] = ['text' => '', 'href' => ''];
    }

    public function removeFooterLink($sectionIndex, $linkIndex)
    {
        unset($this->footer_links[$sectionIndex]['links'][$linkIndex]);
        $this->footer_links[$sectionIndex]['links'] = array_values($this->footer_links[$sectionIndex]['links']);
    }

    public function addLegalLink()
    {
        $this->legal_links[] = ['text' => '', 'href' => ''];
    }

    public function removeLegalLink($index)
    {
        unset($this->legal_links[$index]);
        $this->legal_links = array_values($this->legal_links);
    }

    public function save()
    {
        $this->validate();

        $data = [
            'site_title' => $this->site_title,
            'site_description' => $this->site_description,
            'copyright_text' => $this->copyright_text,
            'social_icons' => array_values(array_filter($this->social_icons, function($item) {
                return !empty($item['icon']) && !empty($item['href']) && !empty($item['label']);
            })),
            'footer_links' => array_values(array_filter($this->footer_links, function($section) {
                return !empty($section['title']) && !empty($section['links']);
            })),
            'legal_links' => array_values(array_filter($this->legal_links, function($item) {
                return !empty($item['text']) && !empty($item['href']);
            })),
            'is_active' => $this->is_active,
        ];

        if ($this->footer) {
            $this->footer->update($data);
            $message = 'Footer berhasil diperbarui';
        } else {
            Footer::create($data);
            $message = 'Footer berhasil dibuat';
        }

        $this->loadFooter();
        $this->closeModal();
        
        session()->flash('success', $message);
        $this->dispatch("alert", message: $message, type: "success");
    }

    public function cancel()
    {
        $this->resetErrorBag();
        $this->loadFooter(); // Reset form to original values
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.admin.landing.footer-page');
    }
}