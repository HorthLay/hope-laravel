{{-- resources/views/livewire/messages-admin-chat.blade.php --}}

<div
    wire:poll.3000ms="poll"
    class="amc-wrap"
    x-data="{
        attachName: '',
        attachPreview: null,
        editFocused: false,

        scrollBottom() {
            const el = document.getElementById('amc-body');
            if (el) el.scrollTop = el.scrollHeight;
        },

        autoResize(el) {
            el.style.height = 'auto';
            el.style.height = Math.min(el.scrollHeight, 120) + 'px';
        },

        removeAttach() {
            this.attachName    = '';
            this.attachPreview = null;
            $wire.set('attachment', null);
            const fi = document.getElementById('amc-file');
            if (fi) fi.value = '';
        },

        handleFileChange(e) {
            const file = e.target.files[0];
            if (!file) return;
            this.attachName = file.name;
            if (file.type.startsWith('image/')) {
                const r = new FileReader();
                r.onload = ev => { this.attachPreview = ev.target.result; };
                r.readAsDataURL(file);
            } else {
                this.attachPreview = null;
            }
        },

        handleEnter(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                $wire.sendMessage();
            }
        }
    }"
    x-init="
        scrollBottom();
        $nextTick(() => _amcConvertTimes());
        $wire.on('scroll-bottom', () => { $nextTick(() => { scrollBottom(); _amcConvertTimes(); }); });
        $wire.on('new-messages',  () => { $nextTick(() => { scrollBottom(); _amcConvertTimes(); }); });
        $wire.on('focus-edit',    () => { $nextTick(() => { const el = document.getElementById('amc-edit-input'); if (el) el.focus(); }); });
    "
>

{{-- ═══ DELETE CONFIRMATION MODAL ═══ --}}
@if($deleteConfirmId)
<div class="amc-modal-overlay" x-transition>
    <div class="amc-modal" @click.outside="$wire.cancelDelete()">
        <div class="amc-modal-icon amc-modal-icon--red">
            <i class="fas fa-trash-alt"></i>
        </div>
        <h3 class="amc-modal-title">Delete message?</h3>
        <p class="amc-modal-desc">This message will be permanently removed and cannot be undone.</p>
        <div class="amc-modal-actions">
            <button wire:click="cancelDelete" class="amc-btn amc-btn--ghost">Cancel</button>
            <button wire:click="deleteMessage" class="amc-btn amc-btn--danger">
                <i class="fas fa-trash-alt"></i> Delete
            </button>
        </div>
    </div>
</div>
@endif

