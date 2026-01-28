<?php

namespace App\Models\Landing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class VisiMisi extends Model
{
    use HasFactory;
    protected $table = 'visi_misi';

    protected $fillable = [
        'type',
        'title',
        'content',
        'item_title',
        'item_description',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    // Scopes
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeVisi(Builder $query): Builder
    {
        return $query->where('type', 'visi');
    }

    public function scopeMisi(Builder $query): Builder
    {
        return $query->where('type', 'misi');
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order', 'asc');
    }

    // Static Methods
    public static function getVisiData(): array
    {
        $visiMain = self::active()->visi()->whereNull('item_title')->first();
        $visiItems = self::active()->visi()->whereNotNull('item_title')->ordered()->get();

        return [
            'title' => $visiMain?->title ?? 'Visi Kami',
            'content' => $visiMain?->content ?? '',
            'items' => $visiItems->map(function ($item) {
                return [
                    'title' => $item->item_title,
                    'description' => $item->item_description
                ];
            })->toArray()
        ];
    }

    public static function getMisiData(): array
    {
        $misiMain = self::active()->misi()->whereNull('item_title')->first();
        $misiItems = self::active()->misi()->whereNotNull('item_title')->ordered()->get();

        return [
            'title' => $misiMain?->title ?? 'Misi Kami',
            'content' => $misiMain?->content ?? '',
            'items' => $misiItems->map(function ($item) {
                return [
                    'title' => $item->item_title,
                    'description' => $item->item_description
                ];
            })->toArray()
        ];
    }

    public static function getAllData(): array
    {
        return [
            'visi' => self::getVisiData(),
            'misi' => self::getMisiData()
        ];
    }

    // Helper Methods
    public function isVisi(): bool
    {
        return $this->type === 'visi';
    }

    public function isMisi(): bool
    {
        return $this->type === 'misi';
    }

    public function isMainContent(): bool
    {
        return is_null($this->item_title);
    }

    public function isItemContent(): bool
    {
        return !is_null($this->item_title);
    }
}