<?php

namespace App\Livewire\Landing\Pages;

use Livewire\Component;
use App\Models\Landing\Persyaratan;

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
#[Layout("layouts.landing")]
#[Title("Lemdiklat Taruna Nusantara Indonesia")]
class Requirement extends Component
{
    public function getPhysicalRequirementsProperty()
    {
        $physicalData = Persyaratan::getPhysicalRequirements();
        
        $requirements = [];
        
        $maleHeight = $physicalData['male']->where('title', 'Tinggi Badan Minimal')->first();
        $maleWeight = $physicalData['male']->where('title', 'Berat Badan Minimal')->first();
        
        if ($maleHeight && $maleWeight) {
            $requirements[] = [
                'gender' => 'Laki-laki',
                'height' => $maleHeight->formatted_value,
                'weight' => $maleWeight->formatted_value,
                'color' => $maleHeight->color ?? 'blue'
            ];
        }
        
        $femaleHeight = $physicalData['female']->where('title', 'Tinggi Badan Minimal')->first();
        $femaleWeight = $physicalData['female']->where('title', 'Berat Badan Minimal')->first();
        
        if ($femaleHeight && $femaleWeight) {
            $requirements[] = [
                'gender' => 'Perempuan',
                'height' => $femaleHeight->formatted_value,
                'weight' => $femaleWeight->formatted_value,
                'color' => $femaleHeight->color ?? 'pink'
            ];
        }
        
        if (empty($requirements)) {
            $requirements = [
                [
                    'gender' => 'Laki-laki',
                    'height' => '155 CM',
                    'weight' => '45 KG',
                    'color' => 'blue'
                ],
                [
                    'gender' => 'Perempuan',
                    'height' => '145 CM',
                    'weight' => '35 KG',
                    'color' => 'pink'
                ]
            ];
        }
        
        return collect($requirements);
    }

    public function getDocumentsProperty()
    {
        $documents = Persyaratan::getDocumentRequirements();
        
        if ($documents->isNotEmpty()) {
            return $documents->map(function ($document) {
                return [
                    'id' => $document->id,
                    'title' => $document->title,
                    'quantity' => $document->formatted_value,
                    'description' => $document->description
                ];
            });
        }
        
        return collect([
            [
                'title' => 'Fotokopi Akta Kelahiran',
                'quantity' => '15 lembar'
            ],
            [
                'title' => 'Fotokopi Kartu Keluarga',
                'quantity' => '15 lembar'
            ],
            [
                'title' => 'Fotokopi KTP Ayah dan Ibu',
                'quantity' => '15 lembar'
            ],
            [
                'title' => 'Fotokopi Ijazah SD',
                'quantity' => '15 lembar'
            ],
            [
                'title' => 'Fotokopi Ijazah SMP (yang sudah dilegalisir)',
                'quantity' => '15 lembar'
            ],
            [
                'title' => 'Pas Foto 3x4 Latar Merah (menggunakan seragam SMP/MTs)',
                'quantity' => '5 lembar'
            ],
            [
                'title' => 'Surat Keterangan Kelakuan Baik (1 asli dan 4 fotokopi)',
                'quantity' => '5 lembar'
            ],
            [
                'title' => 'Surat Keterangan Sehat dari dokter (asli)',
                'quantity' => '1 lembar'
            ],
            [
                'title' => 'Bukti Pendaftaran Online (sudah ditandatangani)',
                'quantity' => '1 lembar'
            ],
            [
                'title' => 'Materai @ Rp 10.000',
                'quantity' => '3 buah'
            ]
        ]);
    }

    public function render()
    {
        return view('livewire.landing.pages.requirement', [
            'physicalRequirements' => $this->physicalRequirements,
            'documents' => $this->documents,
        ]);
    }
}