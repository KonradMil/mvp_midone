<?php

namespace App\Jobs;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class FetchWordPressPostsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
//
    }

    public function handle()
    {
        $fetchPosts = true;
        $page = 1;
        while ($fetchPosts) {
            $response = Http::get("https://dbr77.com/wp-json/wp/v2/posts?per_page=10&orderby=date&page={$page}");
            $json = $response->json();
            if (!empty($json['code']) && $json['code'] === 'rest_post_invalid_page_number') {
                $fetchPosts = false;
            } else {
                $page++;
                foreach ($json as $post) {
                    if ($post['type'] === 'post' && $post['status'] === 'publish') {
                        if (in_array('13', $post['tags']) || in_array('14', $post['tags'])) {
                            if (!$this->isPostInDb($post['id'])) {
                                $this->pushPostToDb($post);
                            } else {
                                $this->updatePostToDb($post);
                            }
                        }
                    }
                }
            }
        }
    }

    private function isPostInDb($wpId)
    {
        return !empty(Post::where('wp_id', $wpId)->first());
    }

    private function pushPostToDb($post)
    {
        Post::create([
            'wp_id' => $post['id'],
            'status' => $post['status'],
            'title' => $this->parsePostTitle($post),
            'slug' => $post['slug'],
            'type_investor' => $this->hasTagInvestor($post),
            'type_installer' => $this->hasTagInstaller($post),
            'excerpt' => $this->parsePostExcerpt($post),
            'thumbnail' => $this->getMainImage($post),
            'content' => $this->parsePostContent($post),
            'author_id' => null
        ]);
    }

    private function updatePostToDb($post)
    {
        $p = Post::where('wp_id', '=', $post['id'])->first();
        $p->fill([
            'status' => $post['status'],
            'title' => $this->parsePostTitle($post),
            'slug' => $post['slug'],
            'type_investor' => $this->hasTagInvestor($post),
            'type_installer' => $this->hasTagInstaller($post),
            'excerpt' => $this->parsePostExcerpt($post),
            'thumbnail' => $this->getMainImage($post),
            'content' => $this->parsePostContent($post),
            'author_id' => null
        ]);
        $p->save();
    }

    private function hasTagInvestor($post)
    {
        return in_array('13', $post['tags']) ? 1 : 0;
    }

    private function hasTagInstaller($post)
    {
        return in_array('14', $post['tags']) ? 1 : 0;
    }

    private function removeDiviShortcodes($content) {
        $content = preg_replace('/\[\/?et_pb.*?\]/', '', $content);
        return $content;
    }

    private function parsePostTitle($post)
    {
        if (!empty($post['title']) && !empty($post['title']['rendered'])) {
            return $post['title']['rendered'];
        } else {
            return null;
        }
    }

    private function parsePostExcerpt($post)
    {
        if (!empty($post['excerpt']) && !empty($post['excerpt']['rendered'])) {
            return $this->removeDiviShortcodes($post['excerpt']['rendered']);
        } else {
            return null;
        }
    }

    private function parsePostContent($post)
    {
        if (!empty($post['content']) && !empty($post['content']['rendered'])) {
            return $this->removeDiviShortcodes($post['content']['rendered']);
        } else {
            return null;
        }
    }

    private function getMainImage($post)
    {
        $mediaId = $post['featured_media'];
        $response = Http::get("https://dbr77.com/wp-json/wp/v2/media/{$mediaId}");
        $json = $response->json();
        return !empty($json['source_url']) ? $json['source_url'] : null;
    }

}
