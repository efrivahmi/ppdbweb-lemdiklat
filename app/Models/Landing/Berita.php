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
        'description',
        'kategori_id',
        'thumbnail',
        'is_active',
        'is_priority',
        'priority_order',
        'views_count',
        'likes_count',
        'dislikes_count',
        'created_by'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_priority' => 'boolean',
        'views_count' => 'integer',
        'likes_count' => 'integer',
        'dislikes_count' => 'integer',
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

    public function reactions()
    {
        return $this->hasMany(BeritaReaction::class);
    }

    public function comments()
    {
        return $this->hasMany(BeritaComment::class);
    }

    public function approvedComments()
    {
        return $this->hasMany(BeritaComment::class)->where('is_approved', true);
    }

    /**
     * Get short excerpt: description if set, else truncated content.
     */
    public function getExcerptAttribute(): string
    {
        if (!empty($this->description)) {
            return $this->description;
        }

        return \Illuminate\Support\Str::limit(strip_tags($this->content), 160);
    }

    /**
     * Increment view count (call once per session).
     */
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
