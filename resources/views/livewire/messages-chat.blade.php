{{-- resources/views/livewire/messages-chat.blade.php --}}

@php
    $sponsor     = Auth::guard('sponsor')->user();
    $sponsorInit = strtoupper(substr($sponsor->first_name, 0, 1));
@endphp

<div
    wire:poll.4000ms="poll"
    class="chat-livewire-wrap"
    x-data="{
        attachName: '',
        attachPreview: null,

        scrollBottom() {
            const el = document.getElementById('chat-body');
            if (el) { el.scrollTop = el.scrollHeight; }
        },

        autoResize(el) {
            el.style.height = 'auto';
            el.style.height = Math.min(el.scrollHeight, 120) + 'px';
        },

        removeAttach() {
            this.attachName    = '';
            this.attachPreview = null;
            $wire.set('attachment', null);
            const fi = document.getElementById('file-attach');
            if (fi) fi.value = '';
        },

        handleFileChange(e) {
            const file = e.target.files[0];
            if (!file) return;
            this.attachName = file.name;
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = ev => { this.attachPreview = ev.target.result; };
                reader.readAsDataURL(file);
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
        $nextTick(() => _chatConvertTimes());
        $wire.on('scroll-bottom', () => { $nextTick(() => { scrollBottom(); _chatConvertTimes(); }); });
        $wire.on('new-messages',  () => { $nextTick(() => { scrollBottom(); _chatConvertTimes(); }); });
        $wire.on('focus-input',   () => { $nextTick(() => {
            const el = document.getElementById('msg-input');
            if (el) { el.focus(); el.setSelectionRange(el.value.length, el.value.length); }
        }); });
    "
>

    <div class="chat-panel">

        {{-- ── Header ── --}}
        <div class="chat-header">
            <div class="chat-header-icon">
                <i class="fas fa-headset"></i>
            </div>
            <div class="chat-header-info">
                <div class="chat-header-name">Support Team</div>
                <div class="chat-header-sub">
                    <span class="online-dot"></span>
                    <span>Des Ailes pour Grandir · Response within 48h</span>
                    <span style="color:#e5e7eb">·</span>
                    {{-- Viewer's detected timezone --}}
                    <span class="chat-tz-badge" title="Your local timezone">
                        <i class="fas fa-clock" style="font-size:9px"></i>
                        <span id="chat-tz-name">local time</span>
                    </span>
                </div>
            </div>
            <div class="chat-header-actions">
                @if($unreadCount > 0)
                <button class="chat-action-btn" title="Mark all read" wire:click="markRead">
                    <i class="fas fa-check-double"></i>
                </button>
                <span class="unread-chip">{{ $unreadCount }} new</span>
                @endif
            </div>
        </div>

        {{-- ── Messages body ── --}}
        <div class="chat-body" id="chat-body">

            @if(empty($messages))
                <div class="chat-empty">
                    <div class="chat-empty-icon"><i class="far fa-comments"></i></div>
                    <h3>Start a conversation</h3>
                    <p>Send a message to our support team. We'll get back to you within 48 hours.</p>
                </div>
            @else
                @php
                    $lastDate    = null;
                    $unreadStart = count($messages) - $unreadCount;
                    $bannerShown = false;
                @endphp

                @foreach($messages as $i => $msg)
                    @php
                        $dt       = new \DateTime($msg['created_at']);
                        $today    = new \DateTime('today');
                        $yest     = new \DateTime('yesterday');
                        $isMe     = $msg['sender'] === 'sponsor';
                        $isUnread = !$isMe && empty($msg['read_at']);

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

                    {{-- Date divider — JS re-labels in viewer's local timezone --}}
                    @if($dateLabel !== $lastDate)
                        <div class="date-divider">
                            <span data-utc-date="{{ $msg['created_at'] }}">{{ $dateLabel }}</span>
                        </div>
                        @php $lastDate = $dateLabel; @endphp
                    @endif

                    {{-- Unread banner --}}
                    @if(!$bannerShown && $unreadCount > 0 && $i === $unreadStart)
                        <div class="unread-banner">
                            <i class="fas fa-arrow-down" style="font-size:11px"></i>
                            {{ $unreadCount }} new message{{ $unreadCount > 1 ? 's' : '' }}
                        </div>
                        @php $bannerShown = true; @endphp
                    @endif

                    {{-- ── Message row ── --}}
                    <div class="msg-row {{ $isMe ? 'me' : '' }}">

                        @if($isMe)
                            <div class="msg-row-icon me-icon">{{ $sponsorInit }}</div>
                        @else
                            <div class="msg-row-icon {{ $isUnread ? 'msg-row-icon--unread' : '' }}">
                                <i class="fas fa-headset" style="font-size:10px;color:#fff"></i>
                            </div>
                        @endif

                        <div class="bubble-wrap">

                            {{-- Image bubble --}}
                            @if(!empty($msg['attachment_url']) && $isImg)
                                <div class="bubble {{ $isMe ? 'me' : 'them' }} bubble-img-wrap {{ $isUnread ? 'bubble--unread' : '' }}">
                                    <a href="{{ $msg['attachment_url'] }}" target="_blank" class="img-link">
                                        <img src="{{ $msg['attachment_url'] }}" alt="Sent image" class="chat-img" loading="lazy">
                                        <div class="img-overlay"><i class="fas fa-expand-alt"></i></div>
                                    </a>
                                    @if(!empty($msg['body']))<p class="img-caption">{{ $msg['body'] }}</p>@endif
                                </div>

                            {{-- File bubble --}}
                            @elseif(!empty($msg['attachment_url']) && !$isImg)
                                <div class="bubble {{ $isMe ? 'me' : 'them' }} {{ $isUnread ? 'bubble--unread' : '' }}">
                                    @if(!empty($msg['body']))<p style="margin-bottom:8px">{{ $msg['body'] }}</p>@endif
                                    @php
                                        $ext2 = strtolower(pathinfo($msg['attachment_name'] ?? '', PATHINFO_EXTENSION));
                                        $fIcon = match(true) {
                                            $ext2 === 'pdf'                 => 'fa-file-pdf',
                                            in_array($ext2, ['doc','docx']) => 'fa-file-word',
                                            default                         => 'fa-file',
                                        };
                                        $iconCol = $isMe ? 'color:#fff' : 'color:var(--orange)';
                                    @endphp
                                    <a href="{{ $msg['attachment_url'] }}" class="bubble-attachment {{ !$isMe ? 'them-att' : '' }}" download target="_blank">
                                        <i class="fas {{ $fIcon }}" style="{{ $iconCol }}"></i>
                                        <div class="att-info">
                                            <div class="att-name">{{ $msg['attachment_name'] ?? 'Attachment' }}</div>
                                            <div class="att-size">{{ $msg['attachment_size'] ?? '' }}</div>
                                        </div>
                                        <i class="fas fa-download att-dl" style="{{ $isMe ? 'color:#fff' : '' }}"></i>
                                    </a>
                                </div>

                            {{-- Text bubble --}}
                            @elseif(!empty($msg['body']))
                                <div class="bubble {{ $isMe ? 'me' : 'them' }} {{ $isUnread ? 'bubble--unread' : '' }}">
                                    {!! nl2br(e($msg['body'])) !!}
                                </div>
                            @endif

                            {{-- Link preview --}}
                            @if($lp)
                                <a href="{{ $lp['url'] }}" target="_blank" rel="noopener" class="link-preview {{ $isMe ? 'lp-me' : 'lp-them' }}">
                                    @if(!empty($lp['image']))<img src="{{ $lp['image'] }}" class="lp-img" alt="" loading="lazy" onerror="this.style.display='none'">@endif
                                    <div class="lp-body">
                                        <div class="lp-host"><i class="fas fa-globe" style="font-size:9px;margin-right:4px"></i>{{ $lp['host'] ?? '' }}</div>
                                        @if(!empty($lp['title']))<div class="lp-title">{{ $lp['title'] }}</div>@endif
                                        @if(!empty($lp['description']))<div class="lp-desc">{{ $lp['description'] }}</div>@endif
                                    </div>
                                </a>
                            @endif

                            {{-- Timestamp + read tick — JS converts to local tz --}}
                            <div class="bubble-meta {{ $isUnread ? 'bubble-meta--unread' : '' }}">
                                @if(!$isMe)<span>Support Team</span> · @endif

                                {{-- data-utc-time → JS converts to viewer's local timezone --}}
                                <time data-utc-time="{{ $msg['created_at'] }}"
                                      title="UTC: {{ $dt->format('Y-m-d H:i') }}">
                                    {{ $timeLabel }}
                                </time>

                                @if($isMe)
                                    <i class="fas fa-check-double read-tick"
                                       style="{{ $msg['read_at'] ? 'color:var(--orange)' : 'color:var(--muted)' }}"></i>
                                @endif
                                @if($isUnread)
                                    <span class="unread-dot-badge"></span>
                                @endif
                            </div>

                        </div>
                    </div>
                @endforeach
            @endif

            <div wire:loading.delay wire:target="poll" class="poll-indicator">
                <span></span><span></span><span></span>
            </div>

        </div>

        {{-- ── Input footer ── --}}
        <div class="chat-footer">

            @if(session('success'))
                <div class="flash-success">
                    <i class="fas fa-check-circle" style="font-size:11px"></i>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Quick reply chips --}}
            <div class="quick-replies">
                <span class="qr-label"><i class="fas fa-bolt" style="font-size:9px"></i> Quick replies</span>
                @foreach($quickReplies as $i => $qr)
                    <button type="button" class="qr-chip" wire:click="useQuickReply({{ $i }})" title="{{ $qr['text'] }}">
                        <i class="fas {{ $qr['icon'] }}"></i>
                        {{ $qr['label'] }}
                    </button>
                @endforeach
            </div>

            {{-- Attachment preview --}}
            <div x-show="attachPreview || attachName" x-cloak class="attach-preview-bar">
                <template x-if="attachPreview">
                    <div class="attach-img-preview">
                        <img :src="attachPreview" alt="Preview" class="preview-thumb">
                        <div class="preview-info">
                            <span x-text="attachName" class="preview-name"></span>
                            <span class="preview-hint">Will be sent as WebP</span>
                        </div>
                        <button type="button" @click="removeAttach()" class="remove-attach-btn" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </template>
                <template x-if="!attachPreview && attachName">
                    <div class="attach-file-preview">
                        <i class="fas fa-file" style="color:var(--orange)"></i>
                        <span x-text="attachName"></span>
                        <button type="button" @click="removeAttach()" class="remove-attach-btn" title="Remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </template>
            </div>

            {{-- Message form --}}
            <div class="chat-form">
                <textarea
                    wire:model="newMessage"
                    id="msg-input"
                    placeholder="Write your message to support…"
                    rows="1"
                    x-on:input="autoResize($el)"
                    x-on:keydown="handleEnter($event)"
                ></textarea>
                <div class="chat-form-actions">
                    <span class="char-count" x-text="($wire.newMessage || '').length"></span>
                    <label class="attach-btn" title="Attach image or file">
                        <i class="fas fa-paperclip"></i>
                        <input type="file" id="file-attach" style="display:none"
                            wire:model="attachment"
                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.webp"
                            x-on:change="handleFileChange($event)">
                    </label>
                    <button class="send-btn" type="button" wire:click="sendMessage"
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

            <p class="footer-hint">
                <i class="fas fa-lock" style="font-size:9px;margin-right:3px"></i>
                Private & secure ·
                <kbd>Enter</kbd> to send · <kbd>Shift+Enter</kbd> for new line ·
                <i class="fas fa-clock" style="font-size:9px;margin-right:2px;color:var(--orange)"></i>
                <span id="chat-tz-footer">local time</span>
            </p>
        </div>

    </div>

<style>
.chat-livewire-wrap { width: 100%; }
.chat-panel {
    background: #fff; border-radius: 20px; border: 1px solid var(--border);
    box-shadow: var(--card-sh); display: flex; flex-direction: column;
    height: calc(100vh - 200px); min-height: 540px; overflow: hidden;
    animation: scaleUp .35s ease both;
}
.chat-header { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 13px; flex-shrink: 0; background: #fff; }
.chat-header-icon { width: 46px; height: 46px; border-radius: 13px; background: linear-gradient(135deg, var(--brand-lt), #fde9b8); display: flex; align-items: center; justify-content: center; color: var(--brand); font-size: 19px; }
.chat-header-info  { flex: 1; min-width: 0; }
.chat-header-name  { font-size: 15px; font-weight: 800; color: var(--dark); }
.chat-header-sub   { font-size: 12px; color: var(--muted); font-weight: 500; margin-top: 2px; display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
.chat-header-actions { display: flex; gap: 8px; align-items: center; }
.chat-action-btn { width: 36px; height: 36px; border-radius: 10px; background: #f8f7f4; border: 1px solid var(--border); color: var(--muted); cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 13px; transition: all .18s; font-family: inherit; }
.chat-action-btn:hover { background: var(--brand-lt); color: var(--brand); border-color: var(--brand); }
.unread-chip { background: var(--orange); color: #fff; border-radius: 999px; font-size: 10px; font-weight: 900; padding: 3px 9px; animation: fadeIn .3s ease; }

/* Timezone badge */
.chat-tz-badge {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 10px; font-weight: 700; color: #9ca3af;
    background: #f5f2ed; border-radius: 6px; padding: 2px 6px;
    border: 1px solid var(--border);
}

.chat-body { flex: 1; overflow-y: auto; padding: 20px; display: flex; flex-direction: column; gap: 14px; scrollbar-width: thin; scrollbar-color: #e8e4de transparent; }
.chat-body::-webkit-scrollbar { width: 4px; }
.chat-body::-webkit-scrollbar-thumb { background: #e8e4de; border-radius: 4px; }
.date-divider { display: flex; align-items: center; gap: 12px; margin: 4px 0; }
.date-divider::before,.date-divider::after { content:''; flex:1; height:1px; background:var(--border); }
.date-divider span { font-size: 11px; font-weight: 700; color: var(--muted); background: #fff; padding: 3px 10px; border-radius: 999px; border: 1px solid var(--border); white-space: nowrap; }
.unread-banner { display: flex; align-items: center; gap: 8px; background: #fff9ed; border: 1px solid #fde68a; border-radius: 10px; padding: 7px 13px; font-size: 12px; font-weight: 700; color: #92400e; }
.msg-row { display: flex; gap: 10px; align-items: flex-end; }
.msg-row.me { flex-direction: row-reverse; }
.msg-row-icon { width: 32px; height: 32px; border-radius: 10px; flex-shrink: 0; background: linear-gradient(135deg, #fde68a, #f97316); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 11px; font-weight: 900; transition: box-shadow .2s; }
.msg-row-icon.me-icon { background: linear-gradient(135deg, var(--orange), #d46a00); }
.msg-row-icon--unread { box-shadow: 0 0 0 2px var(--orange), 0 0 10px rgba(249,115,22,.35); animation: iconPulse 2s ease-in-out infinite; }
.bubble-wrap { display: flex; flex-direction: column; gap: 4px; max-width: 68%; }
.msg-row.me .bubble-wrap { align-items: flex-end; }
.bubble { padding: 11px 14px; border-radius: 16px; font-size: 13.5px; line-height: 1.65; font-weight: 500; word-break: break-word; }
.bubble.them { background: #f5f2ed; color: var(--dark); border-bottom-left-radius: 4px; }
.bubble.me   { background: linear-gradient(135deg, var(--orange), #d97000); color: #fff; border-bottom-right-radius: 4px; box-shadow: 0 4px 16px rgba(239,125,0,.28); }
.bubble--unread { font-weight: 700 !important; background: #fff8ed !important; border-left: 3px solid var(--orange); box-shadow: 0 2px 12px rgba(249,115,22,.13); color: #1a1a1a !important; }
.bubble-img-wrap { padding: 6px; overflow: hidden; }
.img-link { display: block; position: relative; border-radius: 11px; overflow: hidden; line-height: 0; }
.chat-img { width: 100%; max-width: 280px; height: auto; border-radius: 11px; display: block; object-fit: cover; max-height: 320px; transition: transform .25s ease; }
.img-link:hover .chat-img { transform: scale(1.02); }
.img-overlay { position: absolute; inset: 0; background: rgba(0,0,0,.32); display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity .2s; border-radius: 11px; color: #fff; font-size: 18px; }
.img-link:hover .img-overlay { opacity: 1; }
.img-caption { font-size: 13px; line-height: 1.5; margin-top: 7px; font-weight: 500; padding: 0 4px; }
.bubble-attachment { display: flex; align-items: center; gap: 9px; text-decoration: none; background: rgba(255,255,255,.18); border-radius: 10px; padding: 8px 10px; border: 1px solid rgba(255,255,255,.25); transition: opacity .18s; }
.bubble-attachment.them-att { background: rgba(0,0,0,.04); border: 1px solid var(--border); }
.bubble-attachment:hover { opacity: .82; }
.att-info { flex: 1; min-width: 0; }
.att-name { font-size: 12px; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.att-size { font-size: 10px; opacity: .7; }
.att-dl   { font-size: 11px; opacity: .7; }
.link-preview { display: flex; flex-direction: column; text-decoration: none; border-radius: 13px; overflow: hidden; border: 1.5px solid var(--border); max-width: 300px; transition: box-shadow .2s, transform .2s; background: #fff; }
.link-preview:hover { box-shadow: 0 6px 20px rgba(0,0,0,.1); transform: translateY(-2px); }
.lp-me   { border-color: rgba(255,255,255,.35); background: rgba(255,255,255,.15); }
.lp-img  { width: 100%; height: 140px; object-fit: cover; display: block; }
.lp-body { padding: 10px 12px; display: flex; flex-direction: column; gap: 3px; }
.lp-host { font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: .06em; color: var(--orange); }
.lp-me .lp-host { color: rgba(255,255,255,.75); }
.lp-title { font-size: 13px; font-weight: 700; color: var(--dark); line-height: 1.35; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.lp-me .lp-title { color: #fff; }
.lp-desc  { font-size: 11px; color: var(--muted); line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.bubble-meta { font-size: 10px; color: var(--muted); font-weight: 600; display: flex; align-items: center; gap: 5px; }
.msg-row.me .bubble-meta { justify-content: flex-end; }
.bubble-meta--unread { font-weight: 700; color: var(--orange) !important; }
.bubble-meta time { cursor: default; }
.read-tick { color: var(--orange); }
.unread-dot-badge { display: inline-block; width: 7px; height: 7px; background: var(--orange); border-radius: 50%; animation: iconPulse 1.8s ease-in-out infinite; flex-shrink: 0; }
.chat-empty { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 14px; color: var(--muted); padding: 48px; text-align: center; margin: auto; }
.chat-empty-icon { width: 72px; height: 72px; border-radius: 20px; background: var(--brand-lt); display: flex; align-items: center; justify-content: center; font-size: 28px; color: var(--brand); animation: scaleUp .5s ease both; }
.chat-empty h3 { font-family: 'Lora', serif; font-size: 20px; color: var(--dark); }
.chat-empty p  { font-size: 13px; max-width: 280px; line-height: 1.65; }
.poll-indicator { display: flex; gap: 4px; align-items: center; justify-content: center; padding: 4px 0; opacity: .3; }
.poll-indicator span { width: 5px; height: 5px; background: var(--muted); border-radius: 50%; animation: typingBounce 1.2s ease-in-out infinite; }
.poll-indicator span:nth-child(2) { animation-delay: .2s; }
.poll-indicator span:nth-child(3) { animation-delay: .4s; }
.chat-footer { padding: 12px 16px 14px; border-top: 1px solid var(--border); flex-shrink: 0; background: #fff; }
.quick-replies { display: flex; align-items: center; flex-wrap: wrap; gap: 6px; margin-bottom: 10px; }
.qr-label { font-size: 10px; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: .06em; flex-shrink: 0; margin-right: 2px; }
.qr-chip { display: inline-flex; align-items: center; gap: 5px; padding: 5px 11px; border-radius: 999px; background: #f5f2ed; border: 1.5px solid var(--border); font-size: 11.5px; font-weight: 700; color: #5a4e43; cursor: pointer; font-family: inherit; transition: all .18s; white-space: nowrap; }
.qr-chip i { font-size: 10px; color: var(--orange); }
.qr-chip:hover { background: var(--brand-lt); border-color: var(--orange); color: var(--dark); transform: translateY(-1px); box-shadow: 0 3px 10px rgba(239,125,0,.15); }
.attach-preview-bar { margin-bottom: 8px; }
.attach-img-preview { display: flex; align-items: center; gap: 10px; background: #f5f2ed; border-radius: 12px; padding: 8px 10px; border: 1.5px solid var(--border); }
.preview-thumb { width: 52px; height: 52px; border-radius: 8px; object-fit: cover; flex-shrink: 0; border: 1.5px solid var(--border); }
.preview-info { flex: 1; min-width: 0; }
.preview-name { font-size: 12px; font-weight: 700; color: var(--dark); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; }
.preview-hint { font-size: 10px; color: var(--orange); font-weight: 600; display: block; margin-top: 2px; }
.attach-file-preview { display: inline-flex; align-items: center; gap: 8px; background: #f5f2ed; border-radius: 9px; padding: 6px 10px; font-size: 12px; font-weight: 700; color: var(--dark); border: 1.5px solid var(--border); }
.remove-attach-btn { background: none; border: none; cursor: pointer; color: var(--muted); font-size: 13px; padding: 0 2px; line-height: 1; transition: color .15s; margin-left: auto; flex-shrink: 0; }
.remove-attach-btn:hover { color: #dc2626; }
.chat-form { display: flex; align-items: flex-end; gap: 10px; background: #f8f7f4; border-radius: 14px; border: 1.5px solid var(--border); padding: 10px 12px; transition: border-color .18s, background .18s; }
.chat-form:focus-within { border-color: var(--orange); background: #fff; }
.chat-form textarea { flex: 1; background: none; border: none; outline: none; resize: none; font-family: inherit; font-size: 13.5px; color: var(--dark); font-weight: 500; line-height: 1.6; max-height: 120px; min-height: 22px; }
.chat-form textarea::placeholder { color: #c4b7a8; }
.chat-form-actions { display: flex; gap: 6px; align-items: center; }
.char-count { font-size: 10px; color: var(--muted); font-weight: 600; padding-bottom: 2px; }
.attach-btn { width: 34px; height: 34px; border-radius: 9px; background: none; border: 1.5px solid var(--border); color: var(--muted); cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 13px; transition: all .18s; }
.attach-btn:hover { border-color: var(--orange); color: var(--orange); background: var(--brand-lt); }
.send-btn { width: 38px; height: 38px; border-radius: 10px; background: var(--orange); color: #fff; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 14px; transition: all .2s; box-shadow: 0 4px 12px rgba(239,125,0,.3); }
.send-btn:hover  { background: #d97000; transform: scale(1.06); }
.send-btn:active { transform: scale(.96); }
.send-btn:disabled { opacity: .6; cursor: not-allowed; transform: none; }
.flash-success { display: flex; align-items: center; gap: 6px; background: #f0fdf4; border: 1px solid #86efac; border-radius: 9px; padding: 7px 12px; font-size: 12px; font-weight: 700; color: #166534; margin-bottom: 10px; animation: fadeIn .3s ease; }
.footer-hint { font-size: 10px; color: var(--muted); margin-top: 8px; font-weight: 600; padding: 0 2px; }
.footer-hint kbd { background: #f0ece7; border-radius: 4px; padding: 1px 5px; font-size: 9px; font-family: monospace; border: 1px solid var(--border); }

@keyframes scaleUp      { from{opacity:0;transform:scale(.95)} to{opacity:1;transform:scale(1)} }
@keyframes fadeIn       { from{opacity:0} to{opacity:1} }
@keyframes typingBounce { 0%,60%,100%{transform:translateY(0);opacity:.4} 30%{transform:translateY(-5px);opacity:1} }
@keyframes iconPulse    { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.6;transform:scale(.92)} }

@media (max-width:640px) {
    .chat-panel    { height: calc(100vh - 160px); border-radius: 16px; }
    .chat-body     { padding: 14px; }
    .bubble-wrap   { max-width: 85%; }
    .chat-img      { max-width: 220px; }
    .quick-replies { gap: 5px; }
    .qr-chip       { font-size: 11px; padding: 4px 9px; }
    .qr-label      { display: none; }
}
</style>

<script>
/**
 * _chatConvertTimes()
 * Converts all [data-utc-time] and [data-utc-date] elements to the
 * viewer's browser timezone using the Intl API.
 */
function _chatConvertTimes() {
    const tz = Intl.DateTimeFormat().resolvedOptions().timeZone;
    const now = new Date();

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
            el.textContent = d.toLocaleTimeString([], {
                hour: '2-digit', minute: '2-digit', timeZone: tz,
            });
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
            const d  = new Date(el.dataset.utcDate);
            const ds = localDateStr(d);
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

    // ── Update timezone label in header + footer ─────────────
    const shortTz = tz.split('/').pop().replace(/_/g, ' ');
    const tz1 = document.getElementById('chat-tz-name');
    const tz2 = document.getElementById('chat-tz-footer');
    if (tz1) tz1.textContent = shortTz;
    if (tz2) tz2.textContent = shortTz;
}

// Re-run after every Livewire update (covers poll re-renders automatically)
document.addEventListener('livewire:update', () => {
    requestAnimationFrame(() => _chatConvertTimes());
});
</script>

</div>{{-- /root --}}