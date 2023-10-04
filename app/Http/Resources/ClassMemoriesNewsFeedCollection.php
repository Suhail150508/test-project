<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ClassMemoriesNewsFeedCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($class_memories_news_feed) {
                return [
                    'id' => $class_memories_news_feed->id,
                    'alumni' => $class_memories_news_feed->alumni ? $class_memories_news_feed->alumni : null,
                    'class_memories' => $class_memories_news_feed->classMemories ? $class_memories_news_feed->classMemories : null,
                    'title' => $class_memories_news_feed->title,
                    'body' => $class_memories_news_feed->body,
                    'show_less_body' => substr($class_memories_news_feed->body, 0, 200),
                    'view_count' => $class_memories_news_feed->view_count,
                    'like_count' => $class_memories_news_feed->like_count,
                    'comment_count' => $class_memories_news_feed->comment_count,
                    'status' => $class_memories_news_feed->status,
                    'is_approved' => $class_memories_news_feed->is_approved,
                    'posted_at' => $class_memories_news_feed->posted_at,
                    'visibility' => $class_memories_news_feed->visibility,
                    'comment_permission' => $class_memories_news_feed->comment_permission,
                    'images' => $class_memories_news_feed->classMemoriesNewsFeedImage ? $class_memories_news_feed->classMemoriesNewsFeedImage : null,
                    'created_at' => $class_memories_news_feed->created_at->diffForHumans(),
                ];
            })
        ];
    }
}
