# Installation

## 1. Register the Service Provider

The package is auto-discovered if you're using Laravel's package auto-discovery. Otherwise, add the service provider to `config/app.php`:

```php
'providers' => [
    // ...
    Packages\Chat\ChatServiceProvider::class,
],
```

## 2. Run Migrations

```bash
php artisan migrate
```

This will create the following tables:

- `chat_conversations` — Conversation threads (private, group, channel)
- `chat_participants` — User-conversation membership with roles
- `chat_messages` — Messages with type, body, and reply support
- `chat_message_attachments` — File attachments linked to messages

## 3. Configure Filesystem (for Attachments)

Ensure your `config/filesystems.php` has a `public` disk configured:

```php
'disks' => [
    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL') . '/storage',
        'visibility' => 'public',
    ],
],
```

Then create the storage symlink:

```bash
php artisan storage:link
```

## 4. Configure Broadcasting (for Real-time Events)

Set up Laravel Reverb or Pusher in your `.env`:

```env
# For Laravel Reverb
BROADCAST_CONNECTION=reverb
REVERB_APP_ID=your-app-id
REVERB_APP_KEY=your-app-key
REVERB_APP_SECRET=your-app-secret
REVERB_HOST=localhost
REVERB_PORT=8080
REVERB_SCHEME=http

# For Pusher
BROADCAST_CONNECTION=pusher
PUSHER_APP_ID=your-app-id
PUSHER_APP_KEY=your-app-key
PUSHER_APP_SECRET=your-app-secret
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1
```

## 5. Configure Queue

For broadcasting to work, you need a queue driver:

```env
QUEUE_CONNECTION=database
```

Run the queue worker:

```bash
php artisan queue:work
```

## 6. Authentication

The package uses `auth:sanctum` middleware for API routes. Ensure Sanctum is installed and configured:

```bash
php artisan install:api
```

## 7. Service Auto-wiring

All services are automatically resolved by Laravel's container. You can inject them in controllers or constructors:

```php
class ChatController extends Controller
{
    public function __construct(
        protected ConversationService $conversationService,
        protected MessageService $messageService,
        protected ParticipantService $participantService,
        protected AttachmentService $attachmentService,
    ) {}
}
```

## Dependencies

- Laravel 11+
- Laravel Sanctum (or custom auth)
- Laravel Reverb or Pusher (optional, for real-time)
- `intervention/image` (optional, for image processing)
