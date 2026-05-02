{{-- resources/views/admin/messages/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Team Support Messages')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">

    {{-- ── Page header ── --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5">
        <div>
            <h1 class="text-2xl font-black text-gray-800 flex items-center gap-2">
                <div class="w-9 h-9 bg-orange-500 rounded-xl flex items-center justify-center">
                    <i class="fas fa-headset text-white text-sm"></i>
                </div>
                Support Messages
            </h1>
            <p class="text-sm text-gray-500 mt-0.5">
                Real-time conversations with sponsors · Replies go directly to their dashboard
            </p>
        </div>

        {{-- Live indicator --}}
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-500 shadow-sm">
            <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
            Live · syncs every 3s
        </div>
    </div>

    {{-- ── Livewire component ── --}}
    @livewire('messages-admin-chat')

</div>
@endsection