# Attachments

## AttachmentService

The `AttachmentService` handles file uploads, storage, and URL generation for message attachments.

### Dependency Injection

```php
use Packages\Chat\Services\AttachmentService;

class YourController extends Controller
{
    public function __construct(protected AttachmentService $attachmentService) {}
}
```

### Configuration

By default, files are stored on the `public` disk at `chat/attachments/`. You can override these in the service:

```php
$service = app(AttachmentService::class);
// Uses: disk = 'public', basePath = 'chat/attachments'
```

### Methods

#### `attach()` — Upload files to a message

```php
use Illuminate\Http\UploadedFile;

$attachments = $service->attach($message, [$request->file('image'), $request->file('document')]);
```

**Returns:** Array of `MessageAttachment` models.

The service automatically detects the file type:

- `image/*` → `AttachmentTypeEnum::IMAGE`
- `video/*` → `AttachmentTypeEnum::VIDEO`
- `audio/*` → `AttachmentTypeEnum::AUDIO`
- Everything else → `AttachmentTypeEnum::FILE`

For images, it also extracts `width` and `height` dimensions.

#### `delete()` — Delete an attachment

```php
$service->delete($attachment);
// Removes the file from storage and deletes the DB record
```

#### `url()` — Get the public URL

```php
$url = $service->url($attachment);
// Returns: https://example.com/storage/chat/attachments/abc123.jpg
```

#### `temporaryUrl()` — Get a temporary URL (for private disks)

```php
$url = $service->temporaryUrl($attachment, expiresInMinutes: 10);
// Returns a signed, time-limited URL
```

### Attachment Types

```php
AttachmentTypeEnum::IMAGE   // Image files
AttachmentTypeEnum::VIDEO   // Video files
AttachmentTypeEnum::AUDIO   // Audio files
AttachmentTypeEnum::FILE    // Generic files
AttachmentTypeEnum::VOICE   // Voice recordings
```

### Helper Methods

```php
$type = AttachmentTypeEnum::IMAGE;
$type->isMedia(); // true — IMAGE, VIDEO, AUDIO, VOICE all return true
```

### Attachment Model Fields

| Field           | Type                 | Description              |
| --------------- | -------------------- | ------------------------ |
| `type`          | `AttachmentTypeEnum` | File type classification |
| `disk`          | `string`             | Storage disk name        |
| `path`          | `string`             | Storage path             |
| `original_name` | `string`             | Original filename        |
| `mime_type`     | `string`             | MIME type                |
| `extension`     | `string\|null`       | File extension           |
| `size`          | `integer`            | File size in bytes       |
| `width`         | `integer\|null`      | Image width (pixels)     |
| `height`        | `integer\|null`      | Image height (pixels)    |
| `duration`      | `integer\|null`      | Media duration (seconds) |
| `meta`          | `array`              | Custom metadata          |

### Model Relationship

```php
$attachment->message; // Parent message
```

### Usage in API

When sending a message with attachments via the API:

```http
POST /api/chat/conversations/{conversation}/messages
Content-Type: multipart/form-data

body: "Here are the photos"
files[]: @photo1.jpg
files[]: @photo2.jpg
```

The controller automatically passes `$request->allFiles()` to the `MessageService::send()` method, which delegates to `AttachmentService::attach()`.
