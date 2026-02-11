<?php

namespace App\Helpers;

class SeoHelper
{
    /**
     * Get default SEO metadata
     */
    public static function defaults(): array
    {
        return [
            'title' => config('app.seo.default_title', 'Lemdiklat Taruna Nusantara Indonesia - Pusat Informasi Pendidikan'),
            'description' => config('app.seo.default_description', 'Website Resmi Lemdiklat Taruna Nusantara Indonesia. Pusat informasi Penerimaan Peserta Didik Baru (PPDB), profil SMA Taruna Nusantara, kurikulum pendidikan karakter, dan berita terbaru.'),
            'keywords' => config('app.seo.default_keywords', 'lemdiklat taruna nusantara indonesia, sma taruna nusantara, ppdb sma tn, sekolah unggulan, pendidikan karakter, magelang, asrama taruna nusantara'),
            'author' => config('app.seo.author', 'Lemdiklat Taruna Nusantara Indonesia'),
            'image' => config('app.seo.default_image', asset('assets/logo.png')),
            'url' => config('app.url'),
            'type' => 'website',
            'locale' => 'id_ID',
        ];
    }

    /**
     * Generate page-specific SEO metadata
     */
    public static function page(string $title, ?string $description = null, ?array $options = []): array
    {
        $defaults = self::defaults();
        $fullTitle = $title . ' - ' . $defaults['title'];

        return array_merge($defaults, [
            'title' => $fullTitle,
            'description' => $description ?? $defaults['description'],
        ], $options);
    }

    /**
     * Generate SEO metadata for news article
     */
    public static function article(object $article): array
    {
        $defaults = self::defaults();

        return [
            'title' => $article->title . ' - ' . $defaults['title'],
            'description' => strip_tags(substr($article->content, 0, 160)),
            'keywords' => $article->kategori->name ?? $defaults['keywords'],
            'author' => $article->creator->name ?? $defaults['author'],
            'image' => $article->thumbnail ? (str_starts_with($article->thumbnail, 'http') ? $article->thumbnail : asset('storage/' . $article->thumbnail)) : $defaults['image'],
            'url' => url('/news/' . $article->slug),
            'type' => 'article',
            'locale' => $defaults['locale'],
            'published_time' => $article->created_at->toIso8601String(),
            'modified_time' => $article->updated_at->toIso8601String(),
        ];
    }

    /**
     * Generate meta tags HTML
     */
    public static function metaTags(array $seo): string
    {
        $html = [];

        // Basic meta tags
        $html[] = '<meta charset="UTF-8">';
        $html[] = '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $html[] = '<meta name="description" content="' . htmlspecialchars($seo['description']) . '">';
        $html[] = '<meta name="keywords" content="' . htmlspecialchars($seo['keywords'] ?? '') . '">';
        $html[] = '<meta name="author" content="' . htmlspecialchars($seo['author'] ?? '') . '">';
        $html[] = '<meta name="robots" content="index, follow">';

        // Open Graph / Facebook
        $html[] = '<meta property="og:type" content="' . $seo['type'] . '">';
        $html[] = '<meta property="og:url" content="' . $seo['url'] . '">';
        $html[] = '<meta property="og:title" content="' . htmlspecialchars($seo['title']) . '">';
        $html[] = '<meta property="og:description" content="' . htmlspecialchars($seo['description']) . '">';
        $html[] = '<meta property="og:image" content="' . $seo['image'] . '">';
        $html[] = '<meta property="og:locale" content="' . $seo['locale'] . '">';
        $html[] = '<meta property="og:site_name" content="Lemdiklat Taruna Nusantara Indonesia">';

        // Article-specific Open Graph tags
        if ($seo['type'] === 'article' && isset($seo['published_time'])) {
            $html[] = '<meta property="article:published_time" content="' . $seo['published_time'] . '">';
            $html[] = '<meta property="article:modified_time" content="' . $seo['modified_time'] . '">';
            if (isset($seo['author'])) {
                $html[] = '<meta property="article:author" content="' . htmlspecialchars($seo['author']) . '">';
            }
        }

        // Twitter Card
        $html[] = '<meta name="twitter:card" content="summary_large_image">';
        $html[] = '<meta name="twitter:url" content="' . $seo['url'] . '">';
        $html[] = '<meta name="twitter:title" content="' . htmlspecialchars($seo['title']) . '">';
        $html[] = '<meta name="twitter:description" content="' . htmlspecialchars($seo['description']) . '">';
        $html[] = '<meta name="twitter:image" content="' . $seo['image'] . '">';

        // Canonical URL
        $html[] = '<link rel="canonical" href="' . $seo['url'] . '">';

        return implode("\n    ", $html);
    }

    /**
     * Generate JSON-LD structured data for Organization
     */
    public static function organizationSchema(): string
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'EducationalOrganization',
            'name' => 'Lemdiklat Taruna Nusantara Indonesia',
            'url' => config('app.url'),
            'logo' => asset('assets/images/logo.png'),
            'description' => 'Lembaga Pendidikan dan Pelatihan Taruna Nusantara Indonesia',
            'address' => [
                '@type' => 'PostalAddress',
                'addressCountry' => 'ID',
            ],
            'sameAs' => [
                // Add social media links here
            ],
        ];

        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
    }

    /**
     * Generate JSON-LD structured data for Article
     */
    public static function articleSchema(object $article): string
    {
        $defaults = self::defaults();

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $article->title,
            'description' => strip_tags(substr($article->content, 0, 160)),
            'image' => $article->thumbnail ? (str_starts_with($article->thumbnail, 'http') ? $article->thumbnail : asset('storage/' . $article->thumbnail)) : $defaults['image'],
            'datePublished' => $article->created_at->toIso8601String(),
            'dateModified' => $article->updated_at->toIso8601String(),
            'author' => [
                '@type' => 'Person',
                'name' => $article->creator->name ?? 'Admin',
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Lemdiklat Taruna Nusantara Indonesia',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('assets/images/logo.png'),
                ],
            ],
        ];

        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
    }
}
