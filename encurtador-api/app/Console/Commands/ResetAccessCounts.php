<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Link;

class ResetAccessCounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'link:reset-access-counts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset access count';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Link::query()->update(['views_count' => 0]);

        $this->info('Access counts reset successfully.');
    }
}
