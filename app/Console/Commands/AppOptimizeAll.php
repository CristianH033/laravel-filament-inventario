<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AppOptimizeAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:optimize-all';

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
        $this->call('filament:cache-components');
        $this->call('icons:cache');
        $this->call('config:cache');
        $this->call('view:cache');
        $this->call('route:cache');
        $this->call('optimize');
    }
}
