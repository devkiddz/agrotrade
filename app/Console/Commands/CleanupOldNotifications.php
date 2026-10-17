<?php

namespace App\Console\Commands;

use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanupOldNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:cleanup {--days=30 : Number of days to keep notifications} {--read-only : Only delete read notifications}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up old notifications that are older than the specified number of days';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $days = $this->option('days');
        $readOnly = $this->option('read-only');

        $cutoffDate = Carbon::now()->subDays($days);

        $query = Notification::where('created_at', '<', $cutoffDate);

        if ($readOnly) {
            $query->where('is_read', true);
        }

        $count = $query->count();

        if ($count === 0) {
            $this->info('No old notifications found to delete.');
            return 0;
        }

        if ($this->confirm("This will delete {$count} notifications. Continue?", true)) {
            $deleted = $query->delete();
            $this->info("Successfully deleted {$deleted} old notifications.");
        } else {
            $this->info('Operation cancelled.');
        }

        return 0;
    }
}
