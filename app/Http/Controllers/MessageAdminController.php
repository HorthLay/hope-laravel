<?php

namespace App\Http\Controllers;

use App\Models\SponsorMessage;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class MessageAdminController extends Controller
{
   public function index()
   {
     return view('admin.messages.index');
   }

     public function unreadCount(): JsonResponse
    {
        // Total unread across ALL threads
        $total = SponsorMessage::where('sender', 'sponsor')
            ->whereNull('admin_read_at')
            ->count();
 
        // Find the thread with the most-recently-arrived unread message
        $latestMsg = SponsorMessage::where('sender', 'sponsor')
            ->whereNull('admin_read_at')
            ->orderByDesc('created_at')
            ->with('thread.sponsor')
            ->first();
 
        $sponsor = $latestMsg?->thread?->sponsor;
 
        return response()->json([
            'count'        => $total,
            'sponsor_name' => $sponsor?->full_name ?? 'Sponsor',
            'sponsor_init' => strtoupper(substr($sponsor?->first_name ?? '?', 0, 1)),
            'preview'      => Str::limit(
                $latestMsg?->body ?? ($latestMsg?->attachment_name ?? 'Sent an attachment'),
                80
            ),
        ]);
    }
}
