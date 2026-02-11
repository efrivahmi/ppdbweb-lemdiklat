<?php

namespace App\Livewire\Landing\Pages;

use Livewire\Component;
use App\Models\Landing\Berita;
use App\Models\Landing\BeritaReaction;
use App\Models\Landing\BeritaComment;
use App\Models\Landing\KategoriBerita;
use App\Helpers\SeoHelper;

use Livewire\Attributes\Layout;

#[Layout("layouts.landing")]
class NewsDetail extends Component
{
    public Berita $berita;

    // Comment form
    public string $commentName = '';
    public string $commentMessage = '';
    public bool $commentSubmitted = false;

    protected function rules()
    {
        return [
            'commentName' => 'required|string|max:100',
            'commentMessage' => 'required|string|max:2000',
        ];
    }

    protected $messages = [
        'commentName.required' => 'Nama wajib diisi',
        'commentName.max' => 'Nama maksimal 100 karakter',
        'commentMessage.required' => 'Komentar wajib diisi',
        'commentMessage.max' => 'Komentar maksimal 2000 karakter',
    ];

    public function mount($slug)
    {
        $this->berita = Berita::with(['kategori', 'creator'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Increment views once per session
        $sessionKey = 'berita_viewed_' . $this->berita->id;
        if (!session()->has($sessionKey)) {
            $this->berita->incrementViews();
            session()->put($sessionKey, true);
        }
    }

    public function toggleLike()
    {
        $ip = request()->ip();
        $existing = BeritaReaction::where('berita_id', $this->berita->id)
            ->where('ip_address', $ip)
            ->first();

        if ($existing) {
            if ($existing->reaction === 'like') {
                // Remove like
                $existing->delete();
                $this->berita->decrement('likes_count');
            } else {
                // Switch from dislike to like
                $existing->update(['reaction' => 'like']);
                $this->berita->decrement('dislikes_count');
                $this->berita->increment('likes_count');
            }
        } else {
            // New like
            BeritaReaction::create([
                'berita_id' => $this->berita->id,
                'ip_address' => $ip,
                'reaction' => 'like',
            ]);
            $this->berita->increment('likes_count');
        }

        $this->berita->refresh();
    }

    public function toggleDislike()
    {
        $ip = request()->ip();
        $existing = BeritaReaction::where('berita_id', $this->berita->id)
            ->where('ip_address', $ip)
            ->first();

        if ($existing) {
            if ($existing->reaction === 'dislike') {
                // Remove dislike
                $existing->delete();
                $this->berita->decrement('dislikes_count');
            } else {
                // Switch from like to dislike
                $existing->update(['reaction' => 'dislike']);
                $this->berita->decrement('likes_count');
                $this->berita->increment('dislikes_count');
            }
        } else {
            // New dislike
            BeritaReaction::create([
                'berita_id' => $this->berita->id,
                'ip_address' => $ip,
                'reaction' => 'dislike',
            ]);
            $this->berita->increment('dislikes_count');
        }

        $this->berita->refresh();
    }

    public function submitComment()
    {
        $this->validate();

        BeritaComment::create([
            'berita_id' => $this->berita->id,
            'name' => $this->commentName,
            'message' => $this->commentMessage,
            'ip_address' => request()->ip(),
            'is_approved' => false,
        ]);

        $this->reset(['commentName', 'commentMessage']);
        $this->commentSubmitted = true;
    }

    public function getUserReactionProperty()
    {
        $ip = request()->ip();
        $reaction = BeritaReaction::where('berita_id', $this->berita->id)
            ->where('ip_address', $ip)
            ->first();

        return $reaction ? $reaction->reaction : null;
    }

    public function render()
    {
        $seo = SeoHelper::article($this->berita);

        $comments = $this->berita->approvedComments()
            ->latest()
            ->get();

        $relatedNews = Berita::with('kategori')
            ->where('kategori_id', $this->berita->kategori_id)
            ->where('id', '!=', $this->berita->id)
            ->where('is_active', true)
            ->take(3)
            ->get();

        $latestNews = Berita::where('id', '!=', $this->berita->id)
            ->where('is_active', true)
            ->latest()
            ->take(5)
            ->get();

        $categories = KategoriBerita::where('is_active', true)
            ->withCount(['beritas' => function ($query) {
                $query->where('is_active', true);
            }])
            ->get();

        return view('livewire.landing.pages.news-detail', [
            'berita' => $this->berita,
            'seo' => $seo,
            'article' => $this->berita,
            'comments' => $comments,
            'userReaction' => $this->userReaction,
            'relatedNews' => $relatedNews,
            'latestNews' => $latestNews,
            'categories' => $categories,
        ])->title($this->berita->title . ' - Lemdiklat Taruna Nusantara Indonesia')
          ->layout('layouts.landing', [
              'seo' => $seo,
              'article' => $this->berita,
          ]);
    }
}
