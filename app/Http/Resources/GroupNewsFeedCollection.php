<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GroupNewsFeedCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($group_news_feed) {
                return [
                    'id' => $group_news_feed->id,
                    'alumni' => $group_news_feed->alumni ? $group_news_feed->alumni : null,
                    'group' => $group_news_feed->group ? $group_news_feed->group : null,
                    'title' => $group_news_feed->title,
                    'body' => $group_news_feed->body,
                    'show_less_body' => substr($group_news_feed->body, 0, 200),
                    'view_count' => $group_news_feed->view_count,
                    'like_count' => $group_news_feed->like_count,
                    'comment_count' => $group_news_feed->comment_count,
                    'status' => $group_news_feed->status,
                    'is_approved' => $group_news_feed->is_approved,
                    'posted_at' => $group_news_feed->posted_at,
                    'visibility' => $group_news_feed->visibility,
                    'comment_permission' => $group_news_feed->comment_permission,
                    'images' => $group_news_feed->groupNewsFeedImage ? $group_news_feed->groupNewsFeedImage : null,
                    'video' => $group_news_feed->groupNewsFeedVideo ? $group_news_feed->groupNewsFeedVideo->source : null,
                    'document' => $group_news_feed->groupNewsFeedDocument ? $group_news_feed->groupNewsFeedDocument->source : null,
                    'created_at' => $group_news_feed->created_at->diffForHumans(),
                ];
            })
        ];
    }
}
