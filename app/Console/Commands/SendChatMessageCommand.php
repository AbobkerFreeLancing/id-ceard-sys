<?php

namespace App\Console\Commands;

use App\Events\BroadcastChatEvent;
use Illuminate\Console\Command;

class SendChatMessageCommand extends Command
{
    protected $signature = 'bedaya:chat {--value=}';

    protected $description = 'Send new chat message';

    public function handle()
    {
        $msg = $this->option('value');

        broadcast(new BroadcastChatEvent($msg));

        $this->info("Broadcast sent with message {$msg}");
    }
}