{{-- ═══ TWO-PANEL LAYOUT ═══ --}}
<div class="amc-layout">

    {{-- ── LEFT: Thread sidebar ── --}}
    <div class="amc-sidebar">

        {{-- Sidebar header --}}
        <div class="amc-sidebar-head">
            <div>
                <h2 class="amc-sidebar-title">
                    <i class="fas fa-headset"></i> Support Inbox
                </h2>
                <p class="amc-sidebar-sub">{{ count($threads) }} conversation{{ count($threads) !== 1 ? 's' : '' }}</p>
            </div>
            @php $totalUnread = array_sum(array_column($threads, 'unread_count')); @endphp
            @if($totalUnread > 0)
            <span class="amc-badge amc-badge--orange">{{ $totalUnread }}</span>
            @endif
        </div>

        {{-- Search --}}
        <div class="amc-search-wrap">
            <i class="fas fa-search amc-search-icon"></i>
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search sponsors…"
                class="amc-search-input"
            >
        </div>

        {{-- Thread list --}}
        <div class="amc-thread-list" id="amc-thread-list">
            @forelse($threads as $thread)
            <div
                class="amc-thread {{ $selectedId === $thread['id'] ? 'amc-thread--active' : '' }} {{ $thread['unread_count'] > 0 ? 'amc-thread--unread' : '' }}"
                wire:click="selectThread({{ $thread['id'] }})"
                wire:key="thread-{{ $thread['id'] }}"
            >
                <div class="amc-thread-avatar {{ $thread['unread_count'] > 0 ? 'amc-thread-avatar--unread' : '' }}">
                    {{ $thread['sponsor_init'] }}
                    @if($thread['unread_count'] > 0)
                    <span class="amc-thread-dot"></span>
                    @endif
                </div>
                <div class="amc-thread-body">
                    <div class="amc-thread-row1">
                        <span class="amc-thread-name">{{ $thread['sponsor_name'] }}</span>
                        <span class="amc-thread-time">{{ $thread['last_date'] }}</span>
                    </div>
                    <div class="amc-thread-preview">
                        @if($thread['last_sender'] === 'admin')
                            <span class="amc-you">You: </span>
                        @endif
                        {{ $thread['last_message'] }}
                    </div>
                    <div class="amc-thread-meta">
                        <span class="amc-tag">{{ $thread['subject'] }}</span>
                        @if($thread['unread_count'] > 0)
                        <span class="amc-badge amc-badge--sm">{{ $thread['unread_count'] }}</span>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="amc-thread-empty">
                <i class="far fa-comments"></i>
                <p>No conversations yet</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- ── RIGHT: Chat panel ── --}}
    <div class="amc-chat">

        @if(!$selectedId)
        <div class="amc-chat-empty">
            <div class="amc-chat-empty-icon"><i class="fas fa-comments"></i></div>
            <h3>Select a conversation</h3>
            <p>Choose a sponsor thread from the left to view and reply to their messages.</p>
        </div>

        @else
        {{-- Chat header --}}
        <div class="amc-chat-header">
            <div class="amc-chat-avatar-lg">{{ $activeSponsorInit }}</div>
            <div class="amc-chat-header-info">
                <div class="amc-chat-header-name">{{ $activeSponsorName }}</div>
                <div class="amc-chat-header-sub">
                    <span class="amc-online-dot"></span>
                    {{ $activeSponsorEmail }}
                    <span class="amc-dot-sep">·</span>
                    {{ $activeSubject }}
                    <span class="amc-dot-sep">·</span>
                    {{-- Timezone badge: shows admin's local tz --}}
                    <span class="amc-tz-badge" id="amc-tz-label" title="Your local timezone">
                        <i class="fas fa-clock" style="font-size:9px"></i>
                        <span id="amc-tz-name">Local time</span>
                    </span>
                </div>
            </div>
            <div class="amc-chat-header-actions">
                <button wire:click="markAdminRead({{ $selectedId }})" class="amc-icon-btn" title="Mark all as read">
                    <i class="fas fa-check-double"></i>
                </button>
            </div>
        </div>

        {{-- Messages body --}}
        <div class="amc-body" id="amc-body">

            @if(empty($messages))
            <div class="amc-chat-empty" style="flex:1">
                <div class="amc-chat-empty-icon" style="width:56px;height:56px;font-size:22px">
                    <i class="far fa-comment-dots"></i>
                </div>
                <p style="font-size:13px;color:#9ca3af">No messages in this thread yet.</p>
            </div>
            @else
                @php $lastDate = null; @endphp

                @foreach($messages as $msg)
                    @php
                        $dt        = new \DateTime($msg['created_at']);
                        $today     = new \DateTime('today');
                        $yest      = new \DateTime('yesterday');
                        $isAdmin   = $msg['sender'] === 'admin';
                        $isSpnsr   = $msg['sender'] === 'sponsor';
                        $isEditing = $editingId === $msg['id'];
                        $isUnread  = $isSpnsr && empty($msg['admin_read_at']);

                        // PHP server-side fallbacks (JS will override with local tz)
                        $dateLabel = match(true) {
                            $dt->format('Y-m-d') === $today->format('Y-m-d') => 'Today',
                            $dt->format('Y-m-d') === $yest->format('Y-m-d')  => 'Yesterday',
                            default => $dt->format('F j, Y'),
                        };
                        $timeLabel = $dt->format('g:i A');
                        $lp        = $msg['link_preview'] ?? null;
                        $isImg     = $msg['is_image'] ?? false;
                    @endphp

                    {{-- Date divider — data-utc-date lets JS relabel in viewer's local timezone --}}
                    @if($dateLabel !== $lastDate)
                        <div class="amc-date-div">
                            <span data-utc-date="{{ $msg['created_at'] }}">{{ $dateLabel }}</span>
                        </div>
                        @php $lastDate = $dateLabel; @endphp
                    @endif

                    {{-- Message row --}}
                    <div class="amc-msg-row {{ $isAdmin ? 'amc-msg-row--me' : '' }}" wire:key="msg-{{ $msg['id'] }}">

                        @if($isAdmin)
                            <div class="amc-msg-icon amc-msg-icon--admin">
                                <i class="fas fa-shield-alt" style="font-size:10px"></i>
                            </div>
                        @else
                            <div class="amc-msg-icon amc-msg-icon--sponsor {{ $isUnread ? 'amc-msg-icon--unread' : '' }}">
                                {{ $activeSponsorInit }}
                            </div>
                        @endif

                        <div class="amc-bubble-wrap {{ $isAdmin ? 'amc-bubble-wrap--me' : '' }}">

                            @if($isEditing)
                                <div class="amc-edit-box">
                                    <textarea
                                        wire:model="editBody"
                                        id="amc-edit-input"
                                        class="amc-edit-textarea"
                                        rows="2"
                                        x-on:keydown.enter.prevent.exact="$wire.saveEdit()"
                                        x-on:keydown.escape="$wire.cancelEdit()"
                                    ></textarea>
                                    <div class="amc-edit-actions">
                                        <span style="font-size:10px;color:#9ca3af">Enter to save · Esc to cancel</span>
                                        <div style="display:flex;gap:6px">
                                            <button wire:click="cancelEdit" class="amc-btn amc-btn--xs amc-btn--ghost">Cancel</button>
                                            <button wire:click="saveEdit"   class="amc-btn amc-btn--xs amc-btn--primary">Save</button>
                                        </div>
                                    </div>
                                </div>

                            @else
                                {{-- Image bubble --}}
                                @if(!empty($msg['attachment_url']) && $isImg)
                                    <div class="amc-bubble {{ $isAdmin ? 'amc-bubble--admin' : 'amc-bubble--sponsor' }} amc-bubble--img {{ $isUnread ? 'amc-bubble--unread' : '' }}">
                                        <a href="{{ $msg['attachment_url'] }}" target="_blank" class="amc-img-link">
                                            <img src="{{ $msg['attachment_url'] }}" alt="Image" class="amc-img" loading="lazy">
                                            <div class="amc-img-overlay"><i class="fas fa-expand-alt"></i></div>
                                        </a>
                                        @if(!empty($msg['body']))<p class="amc-img-caption">{{ $msg['body'] }}</p>@endif
                                    </div>

                                {{-- File bubble --}}
                                @elseif(!empty($msg['attachment_url']) && !$isImg)
                                    <div class="amc-bubble {{ $isAdmin ? 'amc-bubble--admin' : 'amc-bubble--sponsor' }} {{ $isUnread ? 'amc-bubble--unread' : '' }}">
                                        @if(!empty($msg['body']))<p style="margin-bottom:8px">{{ $msg['body'] }}</p>@endif
                                        @php
                                            $ext2  = strtolower(pathinfo($msg['attachment_name'] ?? '', PATHINFO_EXTENSION));
                                            $fIcon = match(true) {
                                                $ext2 === 'pdf'                 => 'fa-file-pdf',
                                                in_array($ext2, ['doc','docx']) => 'fa-file-word',
                                                default                         => 'fa-file',
                                            };
                                        @endphp
                                        <a href="{{ $msg['attachment_url'] }}" class="amc-file-att {{ !$isAdmin ? 'amc-file-att--sponsor' : '' }}" download target="_blank">
                                            <i class="fas {{ $fIcon }}" style="{{ $isAdmin ? 'color:#fff' : 'color:#f97316' }}"></i>
                                            <div style="flex:1;min-width:0">
                                                <div style="font-size:12px;font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $msg['attachment_name'] ?? 'File' }}</div>
                                                <div style="font-size:10px;opacity:.7">{{ $msg['attachment_size'] ?? '' }}</div>
                                            </div>
                                            <i class="fas fa-download" style="font-size:11px;opacity:.7{{ $isAdmin ? ';color:#fff' : '' }}"></i>
                                        </a>
                                    </div>

                                {{-- Text bubble --}}
                                @elseif(!empty($msg['body']))
                                    <div class="amc-bubble {{ $isAdmin ? 'amc-bubble--admin' : 'amc-bubble--sponsor' }} {{ $isUnread ? 'amc-bubble--unread' : '' }}">
                                        {!! nl2br(e($msg['body'])) !!}
                                    </div>
                                @endif

                                {{-- Link preview --}}
                                @if($lp)
                                <a href="{{ $lp['url'] }}" target="_blank" rel="noopener" class="amc-link-preview {{ $isAdmin ? 'amc-lp--admin' : 'amc-lp--sponsor' }}">
                                    @if(!empty($lp['image']))<img src="{{ $lp['image'] }}" class="amc-lp-img" alt="" loading="lazy" onerror="this.style.display='none'">@endif
                                    <div style="padding:10px 12px;display:flex;flex-direction:column;gap:3px">
                                        <div class="amc-lp-host"><i class="fas fa-globe" style="font-size:9px;margin-right:3px"></i>{{ $lp['host'] ?? '' }}</div>
                                        @if(!empty($lp['title']))<div class="amc-lp-title">{{ $lp['title'] }}</div>@endif
                                        @if(!empty($lp['description']))<div class="amc-lp-desc">{{ $lp['description'] }}</div>@endif
                                    </div>
                                </a>
                                @endif
                            @endif

                            {{-- Meta: time (local tz via JS) + edit/delete actions --}}
                            <div class="amc-msg-meta {{ $isAdmin ? 'amc-msg-meta--me' : '' }} {{ $isUnread ? 'amc-msg-meta--unread' : '' }}">
                                @if(!$isAdmin)
                                    <span style="font-weight:{{ $isUnread ? '800' : '700' }};color:{{ $isUnread ? '#f97316' : '#6b7280' }}">
                                        {{ $activeSponsorName }}
                                    </span> ·
                                @endif

                                {{-- data-utc-time → JS converts to viewer's local timezone --}}
                                <time data-utc-time="{{ $msg['created_at'] }}"
                                      title="UTC: {{ $dt->format('Y-m-d H:i') }}">
                                    {{ $timeLabel }}
                                </time>

                                @if($msg['is_edited'])<span class="amc-edited">(edited)</span>@endif
                                @if($isUnread)<span class="amc-unread-dot"></span>@endif

                                @if(!$isEditing)
                                <div class="amc-msg-actions">
                                    @if($isAdmin)
                                    <button wire:click="startEdit({{ $msg['id'] }})" class="amc-action-btn amc-action-btn--edit" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    @endif
                                    <button wire:click="confirmDelete({{ $msg['id'] }})" class="amc-action-btn amc-action-btn--del" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                                @endif
                            </div>

                        </div>
                    </div>
                @endforeach
            @endif

            <div wire:loading.delay wire:target="poll" class="amc-poll">
                <span></span><span></span><span></span>
            </div>
        </div>

        {{-- ── Input footer ── --}}
        <div class="amc-footer">
            <div x-show="attachPreview || attachName" x-cloak class="amc-attach-preview">
                <template x-if="attachPreview">
                    <div class="amc-img-preview-row">
                        <img :src="attachPreview" class="amc-preview-thumb" alt="">
                        <div style="flex:1;min-width:0">
                            <div x-text="attachName" style="font-size:12px;font-weight:700;color:#374151;overflow:hidden;text-overflow:ellipsis;white-space:nowrap"></div>
                            <div style="font-size:10px;color:#f97316;font-weight:600;margin-top:2px">Will be sent as WebP</div>
                        </div>
                        <button @click="removeAttach()" class="amc-remove-btn"><i class="fas fa-times"></i></button>
                    </div>
                </template>
                <template x-if="!attachPreview && attachName">
                    <div class="amc-file-preview-row">
                        <i class="fas fa-file" style="color:#f97316"></i>
                        <span x-text="attachName" style="font-size:12px;font-weight:700;color:#374151"></span>
                        <button @click="removeAttach()" class="amc-remove-btn"><i class="fas fa-times"></i></button>
                    </div>
                </template>
            </div>

            <div class="amc-form">
                <textarea
                    wire:model="newMessage"
                    id="amc-input"
                    placeholder="Reply to {{ $activeSponsorName }}…"
                    rows="1"
                    x-on:input="autoResize($el)"
                    x-on:keydown="handleEnter($event)"
                    class="amc-textarea"
                ></textarea>
                <div class="amc-form-actions">
                    <span class="amc-char" x-text="($wire.newMessage || '').length"></span>
                    <label class="amc-attach-label" title="Attach image or file">
                        <i class="fas fa-paperclip"></i>
                        <input type="file" id="amc-file" style="display:none"
                            wire:model="attachment"
                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.webp"
                            x-on:change="handleFileChange($event)">
                    </label>
                    <button class="amc-send-btn" wire:click="sendMessage"
                        wire:loading.attr="disabled" wire:target="sendMessage" title="Send (Enter)">
                        <span wire:loading.remove wire:target="sendMessage">
                            <i class="fas fa-paper-plane" style="font-size:12px;margin-left:1px"></i>
                        </span>
                        <span wire:loading wire:target="sendMessage">
                            <i class="fas fa-spinner fa-spin" style="font-size:12px"></i>
                        </span>
                    </button>
                </div>
            </div>

            {{-- Footer hint: shows viewer's detected timezone --}}
            <p class="amc-footer-hint">
                <i class="fas fa-lock" style="font-size:9px;margin-right:3px"></i>
                Admin reply ·
                <kbd>Enter</kbd> to send · <kbd>Shift+Enter</kbd> new line ·
                <i class="fas fa-clock" style="font-size:9px;margin-right:2px;color:#f97316"></i>
                <span id="amc-tz-footer">local time</span>
            </p>
        </div>
        @endif

    </div>
</div>

{{-- ═══ STYLES ═══ --}}
<style>
.amc-wrap { width: 100%; font-family: 'Plus Jakarta Sans', sans-serif; }

.amc-layout {
    display: grid; grid-template-columns: 300px 1fr;
    height: calc(100vh - 130px); min-height: 500px;
    background: #fff; border-radius: 16px;
    border: 1px solid #e5e7eb; box-shadow: 0 1px 12px rgba(0,0,0,.06); overflow: hidden;
}
.amc-sidebar { border-right: 1px solid #f3f4f6; display: flex; flex-direction: column; background: #fafafa; overflow: hidden; }
.amc-sidebar-head { padding: 18px 16px 12px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f3f4f6; flex-shrink: 0; }
.amc-sidebar-title { font-size: 14px; font-weight: 800; color: #111827; display: flex; align-items: center; gap: 7px; }
.amc-sidebar-title i { color: #f97316; }
.amc-sidebar-sub { font-size: 11px; color: #9ca3af; font-weight: 500; margin-top: 2px; }
.amc-search-wrap { padding: 10px 12px; border-bottom: 1px solid #f3f4f6; position: relative; flex-shrink: 0; }
.amc-search-icon { position: absolute; left: 22px; top: 50%; transform: translateY(-50%); color: #d1d5db; font-size: 11px; }
.amc-search-input { width: 100%; padding: 7px 10px 7px 28px; border: 1.5px solid #e5e7eb; border-radius: 9px; font-size: 12.5px; font-family: inherit; font-weight: 500; color: #374151; background: #fff; outline: none; transition: border-color .15s; }
.amc-search-input:focus { border-color: #f97316; }
.amc-thread-list { flex: 1; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #e5e7eb transparent; }
.amc-thread-list::-webkit-scrollbar { width: 3px; }
.amc-thread-list::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 3px; }
.amc-thread { padding: 12px 14px; display: flex; align-items: flex-start; gap: 10px; border-bottom: 1px solid #f9fafb; border-left: 3px solid transparent; cursor: pointer; transition: background .12s, border-color .15s; position: relative; }
.amc-thread:hover { background: #fff7ed; }
.amc-thread--active { background: #fff7ed; border-left-color: #f97316; }
.amc-thread--unread { background: #fff7ed; border-left-color: #f97316; }
.amc-thread--unread .amc-thread-name { font-weight: 900; color: #111827; }
.amc-thread--unread .amc-thread-preview { font-weight: 700; color: #374151; }
.amc-thread--unread .amc-thread-time { color: #f97316; font-weight: 800; }
.amc-thread-avatar { width: 38px; height: 38px; border-radius: 10px; flex-shrink: 0; background: linear-gradient(135deg, #f97316, #ea580c); color: #fff; font-size: 14px; font-weight: 900; display: flex; align-items: center; justify-content: center; position: relative; transition: box-shadow .2s; }
.amc-thread-avatar--unread { box-shadow: 0 0 0 2.5px #fff, 0 0 0 4.5px #f97316; animation: amcAvatarPulse 2.5s ease-in-out infinite; }
.amc-thread-dot { position: absolute; top: -3px; right: -3px; width: 10px; height: 10px; background: #f97316; border-radius: 50%; border: 2px solid #fafafa; animation: amcDotPop .3s cubic-bezier(.34,1.56,.64,1) both; }
.amc-thread-body { flex: 1; min-width: 0; }
.amc-thread-row1 { display: flex; align-items: center; justify-content: space-between; margin-bottom: 3px; }
.amc-thread-name { font-size: 12.5px; font-weight: 700; color: #111827; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px; transition: font-weight .15s, color .15s; }
.amc-thread-time { font-size: 10px; color: #9ca3af; font-weight: 600; flex-shrink: 0; transition: color .15s; }
.amc-thread-preview { font-size: 11.5px; color: #6b7280; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 4px; transition: font-weight .15s, color .15s; }
.amc-thread-meta { display: flex; align-items: center; gap: 5px; }
.amc-tag { font-size: 9px; font-weight: 800; padding: 2px 7px; border-radius: 999px; background: #fff3e0; color: #f97316; text-transform: uppercase; letter-spacing: .04em; }
.amc-thread-empty { display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 48px 24px; color: #d1d5db; text-align: center; gap: 8px; }
.amc-thread-empty i { font-size: 32px; }
.amc-thread-empty p { font-size: 12px; font-weight: 600; }
.amc-you { color: #f97316; font-weight: 700; }
.amc-badge { display: inline-flex; align-items: center; border-radius: 999px; font-weight: 900; }
.amc-badge--orange { background: #f97316; color: #fff; font-size: 10px; padding: 3px 9px; }
.amc-badge--sm     { background: #f97316; color: #fff; font-size: 9px; padding: 1px 6px; }
.amc-chat { display: flex; flex-direction: column; overflow: hidden; background: #fff; }
.amc-chat-header { padding: 14px 18px; border-bottom: 1px solid #f3f4f6; display: flex; align-items: center; gap: 12px; flex-shrink: 0; }
.amc-chat-avatar-lg { width: 42px; height: 42px; border-radius: 12px; flex-shrink: 0; background: linear-gradient(135deg, #f97316, #ea580c); color: #fff; font-size: 15px; font-weight: 900; display: flex; align-items: center; justify-content: center; }
.amc-chat-header-info { flex: 1; min-width: 0; }
.amc-chat-header-name { font-size: 14px; font-weight: 800; color: #111827; }
.amc-chat-header-sub { font-size: 11px; color: #9ca3af; font-weight: 500; margin-top: 2px; display: flex; align-items: center; gap: 5px; flex-wrap: wrap; }
.amc-online-dot { width: 6px; height: 6px; background: #22c55e; border-radius: 50%; animation: amcPulse 2s ease-in-out infinite; }
.amc-dot-sep { color: #d1d5db; }

/* Timezone badge in header */
.amc-tz-badge {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 10px; font-weight: 700; color: #9ca3af;
    background: #f3f4f6; border-radius: 6px; padding: 2px 6px;
    border: 1px solid #e5e7eb;
}

.amc-chat-header-actions { display: flex; gap: 6px; }
.amc-icon-btn { width: 34px; height: 34px; border-radius: 9px; background: #f9fafb; border: 1px solid #e5e7eb; color: #9ca3af; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 12px; transition: all .15s; font-family: inherit; }
.amc-icon-btn:hover { background: #fff7ed; color: #f97316; border-color: #f97316; }
.amc-body { flex: 1; overflow-y: auto; padding: 18px; display: flex; flex-direction: column; gap: 12px; scrollbar-width: thin; scrollbar-color: #e5e7eb transparent; }
.amc-body::-webkit-scrollbar { width: 4px; }
.amc-body::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 4px; }
.amc-chat-empty { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 12px; color: #9ca3af; padding: 48px; text-align: center; height: 100%; }
.amc-chat-empty-icon { width: 68px; height: 68px; border-radius: 18px; background: #fff7ed; display: flex; align-items: center; justify-content: center; font-size: 26px; color: #f97316; }
.amc-chat-empty h3 { font-size: 18px; font-weight: 700; color: #374151; }
.amc-chat-empty p  { font-size: 13px; max-width: 260px; line-height: 1.6; }
.amc-date-div { display: flex; align-items: center; gap: 10px; margin: 2px 0; }
.amc-date-div::before,.amc-date-div::after { content:''; flex:1; height:1px; background:#f3f4f6; }
.amc-date-div span { font-size: 10px; font-weight: 700; color: #d1d5db; background: #fff; padding: 2px 10px; border-radius: 999px; border: 1px solid #f3f4f6; white-space: nowrap; }
.amc-msg-row { display: flex; gap: 9px; align-items: flex-end; }
.amc-msg-row--me { flex-direction: row-reverse; }
.amc-msg-icon { width: 30px; height: 30px; border-radius: 9px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 900; color: #fff; transition: box-shadow .2s; }
.amc-msg-icon--admin   { background: linear-gradient(135deg, #f97316, #ea580c); }
.amc-msg-icon--sponsor { background: linear-gradient(135deg, #6366f1, #4f46e5); }
.amc-msg-icon--unread  { box-shadow: 0 0 0 2px #f97316, 0 0 10px rgba(249,115,22,.35); animation: amcIconPulse 2s ease-in-out infinite; }
.amc-bubble-wrap { display: flex; flex-direction: column; gap: 3px; max-width: 65%; }
.amc-bubble-wrap--me { align-items: flex-end; }
.amc-bubble { padding: 10px 13px; border-radius: 15px; font-size: 13px; line-height: 1.65; font-weight: 500; word-break: break-word; }
.amc-bubble--sponsor { background: #f3f4f6; color: #111827; border-bottom-left-radius: 3px; }
.amc-bubble--admin   { background: linear-gradient(135deg, #f97316, #ea580c); color: #fff; border-bottom-right-radius: 3px; box-shadow: 0 3px 12px rgba(249,115,22,.3); }
.amc-bubble--unread  { font-weight: 700 !important; background: #fff8ed !important; border-left: 3px solid #f97316; color: #111827 !important; box-shadow: 0 2px 12px rgba(249,115,22,.13); }
.amc-msg-meta { font-size: 10px; color: #9ca3af; font-weight: 600; display: flex; align-items: center; gap: 5px; }
.amc-msg-meta--me { justify-content: flex-end; }
.amc-msg-meta--unread { color: #f97316 !important; font-weight: 700; }
.amc-edited { font-size: 9px; color: #d1d5db; font-style: italic; }
.amc-unread-dot { display: inline-block; width: 7px; height: 7px; background: #f97316; border-radius: 50%; flex-shrink: 0; animation: amcIconPulse 1.8s ease-in-out infinite; }
.amc-msg-meta time { cursor: default; }
.amc-bubble--img { padding: 5px; }
.amc-img-link { display: block; position: relative; border-radius: 10px; overflow: hidden; line-height: 0; }
.amc-img { width: 100%; max-width: 260px; height: auto; max-height: 300px; object-fit: cover; border-radius: 10px; display: block; transition: transform .2s; }
.amc-img-link:hover .amc-img { transform: scale(1.02); }
.amc-img-overlay { position: absolute; inset: 0; background: rgba(0,0,0,.3); display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity .15s; color: #fff; font-size: 17px; border-radius: 10px; }
.amc-img-link:hover .amc-img-overlay { opacity: 1; }
.amc-img-caption { font-size: 12px; padding: 5px 4px 2px; line-height: 1.5; }
.amc-file-att { display: flex; align-items: center; gap: 8px; text-decoration: none; background: rgba(255,255,255,.18); border-radius: 9px; padding: 7px 10px; border: 1px solid rgba(255,255,255,.25); transition: opacity .15s; }
.amc-file-att--sponsor { background: rgba(0,0,0,.04); border: 1px solid #e5e7eb; }
.amc-file-att:hover { opacity: .82; }
.amc-link-preview { display: flex; flex-direction: column; text-decoration: none; border-radius: 12px; overflow: hidden; border: 1.5px solid #e5e7eb; max-width: 280px; background: #fff; transition: box-shadow .2s, transform .2s; }
.amc-link-preview:hover { box-shadow: 0 4px 16px rgba(0,0,0,.1); transform: translateY(-2px); }
.amc-lp--admin { border-color: rgba(255,255,255,.3); background: rgba(255,255,255,.14); }
.amc-lp-img  { width: 100%; height: 130px; object-fit: cover; display: block; }
.amc-lp-host { font-size: 9px; font-weight: 800; text-transform: uppercase; letter-spacing: .06em; color: #f97316; }
.amc-lp--admin .amc-lp-host { color: rgba(255,255,255,.7); }
.amc-lp-title { font-size: 12px; font-weight: 700; color: #111827; line-height: 1.35; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.amc-lp--admin .amc-lp-title { color: #fff; }
.amc-lp-desc { font-size: 11px; color: #6b7280; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.amc-msg-actions { display: flex; gap: 3px; opacity: 0; transition: opacity .15s; }
.amc-msg-row:hover .amc-msg-actions { opacity: 1; }
.amc-action-btn { width: 22px; height: 22px; border-radius: 6px; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 9px; transition: all .15s; font-family: inherit; }
.amc-action-btn--edit { background: #fff7ed; color: #f97316; }
.amc-action-btn--edit:hover { background: #f97316; color: #fff; }
.amc-action-btn--del  { background: #fef2f2; color: #ef4444; }
.amc-action-btn--del:hover  { background: #ef4444; color: #fff; }
.amc-edit-box { background: #fff; border: 1.5px solid #f97316; border-radius: 12px; padding: 10px 12px; min-width: 260px; box-shadow: 0 2px 12px rgba(249,115,22,.15); }
.amc-edit-textarea { width: 100%; border: none; outline: none; resize: none; font-family: inherit; font-size: 13px; color: #374151; font-weight: 500; line-height: 1.6; background: none; min-height: 40px; }
.amc-edit-actions { display: flex; align-items: center; justify-content: space-between; margin-top: 8px; padding-top: 8px; border-top: 1px solid #f3f4f6; }
.amc-poll { display: flex; gap: 4px; align-items: center; justify-content: center; padding: 4px 0; opacity: .25; }
.amc-poll span { width: 4px; height: 4px; background: #9ca3af; border-radius: 50%; animation: amcBounce 1.2s ease-in-out infinite; }
.amc-poll span:nth-child(2) { animation-delay: .2s; }
.amc-poll span:nth-child(3) { animation-delay: .4s; }
.amc-footer { padding: 12px 14px 14px; border-top: 1px solid #f3f4f6; flex-shrink: 0; background: #fff; }
.amc-form { display: flex; align-items: flex-end; gap: 8px; background: #f9fafb; border-radius: 12px; border: 1.5px solid #e5e7eb; padding: 9px 10px; transition: border-color .15s, background .15s; }
.amc-form:focus-within { border-color: #f97316; background: #fff; }
.amc-textarea { flex: 1; background: none; border: none; outline: none; resize: none; font-family: inherit; font-size: 13px; color: #374151; font-weight: 500; line-height: 1.6; max-height: 120px; min-height: 22px; }
.amc-textarea::placeholder { color: #d1d5db; }
.amc-form-actions { display: flex; gap: 5px; align-items: center; }
.amc-char { font-size: 10px; color: #d1d5db; font-weight: 600; padding-bottom: 2px; }
.amc-attach-label { width: 32px; height: 32px; border-radius: 8px; background: none; border: 1.5px solid #e5e7eb; color: #9ca3af; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 12px; transition: all .15s; }
.amc-attach-label:hover { border-color: #f97316; color: #f97316; background: #fff7ed; }
.amc-send-btn { width: 36px; height: 36px; border-radius: 9px; background: #f97316; color: #fff; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 13px; transition: all .18s; box-shadow: 0 3px 10px rgba(249,115,22,.3); }
.amc-send-btn:hover  { background: #ea580c; transform: scale(1.05); }
.amc-send-btn:active { transform: scale(.96); }
.amc-send-btn:disabled { opacity: .6; cursor: not-allowed; transform: none; }
.amc-attach-preview { margin-bottom: 8px; }
.amc-img-preview-row,.amc-file-preview-row { display: flex; align-items: center; gap: 9px; background: #f9fafb; border-radius: 10px; padding: 7px 10px; border: 1.5px solid #e5e7eb; }
.amc-preview-thumb { width: 48px; height: 48px; border-radius: 7px; object-fit: cover; flex-shrink: 0; border: 1.5px solid #e5e7eb; }
.amc-remove-btn { background: none; border: none; cursor: pointer; color: #9ca3af; font-size: 13px; padding: 0 2px; line-height: 1; margin-left: auto; transition: color .12s; }
.amc-remove-btn:hover { color: #ef4444; }
.amc-footer-hint { font-size: 10px; color: #d1d5db; margin-top: 7px; font-weight: 600; padding: 0 1px; }
.amc-footer-hint kbd { background: #f3f4f6; border-radius: 3px; padding: 1px 5px; font-size: 9px; font-family: monospace; border: 1px solid #e5e7eb; }
.amc-btn { display: inline-flex; align-items: center; gap: 6px; padding: 9px 16px; border-radius: 9px; font-size: 13px; font-weight: 700; border: none; cursor: pointer; font-family: inherit; transition: all .15s; }
.amc-btn--primary { background: #f97316; color: #fff; box-shadow: 0 3px 10px rgba(249,115,22,.28); }
.amc-btn--primary:hover { background: #ea580c; }
.amc-btn--ghost   { background: #f3f4f6; color: #6b7280; }
.amc-btn--ghost:hover { background: #e5e7eb; }
.amc-btn--danger  { background: #ef4444; color: #fff; box-shadow: 0 3px 10px rgba(239,68,68,.28); }
.amc-btn--danger:hover { background: #dc2626; }
.amc-btn--xs { padding: 5px 11px; font-size: 11px; border-radius: 7px; }
.amc-modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,.5); backdrop-filter: blur(4px); z-index: 500; display: flex; align-items: center; justify-content: center; padding: 20px; }
.amc-modal { background: #fff; border-radius: 18px; padding: 28px 24px; width: 100%; max-width: 360px; box-shadow: 0 20px 60px rgba(0,0,0,.18); text-align: center; }
.amc-modal-icon { width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 22px; margin: 0 auto 14px; }
.amc-modal-icon--red { background: #fef2f2; color: #ef4444; }
.amc-modal-title { font-size: 17px; font-weight: 800; color: #111827; margin-bottom: 6px; }
.amc-modal-desc  { font-size: 13px; color: #6b7280; margin-bottom: 20px; line-height: 1.55; }
.amc-modal-actions { display: flex; gap: 10px; }
.amc-modal-actions .amc-btn { flex: 1; justify-content: center; }

@keyframes amcPulse      { 0%,100%{opacity:1} 50%{opacity:.35} }
@keyframes amcBounce     { 0%,60%,100%{transform:translateY(0);opacity:.4} 30%{transform:translateY(-5px);opacity:1} }
@keyframes amcIconPulse  { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.6;transform:scale(.92)} }
@keyframes amcAvatarPulse{ 0%,100%{box-shadow:0 0 0 2.5px #fff,0 0 0 4.5px #f97316} 50%{box-shadow:0 0 0 2.5px #fff,0 0 0 5.5px rgba(249,115,22,.45)} }
@keyframes amcDotPop     { from{transform:scale(0)} to{transform:scale(1)} }

@media (max-width: 900px) { .amc-layout { grid-template-columns: 260px 1fr; } }
@media (max-width: 680px) {
    .amc-layout { grid-template-columns: 1fr; height: auto; }
    .amc-sidebar { height: 260px; border-right: none; border-bottom: 1px solid #f3f4f6; }
    .amc-chat { height: calc(100dvh - 420px); min-height: 360px; }
}

/* ── Timezone conversion JS ── */
</style>

<script>
/**
 * _amcConvertTimes()
 * Converts all [data-utc-time] and [data-utc-date] elements to the
 * viewer's browser timezone using the Intl API.
 * Called on init, after scroll-bottom, and after new-messages events.
 */
function _amcConvertTimes() {
    const tz  = Intl.DateTimeFormat().resolvedOptions().timeZone;
    const now  = new Date();
    const pad  = (n) => String(n).padStart(2, '0');

    // Local YYYY-MM-DD strings for today and yesterday
    const localDateStr = (d) => {
        const parts = new Intl.DateTimeFormat('en-CA', { timeZone: tz }).formatToParts(d);
        const p = {};
        parts.forEach(x => { p[x.type] = x.value; });
        return `${p.year}-${p.month}-${p.day}`;
    };
    const todayStr = localDateStr(now);
    const yest     = new Date(now); yest.setDate(yest.getDate() - 1);
    const yestStr  = localDateStr(yest);

    // ── Convert time labels ──────────────────────────────────
    document.querySelectorAll('time[data-utc-time]').forEach(el => {
        try {
            const d = new Date(el.dataset.utcTime);
            // e.g. "6:45 PM" or "18:45" depending on locale
            el.textContent = d.toLocaleTimeString([], {
                hour: '2-digit', minute: '2-digit', timeZone: tz,
            });
            // Tooltip: show both local and UTC for transparency
            const utcStr = d.toLocaleString('en-GB', {
                timeZone: 'UTC', hour: '2-digit', minute: '2-digit',
                day: '2-digit', month: 'short',
            });
            el.title = `${tz} · UTC: ${utcStr}`;
        } catch (_) {}
    });

    // ── Convert date dividers ────────────────────────────────
    document.querySelectorAll('[data-utc-date]').forEach(el => {
        try {
            const d   = new Date(el.dataset.utcDate);
            const ds  = localDateStr(d);
            if (ds === todayStr) {
                el.textContent = 'Today';
            } else if (ds === yestStr) {
                el.textContent = 'Yesterday';
            } else {
                el.textContent = d.toLocaleDateString([], {
                    year: 'numeric', month: 'long', day: 'numeric', timeZone: tz,
                });
            }
        } catch (_) {}
    });

    // ── Update timezone labels in header + footer ────────────
    const shortTz = tz.split('/').pop().replace(/_/g, ' '); // e.g. "Phnom Penh"
    const tzEl  = document.getElementById('amc-tz-name');
    const tzFtr = document.getElementById('amc-tz-footer');
    if (tzEl)  tzEl.textContent  = shortTz;
    if (tzFtr) tzFtr.textContent = shortTz;
}

// Also re-run after every Livewire update (covers poll re-renders)
document.addEventListener('livewire:update', () => {
    requestAnimationFrame(() => _amcConvertTimes());
});
</script>

</div>{{-- /root --}}