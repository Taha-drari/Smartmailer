<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\EmailList;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total counts
        $totalEmailLists = EmailList::count();
        $totalTemplates = EmailTemplate::count();
        $totalCampaigns = Campaign::count();

        // Get campaign statistics
        $campaignStats = Campaign::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // Get monthly campaign statistics
        $monthlyStats = Campaign::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // Get recent campaigns
        $recentCampaigns = Campaign::with(['template', 'emailList'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalEmailLists',
            'totalTemplates',
            'totalCampaigns',
            'campaignStats',
            'monthlyStats',
            'recentCampaigns'
        ));
    }
} 