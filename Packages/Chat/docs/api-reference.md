# API Reference

## Base URL

All endpoints are prefixed with `/api/chat` and require authentication via `auth:sanctum`.

## Authentication

All requests must include a valid Sanctum token:

```
Authorization: Bearer {your-token}
```

---

## Conversations

### List User Conversations

```
GET /api/chat/conversations
```

**Response:** Array of conversations with participants and last message.

```json
[
    {
        "id": 1,
        "type": "private",
        "name": null,
        "description": null,
        "avatar": null,
        "created_by": 1,
        "last_message_id": 5,
        "is_locked": false,
        "is_archived": false,
        "meta": null,
        "created_at": "2026-07-21T12:00:00Z",
        "updated_at": "2026-07-21T12:00:00Z",
        "participants": [...],
        "last_message": {...}
    }
]
```

### Get Conversation Messages

```
GET /api/chat/conversations/{conversation}
```

**Query Parameters:**

| Parameter   | Type    | Default | Description                                      |
| ----------- | ------- | ------- | ------------------------------------------------ |
| `per_page`  | integer | 50      | Messages per page                                |
| `before_id` | integer | null    | Load messages before this ID (cursor pagination) |

**Response:** Paginated messages with sender, attachments, and reply info.

### Create Conversation

```
POST /api/chat/conversations
```

**Request Body:**

```json
{
    "type": "private|group|channel",
    "name": "Optional name (required for group/channel)",
    "participants": [2, 3, 4]
}
```

**Response:** `201 Created` — The created conversation with participants.

---

## Messages

### Send Message

```
POST /api/chat/conversations/{conversation}/messages
```

**Request Body (JSON):**

```json
{
    "body": "Message content",
    "type": "text|image|video|audio|file|location|contact|system",
    "reply_to_id": 3
}
```

**Request Body (Multipart — for file uploads):**

```
body: "Message content"
files[]: @file1.jpg
files[]: @file2.pdf
```

**Response:** `201 Created` — The created message with sender, attachments, and replyTo.

### Update Message

```
PUT /api/chat/conversations/{conversation}/messages/{message}
```

**Request Body:**

```json
{
    "body": "Updated message content"
}
```

**Response:** The updated message.

### Delete Message

```
DELETE /api/chat/conversations/{conversation}/messages/{message}
```

**Response:** `200 OK`

```json
{
    "message": "Message deleted."
}
```

---

## Error Responses

### 422 Validation Error

```json
{
    "message": "The body field is required.",
    "errors": {
        "body": ["The body field is required."]
    }
}
```

### 401 Unauthenticated

```json
{
    "message": "Unauthenticated."
}
```

### 403 Forbidden

```json
{
    "message": "Conversation is locked."
}
// or
{
    "message": "Unauthorized to delete this message."
}
```
