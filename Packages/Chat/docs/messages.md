# Messages

## MessageService

The `MessageService` handles sending, editing, deleting, and querying messages.

### Dependency Injection

```php
use Packages\Chat\Services\MessageService;

class YourController extends Controller
{
    public function __construct(protected MessageService $messageService) {}
}
```

### Methods

#### `send()` — Send a message

```php
use Packages\Chat\Enums\MessageTypeEnum;

// Simple text message
$message = $service->send(conversation: $conversation, sender: $user, body: 'Hello, everyone!');

// With type
$message = $service->send(
    conversation: $conversation,
    sender: $user,
    body: 'Check out this image',
    type: MessageTypeEnum::IMAGE,
);

// Reply to a message
$message = $service->send(conversation: $conversation, sender: $user, body: 'I agree!', replyTo: $originalMessage);

// With file attachments
$message = $service->send(
    conversation: $conversation,
    sender: $user,
    body: 'Here are the files',
    attachments: [$request->file('file1'), $request->file('file2')],
);

// With custom metadata
$message = $service->send(
    conversation: $conversation,
    sender: $user,
    body: 'System message',
    type: MessageTypeEnum::SYSTEM,
    meta: ['action' => 'user_joined', 'user_id' => 5],
);
```

**Throws:**

- `RuntimeException` if conversation is locked
- `RuntimeException` if sender is not a participant

**Returns:** Message with `sender`, `attachments`, and `replyTo` relationships loaded.

#### `update()` — Edit a message

```php
$message = $service->update($message, $user, 'Updated body text');
```

- Only the message author can edit
- Sets `edited_at` timestamp
- Returns the fresh message

#### `delete()` — Soft-delete a message

```php
$service->delete($message, $user);
```

- Message author can delete their own messages
- Admins and owners can delete any message in the conversation
- Uses soft deletes

#### `getMessages()` — Get paginated messages

```php
// Basic pagination
$messages = $service->getMessages($conversation);

// Custom per page
$messages = $service->getMessages($conversation, perPage: 30);

// Cursor-based pagination (load older messages)
$olderMessages = $service->getMessages(conversation: $conversation, perPage: 20, beforeId: $lastLoadedMessageId);
```

Returns a `LengthAwarePaginator` with `sender`, `attachments`, and `replyTo` loaded.

#### `markAsRead()` — Mark message as read

```php
$service->markAsRead($conversation, $user, $message);
```

Updates `last_read_at` and `last_read_message_id` for the participant.

#### `search()` — Search messages

```php
$results = $service->search($conversation, 'search keyword');
```

Returns a Collection of matching messages with `sender` and `attachments` loaded.

### Message Types

```php
MessageTypeEnum::TEXT       // Plain text
MessageTypeEnum::IMAGE      // Image message
MessageTypeEnum::VIDEO      // Video message
MessageTypeEnum::AUDIO      // Audio message
MessageTypeEnum::FILE       // File message
MessageTypeEnum::LOCATION   // Location share
MessageTypeEnum::CONTACT    // Contact share
MessageTypeEnum::SYSTEM     // System notification (user joined, etc.)
```

### Helper Methods

```php
$type = MessageTypeEnum::TEXT;

$type->hasAttachment(); // false — only IMAGE, VIDEO, AUDIO, FILE return true
$type->isMedia(); // false — only IMAGE, VIDEO, AUDIO return true
$type->isSystem(); // false — only SYSTEM returns true
```

### Model Relationships

```php
$message->conversation; // Parent conversation
$message->sender; // User who sent it
$message->attachments; // File attachments
$message->replyTo; // Message being replied to
$message->replies; // Replies to this message
```
