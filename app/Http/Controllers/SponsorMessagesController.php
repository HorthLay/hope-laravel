<?php

namespace App\Http\Controllers;

use App\Models\SponsorMessage;
use App\Models\SponsorMessageThread;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SponsorMessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('sponsor.auth');
    }

    public function index()
    {
        $sponsor = Auth::guard('sponsor')->user();

        $sponsor->load(['families', 'children']);

        $families = $sponsor->families;
        $children = $sponsor->children;
        $settingsFile = storage_path('app/settings.json');
    $settings = file_exists($settingsFile)
        ? json_decode(file_get_contents($settingsFile), true)
        : [];

        $threads = SponsorMessageThread::where('sponsor_id', $sponsor->id)
            ->with(['messages' => fn ($q) => $q->orderBy('created_at', 'asc')])
            ->latest('updated_at')
            ->get()
            ->map(function ($thread) use ($sponsor) {

                $photo = null;
                $entityName = 'General';
                $entityType = $thread->entity_type ?? 'general';

                if ($entityType === 'child' && $thread->entity_id) {
                    $child = $sponsor->children->firstWhere('id', $thread->entity_id);
                    if ($child) {
                        $entityName = $child->first_name . ' ' . $child->last_name;
                        $photo = $child->profile_photo;
                    }
                }

                if ($entityType === 'family' && $thread->entity_id) {
                    $family = $sponsor->families->firstWhere('id', $thread->entity_id);
                    if ($family) {
                        $entityName = $family->name;
                        $photo = $family->profile_photo;
                    }
                }

                $lastMsg = $thread->messages->last();

                $lastBody = $lastMsg
                    ? Str::limit($lastMsg->body ?? '', 60)
                    : 'No messages yet';

                $lastDate = $lastMsg
                    ? $lastMsg->created_at?->diffForHumans()
                    : $thread->created_at?->diffForHumans();

                $unreadCount = $thread->messages
                    ->where('sender', '!=', 'sponsor')
                    ->whereNull('read_at')
                    ->count();

                $messages = $thread->messages->map(fn ($msg) => [
                    'id'              => $msg->id,
                    'sender'          => $msg->sender,
                    'body'            => $msg->body,
                    'created_at'      => $msg->created_at?->toISOString(),
                    'read_at'         => $msg->read_at?->toISOString(),
                    'attachment_url'  => $msg->attachment_path
                        ? asset('storage/' . $msg->attachment_path)
                        : null,
                    'attachment_name' => $msg->attachment_name,
                    'attachment_size' => $msg->attachment_size,
                ])->values();

                return [
                    'id'           => $thread->id,
                    'name'         => $entityName,
                    'photo'        => $photo,
                    'entity_type'  => $entityType,
                    'entity_id'    => $thread->entity_id,
                    'subject'      => $thread->subject,
                    'last_message' => $lastBody,
                    'last_date'    => $lastDate,
                    'last_sender'  => $lastMsg?->sender,
                    'unread_count' => $unreadCount,
                    'messages'     => $messages,
                ];
            });

        return view('sponsor.messages', compact(
            'sponsor',
            'families',
            'children',
            'threads',
            'settings',
        ));
    }

    public function send(Request $request)
    {
        $request->validate([
            'entity_type' => 'required|string',
            'subject'     => 'required|string|max:255',
            'message'     => 'required|string|max:4000',
            'attachment'  => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png',
        ]);

        $sponsor = Auth::guard('sponsor')->user();

        [$entityType, $entityId] = match (true) {
            str_starts_with($request->entity_type, 'child_')  => ['child', (int) Str::after($request->entity_type, 'child_')],
            str_starts_with($request->entity_type, 'family_') => ['family', (int) Str::after($request->entity_type, 'family_')],
            default => ['general', null],
        };

        $thread = SponsorMessageThread::create([
            'sponsor_id'  => $sponsor->id,
            'entity_type' => $entityType,
            'entity_id'   => $entityId,
            'subject'     => $request->subject,
        ]);

        $attachPath = null;
        $attachName = null;
        $attachSize = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');

            $attachPath = $file->store('uploads/messages', 'public');
            $attachName = $file->getClientOriginalName();
            $attachSize = $this->formatFileSize($file->getSize());
        }

        $thread->messages()->create([
            'sender'          => 'sponsor',
            'body'            => $request->message,
            'attachment_path' => $attachPath,
            'attachment_name' => $attachName,
            'attachment_size' => $attachSize,
            'read_at'         => now(),
        ]);

        return redirect()->route('sponsor.messages.home')
            ->with('success', 'Your message has been sent successfully!');
    }

    public function reply(Request $request)
    {
        $request->validate([
            'thread_id'  => 'required|integer',
            'message'    => 'nullable|string|max:4000',
            'attachment' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png',
        ]);

        if (!$request->message && !$request->hasFile('attachment')) {
            return response()->json([
                'success' => false,
                'error'   => 'Message or attachment is required.',
            ], 422);
        }

        $sponsor = Auth::guard('sponsor')->user();

        $thread = SponsorMessageThread::where('id', $request->thread_id)
            ->where('sponsor_id', $sponsor->id)
            ->firstOrFail();

        $attachPath = null;
        $attachName = null;
        $attachSize = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');

            $attachPath = $file->store('uploads/messages', 'public');
            $attachName = $file->getClientOriginalName();
            $attachSize = $this->formatFileSize($file->getSize());
        }

        $message = $thread->messages()->create([
            'sender'          => 'sponsor',
            'body'            => $request->message,
            'attachment_path' => $attachPath,
            'attachment_name' => $attachName,
            'attachment_size' => $attachSize,
            'read_at'         => now(),
        ]);

        $thread->touch();

        return response()->json([
            'success' => true,
            'message' => [
                'id'              => $message->id,
                'sender'          => 'sponsor',
                'body'            => $message->body,
                'created_at'      => $message->created_at->toISOString(),
                'read_at'         => $message->read_at?->toISOString(),
                'attachment_url'  => $attachPath
                    ? asset('storage/' . $attachPath)
                    : null,
                'attachment_name' => $attachName,
                'attachment_size' => $attachSize,
            ],
        ]);
    }

    public function markRead(Request $request)
    {
        $request->validate(['thread_id' => 'required|integer']);

        $sponsor = Auth::guard('sponsor')->user();

        $thread = SponsorMessageThread::where('id', $request->thread_id)
            ->where('sponsor_id', $sponsor->id)
            ->firstOrFail();

        $thread->messages()
            ->where('sender', '!=', 'sponsor')
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    private function formatFileSize(int $bytes): string
    {
        if ($bytes >= 1048576) return round($bytes / 1048576, 1) . ' MB';
        if ($bytes >= 1024)    return round($bytes / 1024) . ' KB';
        return $bytes . ' B';
    }
}