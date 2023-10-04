<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsFeedResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "newsFeed" => [
                'id' => $this->id,
                'alumni_id' => $this->alumni_id,
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
                'images' => $this->newsFeedImage ? $this->newsFeedImage : null,
                'video' => $this->newsFeedVideo ? $this->newsFeedVideo->source : null,
                'document' => $this->newsFeedDocument ? $this->newsFeedDocument->source : null,
            ],
            "message" => trans($request->update ? 'news_feed.updated' : 'news_feed.created'),
        ];
    }
}
