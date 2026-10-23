<?php

namespace Packages\Support\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Packages\Enum\PriorityEnum;
use Packages\Enum\TicketStatusEnum;

use Packages\IdCard\Models\Cardholder;

class Ticket extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected static function booted(): void
    {
        static::creating(function (Ticket $ticket) {
            if (empty($ticket->ticket_number)) {
                $maxId = (static::withTrashed()->max('id') ?? 0) + 1;
                $ticket->ticket_number = 'TKT-' . date('Y') . '-' . str_pad($maxId, 5, '0', STR_PAD_LEFT);
            }
        });
    }

    protected function casts(): array
    {
        return [
            'admin_notes' => 'array',
            'closed_at' => 'datetime',
            'assigned_at' => 'datetime',
            'priority' => PriorityEnum::class,
            'status' => TicketStatusEnum::class,
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(TicketCategory::class, 'ticket_category_id');
    }

    public function ticketable(): MorphTo
    {
        return $this->morphTo();
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(TicketReply::class);
    }

    public function getIsFromCardholderAttribute(): bool
    {
        return $this->ticketable_type === Cardholder::class
            || $this->ticketable instanceof Cardholder;
    }

    public function getCardholderAttribute(): ?Cardholder
    {
        if ($this->is_from_cardholder) {
            return $this->ticketable;
        }
        return null;
    }

    public function getSubmitterNameAttribute(): string
    {
        if ($this->ticketable) {
            if ($this->is_from_cardholder) {
                return ($this->ticketable->full_name_ar ?? $this->ticketable->first_name ?? 'منتسب') . ' (' . ($this->ticketable->identifier_code ?? 'حامل بطاقة') . ')';
            }
            return $this->ticketable->name ?? 'مستخدم';
        }
        return $this->guest_name ?? 'غير محدد';
    }

    /**
     * Get all attachments submitted in this ticket (main ticket + replies).
     */
    public function getAttachments(): array
    {
        $attachments = [];

        if (!empty($this->attachment)) {
            $ext = strtolower(pathinfo($this->attachment, PATHINFO_EXTENSION));
            $isImg = in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'bmp']);
            $url = asset('storage/' . $this->attachment);

            $attachments[] = [
                'id' => 'ticket_main',
                'path' => $this->attachment,
                'url' => $url,
                'data_uri' => $url,
                'source' => 'المرفق الأساسي للتذكرة',
                'sender' => $this->submitter_name,
                'is_image' => $isImg,
                'extension' => $ext,
                'created_at' => $this->created_at,
            ];
        }

        foreach ($this->replies()->oldest()->get() as $reply) {
            if (!empty($reply->attachment)) {
                $ext = strtolower(pathinfo($reply->attachment, PATHINFO_EXTENSION));
                $isImg = in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'bmp']);
                $url = asset('storage/' . $reply->attachment);

                $attachments[] = [
                    'id' => 'reply_' . $reply->id,
                    'path' => $reply->attachment,
                    'url' => $url,
                    'data_uri' => $url,
                    'source' => 'مرفق رد رقم #' . $reply->id,
                    'sender' => $reply->sender_name,
                    'is_image' => $isImg,
                    'extension' => $ext,
                    'created_at' => $reply->created_at,
                ];
            }
        }

    }
}
