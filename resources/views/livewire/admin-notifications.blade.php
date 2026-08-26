<div wire:poll.30s="loadNotifications" class="relative group" x-data="{ open: false }" @click.outside="open = false">
    <!-- Bell Icon Trigger -->
    <button @click="open = !open" class="relative text-gray-700 hover:text-orange-500 transition focus:outline-none mt-1">
        <i class="fas fa-bell text-xl"></i>
        @if($unreadCount > 0)
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white shadow-sm leading-none">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </span>
        @endif
    </button>

    <!-- Dropdown Menu -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-2xl border border-gray-100 overflow-hidden z-50"
         style="display: none;">
        
        <div class="px-4 py-3 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h3 class="text-sm font-bold text-gray-800">Notifications</h3>
            @if($unreadCount > 0)
                <button wire:click="markAllAsRead" class="text-xs text-orange-500 hover:text-orange-600 font-semibold transition">
                    Mark all as read
                </button>
            @endif
        </div>

        <div class="max-h-80 overflow-y-auto">
            @forelse($notifications as $notification)
                <div class="px-4 py-3 border-b border-gray-50 hover:bg-orange-50/50 transition cursor-pointer flex gap-3 relative" wire:key="notification-{{ $notification->id }}">
                    
                    @php
                        $action = $notification->data['action'] ?? '';
                        $iconClass = 'fa-info-circle text-blue-500 bg-blue-100';
                        if ($action === 'created') $iconClass = 'fa-plus-circle text-green-500 bg-green-100';
                        if ($action === 'updated') $iconClass = 'fa-edit text-orange-500 bg-orange-100';
                        if ($action === 'deleted') $iconClass = 'fa-trash-alt text-red-500 bg-red-100';
                    @endphp

                    <div class="flex-shrink-0 mt-0.5">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center {{ explode(' ', $iconClass)[2] ?? 'bg-gray-100' }}">
                            <i class="fas {{ explode(' ', $iconClass)[0] ?? 'fa-info-circle' }} {{ explode(' ', $iconClass)[1] ?? 'text-gray-500' }} text-sm"></i>
                        </div>
                    </div>
                    
                    <div class="flex-1 min-w-0 pr-6">
                        <p class="text-sm text-gray-800 font-medium">
                            {{ $notification->data['message'] ?? 'New activity' }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">
                            {{ $notification->created_at->diffForHumans() }}
                        </p>
                    </div>

                    <button wire:click="markAsRead('{{ $notification->id }}')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-300 hover:text-gray-500 transition p-1" title="Mark as read">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
            @empty
                <div class="px-4 py-8 text-center">
                    <i class="fas fa-bell-slash text-gray-300 text-3xl mb-3"></i>
                    <p class="text-gray-500 text-sm">No new notifications</p>
                </div>
            @endforelse
        </div>

        <div class="px-4 py-2 bg-gray-50 border-t border-gray-100 text-center">
            <a href="#" class="text-xs text-gray-500 hover:text-gray-800 font-medium transition">
                View all history
            </a>
        </div>
    </div>
</div>
