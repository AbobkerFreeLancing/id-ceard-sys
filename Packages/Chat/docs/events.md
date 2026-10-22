# Events & Broadcasting

## MessageSentEvent

The `MessageSentEvent` broadcasts a real-time notification when a new message is sent, using Laravel's broadcasting system (Reverb, Pusher, etc.).

### Channel

Each conversation has a private channel:

```
private-conversation.{conversation_id}
```

### Broadcasting

The event uses `ShouldBroadcastNow`, meaning it dispatches synchronously without requiring a queue worker. If you prefer queued broadcasting, change to `ShouldBroadcast`:

```php
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSentEvent implements ShouldBroadcast
{
    // ...
}
```

### Event Name

```
message.sent
```

### Payload

```json
{
    "id": 1,
    "conversation_id": 1,
    "body": "Hello, world!",
    "type": "text",
    "sender": {
        "id": 1,
        "name": "John Doe",
        "avatar": "https://example.com/avatars/1.jpg"
    },
    "attachments": [],
    "reply_to": null,
    "created_at": "2026-07-21T12:00:00Z"
}
```

### Listening on the Frontend

```js
// Using Laravel Echo
Echo.private(`conversation.${conversationId}`).listen('message.sent', (event) => {
    console.log('New message:', event.body);
    // Append message to your UI
});
```

### Authorization

Define the channel authorization in `routes/channels.php`:

```php
use App\Models\User;
use Packages\Chat\Models\Conversation;

Broadcast::channel('conversation.{id}', function (User $user, $id) {
    $conversation = Conversation::find($id);
    if (!$conversation) {
        return false;
    }

    return $conversation->participants()->where('user_id', $user->id)->exists();
});
```

### Client Event (Exclude Sender)

The event is broadcast with `->toOthers()` to exclude the sender from receiving their own event:

```php
broadcast(new MessageSentEvent($message))->toOthers();
```

### Dispatching Manually

You can also dispatch the event manually:

```php
use Packages\Chat\Events\MessageSentEvent;

event(new MessageSentEvent($message));
```

### Requirements

- Laravel Reverb, Pusher, or another broadcasting driver configured
- Queue worker running (if using `ShouldBroadcast` instead of `ShouldBroadcastNow`)
- Laravel Echo configured on the frontend
- Sanctum or session-based auth for channel authorization
