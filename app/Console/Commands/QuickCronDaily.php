<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

class QuickCronDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:quick-cron-daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run QuickCMS Cron Job Daily';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /* Create sitemap.xml */
        $url = route('home');
        $url = rtrim($url, '/').'/';

        $sitemap = SitemapGenerator::create($url)->getSitemap();

        // add posts manually
        $posts = Post::all();
        foreach ($posts as $post) {
            if ($post->user && $post->user->status == 1) {
                if($post->user->plan()->status) {
                    $sitemap->add(
                        Url::create(route('publicView', $post->slug))
                            ->addImage(asset('storage/post/logo/'.$post->image))
                    );
                }
            }
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));

        return 0;
    }
}
