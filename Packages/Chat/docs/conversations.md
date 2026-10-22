# Conversations

## ConversationService

The `ConversationService` manages all conversation operations — creating private chats, group chats, channels, and managing their state.

### Dependency Injection

```php
use Packages\Chat\Services\ConversationService;

class YourController extends Controller
{
    public function __construct(protected ConversationService $conversationService) {}
}
```

### Methods

#### `create()` — Create a conversation by type

```php
use Packages\Chat\Enums\ConversationTypeEnum;

// Private
$conversation = $service->create(creator: $user, participants: [$recipient], type: ConversationTypeEnum::PRIVATE);

// Group
$conversation = $service->create(
    creator: $user,
    participants: [$user1, $user2, $user3],
    type: ConversationTypeEnum::GROUP,
    name: 'Project Discussion',
);

// Channel
$conversation = $service->create(
    creator: $user,
    participants: [$user1, $user2],
    type: ConversationTypeEnum::CHANNEL,
    name: 'Announcements',
);
```

#### `createPrivate()` — Create a 1-on-1 conversation

```php
$conversation = $service->createPrivate($user, $recipient);
```

- Automatically checks for existing conversations between the two users
- Returns the existing conversation if one already exists
- Throws `ValidationException` if trying to create a conversation with yourself

#### `createGroup()` — Create a group conversation

```php
$conversation = $service->createGroup(creator: $user, name: 'Team Chat', users: [$user1, $user2, $user3]);
```

- Creator is added as `admin`
- Other users are added as `member`

#### `createChannel()` — Create a channel

```php
$conversation = $service->createChannel(creator: $user, name: 'Announcements', users: [$user1, $user2]);
```

- Creator is added as `owner`
- Other users are added as `member`

#### `update()` — Update conversation details

```php
$conversation = $service->update($conversation, [
    'name' => 'Updated Name',
    'description' => 'New description',
    'avatar' => 'avatars/new-avatar.jpg',
]);
```

#### `archive()` — Archive or unarchive

```php
// Archive
$service->archive($conversation, true);

// Unarchive
$service->archive($conversation, false);
```

#### `lock()` — Lock or unlock

```php
// Lock (prevent new messages)
$service->lock($conversation, true);

// Unlock
$service->lock($conversation, false);
```

#### `addParticipant()` — Add a user

```php
$participant = $service->addParticipant($conversation, $user, 'member');
```

#### `removeParticipant()` — Remove a user

```php
$service->removeParticipant($conversation, $user);
```

#### `userConversations()` — Get user's conversations

```php
$conversations = $service->userConversations($user);
// Returns Collection with 'participants.user' and 'lastMessage' loaded
```

#### `hasParticipant()` — Check membership

```php
if ($service->hasParticipant($conversation, $user)) {
    // User is a participant
}
```

#### `participantsCount()` — Count participants

```php
$count = $service->participantsCount($conversation);
```

#### `delete()` — Soft-delete a conversation

```php
$service->delete($conversation);
```

### Model Relationships

```php
// Conversation model
$conversation->creator; // User who created it
$conversation->participants; // All participants
$conversation->messages; // All messages
$conversation->lastMessage; // Most recent message
```

### Casts

| Field         | Type                   | Description                      |
| ------------- | ---------------------- | -------------------------------- |
| `type`        | `ConversationTypeEnum` | private, group, channel          |
| `meta`        | `array`                | Custom metadata                  |
| `is_locked`   | `boolean`              | Whether messaging is disabled    |
| `is_archived` | `boolean`              | Whether conversation is archived |
