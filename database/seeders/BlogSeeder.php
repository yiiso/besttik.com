<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Carbon\Carbon;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        // Create blog categories
        $categories = [
            [
                'name' => 'Video Download Guides',
                'slug' => 'video-download-guides',
                'description' => 'Step-by-step guides for downloading videos from popular social media platforms',
                'meta_title' => 'Video Download Guides - TikTok, Instagram, Facebook & More',
                'meta_description' => 'Complete guides for downloading videos from TikTok, Instagram, Facebook, Twitter, and other popular platforms safely and easily.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Platform Features',
                'slug' => 'platform-features',
                'description' => 'Exploring features and capabilities of different social media platforms',
                'meta_title' => 'Social Media Platform Features - Video Download Tips',
                'meta_description' => 'Learn about the unique features of TikTok, Instagram, Snapchat, and other platforms, and how to download their content effectively.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Download Tools & Tips',
                'slug' => 'download-tools-tips',
                'description' => 'Best practices, tools, and tips for video downloading',
                'meta_title' => 'Video Download Tools & Tips - Best Practices Guide',
                'meta_description' => 'Discover the best tools, tips, and practices for downloading videos from social media platforms safely and efficiently.',
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($categories as $categoryData) {
            BlogCategory::updateOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );
        }

        // Get created categories
        $guidesCategory = BlogCategory::where('slug', 'video-download-guides')->first();
        $featuresCategory = BlogCategory::where('slug', 'platform-features')->first();
        $tipsCategory = BlogCategory::where('slug', 'download-tools-tips')->first();

        // Create blog posts with dates spanning over a year
        $posts = [
            [
                'title' => 'How to Download TikTok Videos Without Watermark in 2024',
                'slug' => 'download-tiktok-videos-without-watermark-2024',
                'excerpt' => 'Learn the easiest way to download TikTok videos without watermarks using our free online tool. Save your favorite TikTok content in high quality.',
                'category_id' => $guidesCategory->id,
                'published_at' => Carbon::now()->subMonths(2),
                'reading_time' => 5,
                'tags' => ['TikTok', 'Video Download', 'No Watermark', 'Free Tool'],
                'meta_title' => 'Download TikTok Videos Without Watermark - Free Online Tool 2024',
                'meta_description' => 'Download TikTok videos without watermarks for free. Our online tool lets you save TikTok videos in HD quality instantly without any software installation.',
                'meta_keywords' => 'TikTok download, remove watermark, TikTok video downloader, free TikTok download',
            ],
            [
                'title' => 'Instagram Video Downloader: Save Reels, Stories & IGTV Videos',
                'slug' => 'instagram-video-downloader-reels-stories-igtv',
                'excerpt' => 'Download Instagram videos, Reels, Stories, and IGTV content easily with our free online tool. No app installation required.',
                'category_id' => $guidesCategory->id,
                'published_at' => Carbon::now()->subMonths(3),
                'reading_time' => 4,
                'tags' => ['Instagram', 'Reels', 'Stories', 'IGTV', 'Video Download'],
                'meta_title' => 'Instagram Video Downloader - Download Reels, Stories & IGTV Free',
                'meta_description' => 'Free Instagram video downloader to save Reels, Stories, and IGTV videos. Download Instagram content in HD quality without any software.',
                'meta_keywords' => 'Instagram downloader, Instagram video download, Instagram Reels download, Instagram Stories download',
            ],
            [
                'title' => 'Facebook Video Downloader: Save Videos from Facebook & Messenger',
                'slug' => 'facebook-video-downloader-save-videos-messenger',
                'excerpt' => 'Download Facebook videos and Messenger video content with our free online tool. Save Facebook videos in HD quality without any software.',
                'category_id' => $guidesCategory->id,
                'published_at' => Carbon::now()->subMonths(1),
                'reading_time' => 4,
                'tags' => ['Facebook', 'Video Download', 'Messenger', 'Social Media'],
                'meta_title' => 'Facebook Video Downloader - Download Facebook Videos Free Online',
                'meta_description' => 'Free Facebook video downloader to save videos from Facebook and Messenger. Download Facebook videos in HD quality without software installation.',
                'meta_keywords' => 'Facebook video download, Facebook downloader, Messenger video download, save Facebook videos',
            ],
            [
                'title' => 'Twitter Video Downloader: Download Twitter Videos & GIFs',
                'slug' => 'twitter-video-downloader-download-videos-gifs',
                'excerpt' => 'Save Twitter videos and GIFs easily with our free online downloader. Download Twitter content in original quality without any limitations.',
                'category_id' => $guidesCategory->id,
                'published_at' => Carbon::now()->subMonths(4),
                'reading_time' => 3,
                'tags' => ['Twitter', 'X', 'Video Download', 'GIF Download'],
                'meta_title' => 'Twitter Video Downloader - Download Twitter Videos & GIFs Free',
                'meta_description' => 'Download Twitter videos and GIFs for free. Our online Twitter downloader saves X videos in HD quality without any software installation.',
                'meta_keywords' => 'Twitter video download, X video downloader, Twitter GIF download, save Twitter videos',
            ],
            [
                'title' => 'Snapchat Video Downloader: Save Snapchat Videos & Stories',
                'slug' => 'snapchat-video-downloader-save-videos-stories',
                'excerpt' => 'Download Snapchat videos and Stories with our secure online tool. Save Snapchat content safely without notifying the sender.',
                'category_id' => $guidesCategory->id,
                'published_at' => Carbon::now()->subMonths(5),
                'reading_time' => 4,
                'tags' => ['Snapchat', 'Stories', 'Video Download', 'Privacy'],
                'meta_title' => 'Snapchat Video Downloader - Download Snapchat Videos & Stories',
                'meta_description' => 'Download Snapchat videos and Stories anonymously. Our free Snapchat downloader saves content without notifying the sender.',
                'meta_keywords' => 'Snapchat downloader, Snapchat video download, Snapchat Stories download, save Snapchat videos',
            ],
            [
                'title' => 'Pinterest Video Downloader: Save Pinterest Videos & Images',
                'slug' => 'pinterest-video-downloader-save-videos-images',
                'excerpt' => 'Download Pinterest videos and high-resolution images with our free online tool. Save Pinterest content for offline viewing.',
                'category_id' => $guidesCategory->id,
                'published_at' => Carbon::now()->subMonths(6),
                'reading_time' => 3,
                'tags' => ['Pinterest', 'Image Download', 'Video Download', 'High Resolution'],
                'meta_title' => 'Pinterest Video Downloader - Download Pinterest Videos & Images',
                'meta_description' => 'Free Pinterest downloader to save videos and high-resolution images. Download Pinterest content in original quality without watermarks.',
                'meta_keywords' => 'Pinterest downloader, Pinterest video download, Pinterest image download, save Pinterest content',
            ],
            [
                'title' => 'Batch Video Download: Download Multiple Videos at Once',
                'slug' => 'batch-video-download-multiple-videos-once',
                'excerpt' => 'Learn how to download multiple videos simultaneously from different platforms using our batch download feature. Save time and effort.',
                'category_id' => $tipsCategory->id,
                'published_at' => Carbon::now()->subMonths(7),
                'reading_time' => 5,
                'tags' => ['Batch Download', 'Multiple Videos', 'Efficiency', 'Time Saving'],
                'meta_title' => 'Batch Video Download - Download Multiple Videos Simultaneously',
                'meta_description' => 'Download multiple videos at once from TikTok, Instagram, Facebook, and other platforms. Our batch download feature saves time and effort.',
                'meta_keywords' => 'batch video download, multiple video download, bulk download, download multiple videos',
            ],
            [
                'title' => 'Video Quality Guide: Choosing the Right Resolution for Downloads',
                'slug' => 'video-quality-guide-choosing-right-resolution-downloads',
                'excerpt' => 'Understand different video qualities and resolutions. Learn how to choose the best quality for your downloads based on your needs.',
                'category_id' => $tipsCategory->id,
                'published_at' => Carbon::now()->subMonths(8),
                'reading_time' => 6,
                'tags' => ['Video Quality', 'Resolution', 'HD', '4K', 'Download Tips'],
                'meta_title' => 'Video Quality Guide - Choose the Right Resolution for Downloads',
                'meta_description' => 'Learn about video qualities and resolutions. Choose the best quality for your video downloads from social media platforms.',
                'meta_keywords' => 'video quality, video resolution, HD download, 4K video, video quality guide',
            ],
            [
                'title' => 'Mobile Video Downloading: Best Practices for Phone Users',
                'slug' => 'mobile-video-downloading-best-practices-phone-users',
                'excerpt' => 'Optimize your mobile video downloading experience. Learn the best practices for downloading videos on smartphones and tablets.',
                'category_id' => $tipsCategory->id,
                'published_at' => Carbon::now()->subMonths(9),
                'reading_time' => 4,
                'tags' => ['Mobile Download', 'Smartphone', 'Tablet', 'Mobile Optimization'],
                'meta_title' => 'Mobile Video Downloading - Best Practices for Phone Users',
                'meta_description' => 'Download videos on mobile devices efficiently. Learn best practices for smartphone and tablet video downloading from social media.',
                'meta_keywords' => 'mobile video download, smartphone video download, mobile downloader, phone video download',
            ],
            [
                'title' => 'Video Download Safety: Protecting Yourself from Malware',
                'slug' => 'video-download-safety-protecting-yourself-malware',
                'excerpt' => 'Stay safe while downloading videos online. Learn how to identify secure download tools and avoid malware-infected websites.',
                'category_id' => $tipsCategory->id,
                'published_at' => Carbon::now()->subMonths(10),
                'reading_time' => 5,
                'tags' => ['Safety', 'Security', 'Malware Protection', 'Safe Download'],
                'meta_title' => 'Video Download Safety - Protect Yourself from Malware & Scams',
                'meta_description' => 'Download videos safely online. Learn how to avoid malware, scams, and unsafe video download websites while saving social media content.',
                'meta_keywords' => 'safe video download, video download security, avoid malware, secure downloader',
            ],
            [
                'title' => 'Copyright and Fair Use: Legal Aspects of Video Downloading',
                'slug' => 'copyright-fair-use-legal-aspects-video-downloading',
                'excerpt' => 'Understand the legal aspects of downloading videos from social media platforms. Learn about copyright, fair use, and best practices.',
                'category_id' => $tipsCategory->id,
                'published_at' => Carbon::now()->subMonths(11),
                'reading_time' => 7,
                'tags' => ['Copyright', 'Fair Use', 'Legal', 'Video Rights'],
                'meta_title' => 'Copyright & Fair Use - Legal Aspects of Video Downloading',
                'meta_description' => 'Learn about copyright and fair use when downloading videos. Understand the legal aspects of saving content from social media platforms.',
                'meta_keywords' => 'video copyright, fair use, legal video download, video rights, copyright law',
            ],
            [
                'title' => 'TikTok Features Explained: Understanding TikTok Video Types',
                'slug' => 'tiktok-features-explained-understanding-video-types',
                'excerpt' => 'Explore TikTok\'s various video features including Reels, Live videos, and Duets. Learn how to download different types of TikTok content.',
                'category_id' => $featuresCategory->id,
                'published_at' => Carbon::now()->subMonths(12),
                'reading_time' => 5,
                'tags' => ['TikTok Features', 'TikTok Reels', 'TikTok Live', 'Duets'],
                'meta_title' => 'TikTok Features Explained - Understanding Different Video Types',
                'meta_description' => 'Learn about TikTok\'s video features including Reels, Live videos, and Duets. Understand how to download different types of TikTok content.',
                'meta_keywords' => 'TikTok features, TikTok video types, TikTok Reels, TikTok Duets, TikTok Live',
            ],
            [
                'title' => 'Instagram Features Guide: Reels vs Stories vs IGTV',
                'slug' => 'instagram-features-guide-reels-vs-stories-vs-igtv',
                'excerpt' => 'Compare Instagram\'s video features: Reels, Stories, and IGTV. Learn the differences and how to download each type of content.',
                'category_id' => $featuresCategory->id,
                'published_at' => Carbon::now()->subWeeks(6),
                'reading_time' => 6,
                'tags' => ['Instagram Features', 'Instagram Reels', 'Instagram Stories', 'IGTV'],
                'meta_title' => 'Instagram Features Guide - Reels vs Stories vs IGTV Comparison',
                'meta_description' => 'Compare Instagram Reels, Stories, and IGTV features. Learn the differences and how to download each type of Instagram content.',
                'meta_keywords' => 'Instagram features, Instagram Reels vs Stories, IGTV, Instagram video types',
            ],
            [
                'title' => 'Video Download Troubleshooting: Common Issues and Solutions',
                'slug' => 'video-download-troubleshooting-common-issues-solutions',
                'excerpt' => 'Solve common video download problems with our troubleshooting guide. Fix download errors and improve your download success rate.',
                'category_id' => $tipsCategory->id,
                'published_at' => Carbon::now()->subWeeks(4),
                'reading_time' => 5,
                'tags' => ['Troubleshooting', 'Download Errors', 'Problem Solving', 'Technical Support'],
                'meta_title' => 'Video Download Troubleshooting - Fix Common Download Issues',
                'meta_description' => 'Fix common video download problems with our troubleshooting guide. Solve download errors and improve your success rate.',
                'meta_keywords' => 'video download problems, download troubleshooting, fix download errors, download issues',
            ],
            [
                'title' => 'Best Video Download Tools 2024: Free vs Premium Options',
                'slug' => 'best-video-download-tools-2024-free-vs-premium',
                'excerpt' => 'Compare the best video download tools available in 2024. Discover the differences between free and premium video downloaders.',
                'category_id' => $tipsCategory->id,
                'published_at' => Carbon::now()->subWeeks(2),
                'reading_time' => 8,
                'tags' => ['Download Tools', 'Free Tools', 'Premium Tools', 'Comparison'],
                'meta_title' => 'Best Video Download Tools 2024 - Free vs Premium Comparison',
                'meta_description' => 'Compare the best video download tools in 2024. Learn the differences between free and premium video downloaders for social media.',
                'meta_keywords' => 'best video downloaders, video download tools 2024, free vs premium downloaders',
            ],
            [
                'title' => 'Social Media Video Trends 2024: What\'s Popular to Download',
                'slug' => 'social-media-video-trends-2024-whats-popular-download',
                'excerpt' => 'Discover the latest social media video trends in 2024. Learn what types of content are most popular for downloading and sharing.',
                'category_id' => $featuresCategory->id,
                'published_at' => Carbon::now()->subDays(10),
                'reading_time' => 6,
                'tags' => ['Video Trends', 'Social Media Trends', '2024 Trends', 'Popular Content'],
                'meta_title' => 'Social Media Video Trends 2024 - Popular Content to Download',
                'meta_description' => 'Explore social media video trends in 2024. Discover what types of content are most popular for downloading from TikTok, Instagram, and more.',
                'meta_keywords' => 'social media trends 2024, video trends, popular video content, trending videos',
            ],
            [
                'title' => 'Video Storage and Organization: Managing Your Downloaded Content',
                'slug' => 'video-storage-organization-managing-downloaded-content',
                'excerpt' => 'Learn how to organize and store your downloaded videos efficiently. Best practices for managing large video collections on your device.',
                'category_id' => $tipsCategory->id,
                'published_at' => Carbon::now()->subDays(5),
                'reading_time' => 4,
                'tags' => ['Video Storage', 'Organization', 'File Management', 'Storage Tips'],
                'meta_title' => 'Video Storage & Organization - Manage Your Downloaded Content',
                'meta_description' => 'Organize and store downloaded videos efficiently. Learn best practices for managing video collections from social media platforms.',
                'meta_keywords' => 'video storage, organize videos, video file management, downloaded content organization',
            ],
            [
                'title' => 'Video Sharing and Privacy: Best Practices for Downloaded Content',
                'slug' => 'video-sharing-privacy-best-practices-downloaded-content',
                'excerpt' => 'Learn the best practices for sharing downloaded videos while respecting privacy and copyright. Share content responsibly and legally.',
                'category_id' => $tipsCategory->id,
                'published_at' => Carbon::now()->subDays(3),
                'reading_time' => 5,
                'tags' => ['Video Sharing', 'Privacy', 'Best Practices', 'Responsible Sharing'],
                'meta_title' => 'Video Sharing & Privacy - Best Practices for Downloaded Content',
                'meta_description' => 'Share downloaded videos responsibly. Learn best practices for video sharing while respecting privacy and copyright laws.',
                'meta_keywords' => 'video sharing, privacy, responsible sharing, video sharing ethics',
            ],
            [
                'title' => 'Future of Video Downloading: Emerging Platforms and Technologies',
                'slug' => 'future-video-downloading-emerging-platforms-technologies',
                'excerpt' => 'Explore the future of video downloading with emerging social media platforms and new technologies. Stay ahead of the trends.',
                'category_id' => $featuresCategory->id,
                'published_at' => Carbon::now()->subDay(),
                'reading_time' => 7,
                'tags' => ['Future Technology', 'Emerging Platforms', 'Video Technology', 'Innovation'],
                'meta_title' => 'Future of Video Downloading - Emerging Platforms & Technologies',
                'meta_description' => 'Discover the future of video downloading with emerging social media platforms and new technologies. Stay ahead of video trends.',
                'meta_keywords' => 'future video downloading, emerging platforms, video technology trends, new social media',
            ],
            [
                'title' => 'Complete Guide to Online Video Downloaders: Everything You Need to Know',
                'slug' => 'complete-guide-online-video-downloaders-everything-need-know',
                'excerpt' => 'The ultimate guide to online video downloaders. Learn everything about downloading videos from social media platforms safely and efficiently.',
                'category_id' => $guidesCategory->id,
                'published_at' => Carbon::now(),
                'reading_time' => 10,
                'tags' => ['Complete Guide', 'Video Downloaders', 'Online Tools', 'Comprehensive'],
                'meta_title' => 'Complete Guide to Online Video Downloaders - Everything You Need',
                'meta_description' => 'Ultimate guide to online video downloaders. Learn everything about downloading videos from TikTok, Instagram, Facebook, and other platforms.',
                'meta_keywords' => 'online video downloaders, video download guide, social media downloaders, complete video download guide',
            ],
        ];

        foreach ($posts as $postData) {
            BlogPost::updateOrCreate(
                ['slug' => $postData['slug']],
                array_merge($postData, [
                    'content' => '<p>This is a comprehensive article about ' . $postData['title'] . '. Content will be updated by the BlogContentSeeder.</p>',
                    'status' => 'published',
                    'views' => rand(50, 500),
                ])
            );
        }
    }
}