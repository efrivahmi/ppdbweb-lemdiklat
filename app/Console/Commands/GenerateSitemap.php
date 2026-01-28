<?php

namespace App\Console\Commands;

use App\Models\Landing\Berita;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap for the PPDB website';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating sitemap...');

        $sitemap = Sitemap::create();

        // Static pages with priority and change frequency
        $staticPages = [
            // Main pages - highest priority
            ['url' => '/', 'priority' => 1.0, 'frequency' => 'daily'],
            ['url' => '/spmb', 'priority' => 0.9, 'frequency' => 'weekly'],

            // School information pages
            ['url' => '/profile', 'priority' => 0.8, 'frequency' => 'monthly'],
            ['url' => '/structure', 'priority' => 0.7, 'frequency' => 'monthly'],

            // Dynamic content pages
            ['url' => '/news', 'priority' => 0.8, 'frequency' => 'daily'],
            ['url' => '/achievement', 'priority' => 0.7, 'frequency' => 'weekly'],

            // Facility and programs
            ['url' => '/facility', 'priority' => 0.7, 'frequency' => 'monthly'],
            ['url' => '/ekstrakurikuler', 'priority' => 0.6, 'frequency' => 'monthly'],

            // Requirements and alumni
            ['url' => '/requirement', 'priority' => 0.8, 'frequency' => 'monthly'],
            ['url' => '/alumni', 'priority' => 0.6, 'frequency' => 'monthly'],
        ];

        foreach ($staticPages as $page) {
            $sitemap->add(
                Url::create($page['url'])
                    ->setPriority($page['priority'])
                    ->setChangeFrequency($page['frequency'])
            );

            $this->info("Added: {$page['url']}");
        }

        // Add dynamic news articles
        $newsArticles = Berita::where('is_active', true)
            ->orderBy('updated_at', 'desc')
            ->get();

        foreach ($newsArticles as $article) {
            $sitemap->add(
                Url::create("/news/{$article->slug}")
                    ->setLastModificationDate($article->updated_at)
                    ->setPriority(0.7)
                    ->setChangeFrequency('monthly')
            );

            $this->info("Added news: /news/{$article->slug}");
        }

        // Save sitemap
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully at: public/sitemap.xml');
        $this->info('Total URLs: ' . ($newsArticles->count() + count($staticPages)));

        return Command::SUCCESS;
    }
}
