<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClassMemoriesNewsFeedResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "classMemoriesNewsFeed" => [
                'id' => $this->id,
                'alumni_id' => $this->alumni_id,
                'class_memories_id' => $this->class_memories_id,
                'title' => $this->title,
                'body' => $this->body,
                'view_count' => $this->view_count,
                'like_count' => $this->like_count,
                'comment_count' => $this->comment_count,
                'status' => $this->status,
                'is_approved' => $this->is_approved,
                'posted_at' => $this->posted_at,
                'visibility' => $this->visibility,
                'comment_permission' => $this->comment_permission,
                'images' => $this->classMemoriesNewsFeedImage ? $this->classMemoriesNewsFeedImage : null,
            ],
            "message" => trans($request->update ? 'class_memories_news_feed.updated' : 'class_memories_news_feed.created'),
        ];
    }
}
