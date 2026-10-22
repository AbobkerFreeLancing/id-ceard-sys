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

    public function getIsFromStudentAttribute(): bool
    {
        return $this->ticketable_type === \Packages\University\Models\Student::class
            || $this->ticketable instanceof \Packages\University\Models\Student;
    }

    public function getStudentAttribute(): ?\Packages\University\Models\Student
    {
        if ($this->is_from_student) {
            return $this->ticketable;
        }
        return null;
    }

    public function getSubmitterNameAttribute(): string
    {
        if ($this->ticketable) {
            if ($this->is_from_student) {
                return $this->ticketable->name . ' (' . ($this->ticketable->university_no ?? 'طالب') . ')';
            }
            return $this->ticketable->name ?? 'مستخدم';
        }
        return $this->guest_name ?? 'غير محدد';
    }

    /**
     * Get all attachments submitted by the student in this ticket (main ticket + replies).
     */
    public function getStudentAttachments(): array
    {
        $attachments = [];

        if (!empty($this->attachment)) {
            $ext = strtolower(pathinfo($this->attachment, PATHINFO_EXTENSION));
            $isImg = in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'bmp']);
            $url = asset('storage/' . $this->attachment);

            $dataUri = null;
            if ($isImg && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->attachment)) {
                $mime = match ($ext) {
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                    'webp' => 'image/webp',
                    default => 'image/jpeg',
                };
                try {
                    $content = \Illuminate\Support\Facades\Storage::disk('public')->get($this->attachment);
                    if ($content && strlen($content) <= 8 * 1024 * 1024) {
                        $dataUri = 'data:' . $mime . ';base64,' . base64_encode($content);
                    }
                } catch (\Throwable $e) {}
            }

            $attachments[] = [
                'id' => 'ticket_main',
                'path' => $this->attachment,
                'url' => $url,
                'data_uri' => $dataUri ?? $url,
                'source' => 'مرفق فتح التذكرة الأساسي',
                'sender' => $this->submitter_name,
                'is_image' => $isImg,
                'extension' => $ext,
                'created_at' => $this->created_at,
            ];
        }

        foreach ($this->replies()->oldest()->get() as $reply) {
            if (!empty($reply->attachment)) {
                $isStudent = ($reply->repliable_type === \Packages\University\Models\Student::class)
                    || ($reply->repliable instanceof \Packages\University\Models\Student);

                $ext = strtolower(pathinfo($reply->attachment, PATHINFO_EXTENSION));
                $isImg = in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'bmp']);
                $url = asset('storage/' . $reply->attachment);

                $dataUri = null;
                if ($isImg && \Illuminate\Support\Facades\Storage::disk('public')->exists($reply->attachment)) {
                    $mime = match ($ext) {
                        'png' => 'image/png',
                        'gif' => 'image/gif',
                        'webp' => 'image/webp',
                        default => 'image/jpeg',
                    };
                    try {
                        $content = \Illuminate\Support\Facades\Storage::disk('public')->get($reply->attachment);
                        if ($content && strlen($content) <= 8 * 1024 * 1024) {
                            $dataUri = 'data:' . $mime . ';base64,' . base64_encode($content);
                        }
                    } catch (\Throwable $e) {}
                }

                $attachments[] = [
                    'id' => 'reply_' . $reply->id,
                    'path' => $reply->attachment,
                    'url' => $url,
                    'data_uri' => $dataUri ?? $url,
                    'source' => $isStudent ? 'مرفق مع رد الطالب' : 'مرفق رد الدعم الفني',
                    'sender' => $reply->sender_name ?? ($isStudent ? 'الطالب' : 'الدعم الفني'),
                    'is_image' => $isImg,
                    'extension' => $ext,
                    'created_at' => $reply->created_at,
                ];
            }
        }

        return $attachments;
    }
}
