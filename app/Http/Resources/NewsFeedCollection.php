<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class NewsFeedCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($news_feed) {
                return [
                    'id' => $news_feed->id,
                    'alumni' => $news_feed->alumni ? $news_feed->alumni : null,
                    'title' => $news_feed->title,
                    'show_less_body' => substr($news_feed->body, 0, 200),
                    'body' => $news_feed->body,
                    'view_count' => $news_feed->view_count,
                    'like_count' => $news_feed->like_count,
                    'comment_count' => $news_feed->comment_count,
                    'status' => $news_feed->status,
                    'is_approved' => $news_feed->is_approved,
                    'posted_at' => $news_feed->posted_at,
                    'visibility' => $news_feed->visibility,
                    'comment_permission' => $news_feed->comment_permission,
                    'images' => $news_feed->newsFeedImage ? $news_feed->newsFeedImage : null,
                    'video' => $news_feed->newsFeedVideo ? $news_feed->newsFeedVideo->source : null,
                    'document' => $news_feed->newsFeedDocument ? $news_feed->newsFeedDocument->source : null,
                    'created_at' => $news_feed-> created_at->diffForHumans(),
                ];
            })
        ];
    }
}
