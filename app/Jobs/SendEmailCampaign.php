<?php

namespace App\Jobs;

use App\Models\Campaign;
use App\Mail\CampaignEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmailCampaign implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Campaign $campaign;

    public function __construct(Campaign $campaign)
    {
        $this->campaign = $campaign;
    }

    public function handle()
    {
        try {
            // Update status to processing
            $this->campaign->update(['status' => 'processing']);

            $entries = $this->campaign->emailList->entries()
                ->where('is_valid', true)
                ->get();

            foreach ($entries as $entry) {
                Mail::to($entry->email)
                    ->send(new CampaignEmail($this->campaign, $entry));
            }

            // Update status to completed
            $this->campaign->update(['status' => 'completed']);
        } catch (\Exception $e) {
            // Update status to failed if there's an error
            $this->campaign->update(['status' => 'failed']);
            throw $e;
        }
    }
}
