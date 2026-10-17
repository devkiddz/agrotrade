<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\AutoRoiController;

class ProcessInvestmentRoi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plans:process-roi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process ROI for active investment plans';

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
    public function handle(AutoRoiController $controller)
    {
        $this->info('Starting ROI processing for active plans...');

        $result = $controller->processAutomaticRoi();
        $resultData = json_decode($result->getContent(), true);

        if (isset($resultData['success']) && $resultData['success']) {
            $this->info($resultData['message']);
            return 0;
        } else {
            $this->error('Error processing ROI: ' . ($resultData['error'] ?? 'Unknown error'));
            return 1;
        }
    }
}
