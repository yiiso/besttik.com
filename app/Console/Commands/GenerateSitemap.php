<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use Carbon\Carbon;

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
    protected $description = 'Generate XML sitemap for SEO';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating sitemap...');

        $sitemap = $this->generateSitemap();
        
        file_put_contents(public_path('sitemap.xml'), $sitemap);
        
        $this->info('Sitemap generated successfully at public/sitemap.xml');
        
        return 0;
    }

    private function generateSitemap(): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Static pages
        $staticPages = [
            ['url' => '/', 'priority' => '1.0', 'changefreq' => 'daily'],
            ['url' => '/batch-download', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => '/api', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => '/help', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => '/contact', 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['url' => '/privacy', 'priority' => '0.5', 'changefreq' => 'yearly'],
            ['url' => '/terms', 'priority' => '0.5', 'changefreq' => 'yearly'],
            ['url' => '/blog', 'priority' => '0.9', 'changefreq' => 'daily'],
            // Platform pages
            ['url' => '/tiktok', 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['url' => '/instagram', 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['url' => '/facebook', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => '/twitter', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => '/snapchat', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => '/pinterest', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => '/douyin', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => '/xiaohongshu', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => '/bilibili', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => '/kuaishou', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => '/weibo', 'priority' => '0.8', 'changefreq' => 'weekly'],
        ];

        foreach ($staticPages as $page) {
            $xml .= $this->generateUrlEntry(
                url($page['url']),
                Carbon::now()->toISOString(),
                $page['changefreq'],
                $page['priority']
            );
        }

        // Blog categories
        $categories = BlogCategory::where('is_active', true)->get();
        foreach ($categories as $category) {
            $xml .= $this->generateUrlEntry(
                route('blog.category', $category->slug),
                $category->updated_at->toISOString(),
                'weekly',
                '0.7'
            );
        }

        // Blog posts
        $posts = BlogPost::published()->get();
        foreach ($posts as $post) {
            $xml .= $this->generateUrlEntry(
                route('blog.show', $post->slug),
                $post->updated_at->toISOString(),
                'monthly',
                '0.8'
            );
        }

        $xml .= '</urlset>';

        return $xml;
    }

    private function generateUrlEntry(string $url, string $lastmod, string $changefreq, string $priority): string
    {
        return "  <url>\n" .
               "    <loc>{$url}</loc>\n" .
               "    <lastmod>{$lastmod}</lastmod>\n" .
               "    <changefreq>{$changefreq}</changefreq>\n" .
               "    <priority>{$priority}</priority>\n" .
               "  </url>\n";
    }
}
