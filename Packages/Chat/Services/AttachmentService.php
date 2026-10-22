<?php

namespace Packages\Chat\Services;

use Packages\Chat\Enums\AttachmentTypeEnum;
use Packages\Chat\Models\Message;
use Packages\Chat\Models\MessageAttachment;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AttachmentService
{
    protected string $disk = 'public';
    protected string $basePath = 'chat/attachments';

    /**
     * Attach uploaded files to a message.
     *
     * @param Message $message
     * @param UploadedFile[] $files
     * @return MessageAttachment[]
     */
    public function attach(Message $message, array $files): array
    {
        $attachments = [];

        foreach ($files as $file) {
            $type = $this->resolveType($file);
            $path = $file->store($this->basePath, $this->disk);

            $attachment = MessageAttachment::create([
                'message_id' => $message->id,
                'type' => $type,
                'disk' => $this->disk,
                'path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'extension' => $file->getClientOriginalExtension(),
                'size' => $file->getSize(),
                'width' => $this->getImageWidth($file, $type),
                'height' => $this->getImageHeight($file, $type),
                'duration' => null,
            ]);

            $attachments[] = $attachment;
        }

        return $attachments;
    }

    /**
     * Delete an attachment (file + DB record).
     */
    public function delete(MessageAttachment $attachment): bool
    {
        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk($attachment->disk);
        $disk->delete($attachment->path);
        return $attachment->delete();
    }

    /**
     * Get the download URL for an attachment.
     */
    public function url(MessageAttachment $attachment): string
    {
        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk($attachment->disk);
        return $disk->url($attachment->path);
    }

    /**
     * Get the temporary download URL for private disks.
     */
    public function temporaryUrl(MessageAttachment $attachment, int $expiresInMinutes = 5): string
    {
        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk($attachment->disk);
        return $disk->temporaryUrl($attachment->path, now()->addMinutes($expiresInMinutes));
    }

    /**
     * Resolve attachment type from file.
     */
    protected function resolveType(UploadedFile $file): AttachmentTypeEnum
    {
        $mime = $file->getMimeType();

        return match (true) {
            str_starts_with($mime, 'image/') => AttachmentTypeEnum::IMAGE,
            str_starts_with($mime, 'video/') => AttachmentTypeEnum::VIDEO,
            str_starts_with($mime, 'audio/') => AttachmentTypeEnum::AUDIO,
            default => AttachmentTypeEnum::FILE,
        };
    }

    /**
     * Get image width if applicable.
     */
    protected function getImageWidth(UploadedFile $file, AttachmentTypeEnum $type): ?int
    {
        if ($type->isMedia() && str_starts_with($file->getMimeType(), 'image/')) {
            $dimensions = @getimagesize($file->getPathname());
            return $dimensions ? $dimensions[0] : null;
        }
        return null;
    }

    /**
     * Get image height if applicable.
     */
    protected function getImageHeight(UploadedFile $file, AttachmentTypeEnum $type): ?int
    {
        if ($type->isMedia() && str_starts_with($file->getMimeType(), 'image/')) {
            $dimensions = @getimagesize($file->getPathname());
            return $dimensions ? $dimensions[1] : null;
        }
        return null;
    }
}
