<?php

namespace App\Http\Controllers;
use App\Services\EmailValidationService;

use App\Models\EmailList;
use App\Models\EmailListEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailListController extends Controller
{
    public function index()
    {
        $emailLists = EmailList::where('user_id', Auth::id())
            ->withCount(['entries', 'entries as valid_entries_count' => function($query) {
                $query->where('is_valid', true);
            }, 'entries as invalid_entries_count' => function($query) {
                $query->where('is_valid', false);
            }])
            ->get();
        return view('email_lists.index', compact('emailLists'));
    }

    public function create()
    {
        return view('email_lists.create');
    }

    public function store(Request $request, EmailValidationService $validator)
    {
        $request->validate([
            'name' => 'required|string',
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        $list = EmailList::create([
            'user_id' => Auth::id(),
            'name' => $request->name
        ]);

        $csv = fopen($request->file('csv_file')->getRealPath(), 'r');
        while (($data = fgetcsv($csv, 1000, ',')) !== false) {
            $email = trim($data[0]);

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $isValid = $validator->validate($email);

                EmailListEntry::create([
                    'email_list_id' => $list->id,
                    'email' => $email,
                    'is_valid' => $isValid,
                ]);
            }
        }

        return redirect()->route('email-lists.index')->with('success', 'List uploaded and validated!');
    }

    public function show(EmailList $emailList)
    {
        // Ensure the user owns the list
        if ($emailList->user_id !== Auth::id()) {
            abort(403);
        }

        $entries = $emailList->entries()->paginate(20);
        $stats = [
            'total' => $emailList->entries()->count(),
            'valid' => $emailList->entries()->where('is_valid', true)->count(),
            'invalid' => $emailList->entries()->where('is_valid', false)->count(),
            'valid_percentage' => $emailList->entries()->count() > 0 
                ? round(($emailList->entries()->where('is_valid', true)->count() / $emailList->entries()->count()) * 100, 2)
                : 0
        ];

        return view('email_lists.show', compact('emailList', 'entries', 'stats'));
    }

    public function destroy(EmailList $emailList)
    {
        // Ensure the user owns the list
        if ($emailList->user_id !== Auth::id()) {
            abort(403);
        }

        $emailList->delete();
        return redirect()->route('email-lists.index')->with('success', 'List deleted successfully!');
    }
}
