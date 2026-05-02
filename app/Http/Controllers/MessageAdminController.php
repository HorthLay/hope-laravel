<?php

namespace App\Http\Controllers;

use App\Models\SponsorMessage;
use Illuminate\Http\Request;

class MessageAdminController extends Controller
{
   public function index()
   {
     return view('admin.messages.index');
   }

   public function unreadCount()
    {
        $count = SponsorMessage::where('sender', 'sponsor')
            ->whereNull('admin_read_at')
            ->count();
 
        return response()->json(['count' => $count]);
    }
}
