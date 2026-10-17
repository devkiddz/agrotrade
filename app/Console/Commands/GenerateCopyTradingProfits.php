<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\User\UserCopyTradingController;

class GenerateCopyTradingProfits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'copytrade:generate-profits';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate profits for active copy trading positions';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Generating copy trading profits...');

        try {
            $controller = new UserCopyTradingController();
            $controller->automaticCopyTradingProfits();

            $this->info('Copy trading profits generated successfully!');
            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('Failed to generate copy trading profits: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
