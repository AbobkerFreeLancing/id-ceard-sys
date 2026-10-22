<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeModuleCommand extends Command
{
    protected $signature = 'module:make {name}';

    protected $description = 'Creates a new module';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        File::makeDirectory(app_path() . DIRECTORY_SEPARATOR . $this->argument('name'), 0755);
        echo "created";
    }
}
