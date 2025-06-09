<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Campaign;
use Carbon\Carbon;

class CheckCampaigns extends Command
{
    protected $signature = 'campaigns:check';
    protected $description = 'Check status of all campaigns';

    public function handle()
    {
        $campaigns = Campaign::all();
        
        $this->info('Current time: ' . Carbon::now());
        $this->info('Total campaigns: ' . $campaigns->count());
        
        foreach ($campaigns as $campaign) {
            $this->info("\nCampaign: {$campaign->subject}");
            $this->info("Status: {$campaign->status}");
            $this->info("Scheduled at: {$campaign->scheduled_at}");
            $this->info("Is past scheduled time: " . ($campaign->scheduled_at <= Carbon::now() ? 'Yes' : 'No'));
            $this->info("Time until scheduled: " . Carbon::now()->diffForHumans($campaign->scheduled_at));
            $this->info("Template ID: {$campaign->email_template_id}");
            $this->info("List ID: {$campaign->email_list_id}");
        }
    }
} 