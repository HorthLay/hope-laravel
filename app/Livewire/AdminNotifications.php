<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminNotifications extends Component
{
    public $notifications = [];
    public $unreadCount = null;

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $admin = Auth::guard('admin')->user();
        if ($admin) {
            $this->notifications = $admin->unreadNotifications()->latest()->take(10)->get();
            $newCount = $admin->unreadNotifications()->count();
            
            if ($this->unreadCount !== null && $newCount > $this->unreadCount) {
                $latest = $this->notifications->first();
                if ($latest) {
                    $this->dispatch('new-notification-toast', message: $latest->data['message'] ?? 'New notification received!');
                }
            }
            
            $this->unreadCount = $newCount;
        }
    }

    public function markAsRead($notificationId)
    {
        $admin = Auth::guard('admin')->user();
        if ($admin) {
            $notification = $admin->notifications()->find($notificationId);
            if ($notification) {
                $notification->markAsRead();
                $this->loadNotifications();
            }
        }
    }

    public function markAllAsRead()
    {
        $admin = Auth::guard('admin')->user();
        if ($admin) {
            $admin->unreadNotifications->markAsRead();
            $this->loadNotifications();
        }
    }

    public function render()
    {
        return view('livewire.admin-notifications');
    }
}

