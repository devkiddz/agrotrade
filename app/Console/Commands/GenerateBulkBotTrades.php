<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\AutoTaskController;

class GenerateBulkBotTrades extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:bulk-trades {trades=20 : Number of trades to generate per bot}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate bulk trades for all active bot investments';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tradesPerBot = (int) $this->argument('trades');

        $this->info("🤖 Starting bulk bot trading generation...");
        $this->info("📊 Generating {$tradesPerBot} trades per bot investment");
        $this->newLine();

        try {
            $controller = new AutoTaskController();
            $response = $controller->generateBulkBotTrades($tradesPerBot);
            $data = $response->getData(true);

            if ($data['success']) {
                $this->info("✅ Success! Generated {$data['total_trades_created']} trades");
                $this->info("📈 Processed {$data['investments_processed']} bot investments");
                $this->newLine();

                // Display results table
                if (!empty($data['results'])) {
                    $this->info("📋 Results Summary:");
                    $headers = ['Bot Name', 'User Email', 'Trades', 'Success', 'Failed', 'Net Profit', 'Success Rate'];
                    $rows = [];

                    foreach ($data['results'] as $result) {
                        $rows[] = [
                            $result['bot_name'],
                            substr($result['user_email'], 0, 20) . '...',
                            $result['trades_created'],
                            $result['successful_trades'],
                            $result['failed_trades'],
                            '$' . $result['net_profit'],
                            $result['success_rate'] . '%'
                        ];
                    }

                    $this->table($headers, $rows);
                }

                $this->newLine();
                $this->info("🎉 Bulk trading generation completed successfully!");

            } else {
                $this->error("❌ Failed to generate trades: " . ($data['message'] ?? 'Unknown error'));
                return 1;
            }

        } catch (\Exception $e) {
            $this->error("❌ Error occurred: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
