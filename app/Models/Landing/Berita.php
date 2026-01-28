<?php
namespace App\Models\Landing;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Berita extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'kategori_id',
        'thumbnail',
        'is_active',
        'is_priority',
        'priority_order',
        'created_by'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_priority' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = Str::slug($model->title);
            $model->created_by = Auth::id();
        });

        static::updating(function ($model) {
            if ($model->isDirty('title')) {
                $model->slug = Str::slug($model->title);
            }
        });
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriBerita::class, 'kategori_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
