<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class NewsletterMailCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($newsletterMail) {
                return [
                    'id' => $newsletterMail->id,
                    'mail_subject' => $newsletterMail->mail_subject,
                    'type' => $newsletterMail->type,
                ];
            })
        ];
    }
}
