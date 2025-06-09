<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Campaign;
use App\Models\EmailTemplate;
use App\Models\EmailList;
use App\Jobs\SendEmailCampaign;

use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::where('user_id', Auth::id())
            ->with(['template', 'emailList'])
            ->get();
        return view('campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        $templates = EmailTemplate::where('user_id', Auth::id())->get();
        $emailLists = EmailList::where('user_id', Auth::id())
            ->withCount(['entries as valid_entries_count' => function($query) {
                $query->where('is_valid', true);
            }])
            ->get();
        
        return view('campaigns.create', compact('templates', 'emailLists'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'template_id' => 'required|exists:email_templates,id',
            'email_list_id' => 'required|exists:email_lists,id',
            'scheduled_at' => 'required|date'
        ]);

        $campaign = Campaign::create([
            'user_id' => Auth::id(),
            'subject' => $request->name,
            'email_template_id' => $request->template_id,
            'email_list_id' => $request->email_list_id,
            'scheduled_at' => $request->scheduled_at,
            'status' => 'pending'
        ]);

        return redirect()->route('campaigns.index')
            ->with('success', 'Campaign created successfully!');
    }

    // public function preview(Request $request)
    // {
    //     $request->validate([
    //         'email_template_id' => 'required|exists:email_templates,id',
    //         'subject' => 'required|string|max:255',
    //     ]);

    //     $template = EmailTemplate::findOrFail($request->email_template_id);

    //     // Ensure the user owns the template
    //     if ($template->user_id !== Auth::id()) {
    //         abort(403);
    //     }

    //     // Replace any placeholders in the template with sample data
    //     $content = $template->body;
    //     $content = str_replace('{{name}}', 'John Doe', $content);
    //     $content = str_replace('{{email}}', 'john@example.com', $content);
    //     // Add more placeholder replacements as needed

    //     return view('campaigns.preview', [
    //         'subject' => $request->subject,
    //         'body' => $content
    //     ]);
    // }

    public function destroy(Campaign $campaign)
    {
        if ($campaign->user_id !== Auth::id()) {
            abort(403);
        }

        $campaign->delete();
        return redirect()->route('campaigns.index')
            ->with('success', 'Campaign deleted successfully!');
    }
}