# Participants

## ParticipantService

The `ParticipantService` manages user membership in conversations, including roles, permissions, and per-user settings.

### Dependency Injection

```php
use Packages\Chat\Services\ParticipantService;

class YourController extends Controller
{
    public function __construct(protected ParticipantService $participantService) {}
}
```

### Methods

#### `add()` — Add a user to a conversation

```php
// Add as member (default)
$participant = $service->add($conversation, $user);

// Add with specific role
$participant = $service->add($conversation, $user, 'admin');
```

Uses `firstOrCreate` — safe to call multiple times.

#### `remove()` — Remove a user from a conversation

```php
$service->remove($conversation, $user);
```

#### `updateRole()` — Change a participant's role

```php
$participant = $service->updateRole($participant, 'moderator');
```

#### `toggleMute()` — Mute/unmute notifications

```php
$isMuted = $service->toggleMute($conversation, $user);
// Returns the new state (bool)
```

#### `togglePin()` — Pin/unpin conversation

```php
$isPinned = $service->togglePin($conversation, $user);
// Returns the new state (bool)
```

#### `block()` / `unblock()` — Block a participant

```php
// Block (admin action)
$service->block($participant);

// Unblock
$service->unblock($participant);
```

#### `updateSettings()` — Update participant settings

```php
$service->updateSettings($conversation, $user, [
    'notifications' => 'mentions_only',
    'theme' => 'dark',
]);
```

#### `leave()` — Mark participant as having left

```php
$service->leave($conversation, $user);
// Sets 'left_at' timestamp (does not delete the record)
```

#### `getParticipants()` — Get all participants

```php
$participants = $service->getParticipants($conversation);
// Returns Collection with 'user' relationship loaded
```

#### `getParticipant()` — Get a single participant record

```php
$participant = $service->getParticipant($conversation, $user);
// Returns Participant or null
```

#### `getActiveParticipants()` — Get non-blocked participants

```php
$active = $service->getActiveParticipants($conversation);
```

### Participant Roles

```php
ParticipantRoleEnum::MEMBER       // Regular member — can send and read messages
ParticipantRoleEnum::MODERATOR    // Moderator — can delete messages
ParticipantRoleEnum::ADMIN        // Admin — can manage participants and delete messages
ParticipantRoleEnum::OWNER        // Owner — full control
```

### Role Permissions

```php
$role = ParticipantRoleEnum::ADMIN;

$role->canManageParticipants(); // true for ADMIN, OWNER
$role->canDeleteMessages(); // true for ADMIN, MODERATOR, OWNER
```

### Model Casts

| Field          | Type                  | Description                     |
| -------------- | --------------------- | ------------------------------- |
| `role`         | `ParticipantRoleEnum` | member, admin, moderator, owner |
| `joined_at`    | `datetime`            | When user joined                |
| `left_at`      | `datetime`            | When user left                  |
| `last_read_at` | `datetime`            | Last read timestamp             |
| `last_seen_at` | `datetime`            | Last seen timestamp             |
| `is_muted`     | `boolean`             | Notifications muted             |
| `is_pinned`    | `boolean`             | Conversation pinned             |
| `is_blocked`   | `boolean`             | User blocked                    |
| `settings`     | `array`               | Custom per-user settings        |

### Model Relationships

```php
$participant->conversation; // Parent conversation
$participant->user; // The user
$participant->lastReadMessage; // Last message the user read
```
