<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanOldLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clean-old-logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Cleaning old API logs...');

        $deleted = DB::table('logs')->where('created_at', '<', now()->subDays(30))->delete();

        $this->info("Deleted $deleted log entries.");
    }
}
