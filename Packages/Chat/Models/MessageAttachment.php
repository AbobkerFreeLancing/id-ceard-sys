<?php

namespace Packages\Chat\Models;

use Packages\Chat\Enums\AttachmentTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MessageAttachment extends Model
{
    protected $table = 'chat_message_attachments';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'type' => AttachmentTypeEnum::class,
            'meta' => 'array',
        ];
    }

    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }
}
