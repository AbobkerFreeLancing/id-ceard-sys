# Huwia ID Chat Package

A full-featured chat package for Laravel applications, supporting private conversations, group chats, and channels with real-time broadcasting, file attachments, and participant management.

## Features

- **Private Conversations** — 1-on-1 messaging between users
- **Group Chats** — Multi-user conversations with admin roles
- **Channels** — Broadcast-style channels with owner/moderator roles
- **Real-time Events** — Broadcasting via Laravel Reverb/Pusher
- **File Attachments** — Image, video, audio, and file uploads
- **Message Types** — Text, image, video, audio, file, location, contact, system
- **Participant Roles** — Owner, admin, moderator, member
- **Conversation Settings** — Archive, lock, mute, pin
- **Soft Deletes** — All models use soft deletes
- **Pagination** — Cursor-based message loading

## Package Structure

```
Bedaya/Chat/
├── ChatServiceProvider.php      # Service provider (auto-loads migrations, routes, views)
├── config/                      # Package configuration
├── Controllers/                 # API controllers
├── Database/
│   ├── Migrations/              # 4 migration files
│   └── Seeders/                 # Database seeders
├── Enums/
│   ├── ConversationTypeEnum.php # private, group, channel
│   ├── MessageTypeEnum.php      # text, image, video, audio, file, location, contact, system
│   ├── ParticipantRoleEnum.php  # member, admin, moderator, owner
│   └── AttachmentTypeEnum.php   # image, video, audio, file, voice
├── Events/
│   └── MessageSentEvent.php     # Real-time broadcast event
├── Models/
│   ├── Conversation.php         # Chat conversations
│   ├── Message.php              # Chat messages
│   ├── Participant.php          # Conversation participants
│   └── MessageAttachment.php    # File attachments
├── routes/
│   ├── api.php                  # API routes
│   └── web.php                  # Web routes
├── Services/
│   ├── ConversationService.php  # Conversation CRUD operations
│   ├── MessageService.php       # Message sending & management
│   ├── ParticipantService.php   # Participant management
│   └── AttachmentService.php    # File upload & management
├── Traits/                      # Shared traits
└── docs/                        # Documentation
```

## Quick Start

```php
use Packages\Chat\Services\ConversationService;
use Packages\Chat\Services\MessageService;

// 1. Create a private conversation
$conversation = app(ConversationService::class)->createPrivate($user, $recipient);

// 2. Send a message
$message = app(MessageService::class)->send(conversation: $conversation, sender: $user, body: 'Hello, world!');

// 3. Get user conversations
$conversations = app(ConversationService::class)->userConversations($user);
```

## Documentation Index

| Document                          | Description                                        |
| --------------------------------- | -------------------------------------------------- |
| [Installation](installation.md)   | Setup, configuration, and registration             |
| [Conversations](conversations.md) | Creating, managing, and listing conversations      |
| [Messages](messages.md)           | Sending, editing, deleting, and searching messages |
| [Participants](participants.md)   | Managing participants, roles, and permissions      |
| [Attachments](attachments.md)     | File uploads, storage, and URL generation          |
| [Events](events.md)               | Real-time broadcasting with Reverb/Pusher          |
| [API Reference](api-reference.md) | Full API endpoint documentation                    |
