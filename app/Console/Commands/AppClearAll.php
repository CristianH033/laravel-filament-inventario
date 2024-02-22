<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AppClearAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->call('filament:clear-cached-components');
        $this->call('icons:clear');
        $this->call('config:clear');
        $this->call('view:clear');
        $this->call('route:clear');
        $this->call('optimize:clear');
        $this->call('clear-compiled');
        $this->call('cache:clear');
    }
}
