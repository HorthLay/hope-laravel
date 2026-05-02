<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SponsorMessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('sponsor.auth');
    }

    /**
     * Render the messages page.
     * All chat logic is handled by App\Livewire\MessagesChat.
     * Children & families are passed so the header notification bell works.
     */
    public function index()
    {
        $sponsor = Auth::guard('sponsor')->user();
        $sponsor->load(['families.updates', 'families.documents', 'children.updates', 'children.documents']);

        $settingsFile = storage_path('app/settings.json');
        $settings     = file_exists($settingsFile)
            ? json_decode(file_get_contents($settingsFile), true)
            : [];

        $children = $sponsor->children;
        $families = $sponsor->families;

        return view('sponsor.messages', compact('sponsor', 'settings', 'children', 'families'));
    }
}