<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupNewsFeedResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "groupNewsFeed" => [
                'id' => $this->id,
                'alumni_id' => $this->alumni_id,
                'group_id' => $this->group_id,
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
                'images' => $this->groupNewsFeedImage ? $this->groupNewsFeedImage : null,
                'video' => $this->groupNewsFeedVideo ? $this->groupNewsFeedVideo->source : null,
                'document' => $this->groupNewsFeedDocument ? $this->groupNewsFeedDocument->source : null,
            ],
            "message" => trans($request->update ? 'group_news_feed.updated' : 'group_news_feed.created'),
        ];
    }
}
