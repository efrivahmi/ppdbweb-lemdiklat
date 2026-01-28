<?php

namespace App\Models\Landing;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class YoutubeVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'title',
        'description',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Scope untuk mendapatkan video yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk mendapatkan video dengan urutan
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('created_at', 'desc');
    }

    /**
     * Extract video ID from YouTube URL
     * Support berbagai format:
     * - https://www.youtube.com/watch?v=VIDEO_ID
     * - https://youtu.be/VIDEO_ID
     * - https://www.youtube.com/embed/VIDEO_ID
     */
    public function getVideoId()
    {
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/';
        
        if (preg_match($pattern, $this->url, $matches)) {
            return $matches[1];
        }
        
        return null;
    }

    /**
     * Get YouTube thumbnail URL
     * Menggunakan sddefault untuk thumbnail yang lebih reliable (640x480)
     * sddefault selalu tersedia untuk semua video YouTube
     */
    public function getThumbnailUrl()
    {
        $videoId = $this->getVideoId();

        if ($videoId) {
            return "https://img.youtube.com/vi/{$videoId}/sddefault.jpg";
        }

        return null;
    }

    /**
     * Get YouTube embed URL
     */
    public function getEmbedUrl()
    {
        $videoId = $this->getVideoId();
        
        if ($videoId) {
            return "https://www.youtube.com/embed/{$videoId}";
        }
        
        return null;
    }

    /**
     * Get YouTube watch URL (normalized)
     */
    public function getWatchUrl()
    {
        $videoId = $this->getVideoId();
        
        if ($videoId) {
            return "https://www.youtube.com/watch?v={$videoId}";
        }
        
        return $this->url;
    }

    /**
     * Accessor untuk thumbnail
     */
    public function getThumbnailAttribute()
    {
        return $this->getThumbnailUrl();
    }

    /**
     * Accessor untuk embed URL
     */
    public function getEmbedUrlAttribute()
    {
        return $this->getEmbedUrl();
    }

    /**
     * Accessor untuk watch URL
     */
    public function getWatchUrlAttribute()
    {
        return $this->getWatchUrl();
    }

    /**
     * Accessor untuk video ID
     */
    public function getVideoIdAttribute()
    {
        return $this->getVideoId();
    }

    /**
     * Check if URL is valid YouTube URL
     */
    public function isValidYoutubeUrl()
    {
        return $this->getVideoId() !== null;
    }

    /**
     * Static method untuk validasi URL YouTube
     */
    public static function validateYoutubeUrl($url)
    {
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/';
        return preg_match($pattern, $url) === 1;
    }
}
