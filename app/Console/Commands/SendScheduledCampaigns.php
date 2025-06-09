<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Campaign;
use App\Jobs\SendEmailCampaign;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SendScheduledCampaigns extends Command
{
    protected $signature = 'campaigns:send-scheduled';
    protected $description = 'Send all scheduled campaigns that are due';

    public function handle()
    {
        $now = Carbon::now();
        $this->info("Checking for campaigns at: " . $now);
        Log::info("Scheduler running at: " . $now);
        
        // Get all pending campaigns
        $campaigns = Campaign::where('status', 'pending')->get();
        $this->info("Total pending campaigns: " . $campaigns->count());
        Log::info("Found {$campaigns->count()} pending campaigns");

        foreach ($campaigns as $campaign) {
            $this->info("\nChecking campaign: {$campaign->subject}");
            $this->info("Scheduled for: {$campaign->scheduled_at}");
            $this->info("Time until scheduled: " . $now->diffForHumans($campaign->scheduled_at));
            
            if ($campaign->scheduled_at <= $now) {
                $this->info("Campaign is due - processing...");
                Log::info("Processing campaign: {$campaign->subject}");
                
                try {
                    SendEmailCampaign::dispatch($campaign);
                    $this->info("Successfully dispatched campaign: {$campaign->subject}");
                    Log::info("Successfully dispatched campaign: {$campaign->subject}");
                } catch (\Exception $e) {
                    $this->error("Failed to dispatch campaign {$campaign->subject}: " . $e->getMessage());
                    Log::error("Failed to dispatch campaign {$campaign->subject}: " . $e->getMessage());
                }
            } else {
                $this->info("Campaign is not due yet");
                Log::info("Campaign {$campaign->subject} is not due yet");
            }
        }

        $this->info("\nFinished checking campaigns");
        Log::info("Finished checking campaigns");
    }
} 