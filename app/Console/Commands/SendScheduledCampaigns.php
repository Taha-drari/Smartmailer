<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Campaign;
use App\Jobs\SendEmailCampaign;
use Carbon\Carbon;

class SendScheduledCampaigns extends Command
{
    protected $signature = 'campaigns:send-scheduled';
    protected $description = 'Send all scheduled campaigns that are due';

    public function handle()
    {
        $now = Carbon::now();
        
        Campaign::where('status', 'pending')
            ->where('scheduled_at', '<=', $now)
            ->each(function ($campaign) {
                try {
                    SendEmailCampaign::dispatch($campaign);
                } catch (\Exception $e) {
                    $campaign->update(['status' => 'failed']);
                }
            });
    }
} 