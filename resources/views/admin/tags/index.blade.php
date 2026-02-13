{{-- resources/views/admin/tags/index.blade.php --}}
@extends('admin.layouts.app')
@section('title', 'Tags')
@section('content')

<!-- Header -->
<div class="page-header flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="page-title">Tags</h1>
        <p class="page-subtitle">Manage article tags and their display styles</p>
    </div>
    <button onclick="openModal()" class="action-btn">
        <i class="fas fa-plus"></i><span>New Tag</span>
    </button>
</div>

{{-- ════ STATS STRIP ════ --}}
<div class="rounded-2xl mb-6 overflow-hidden"
     style="background:linear-gradient(135deg,#1f2937 0%,#111827 100%);">
    <div class="px-6 py-8">
        <p class="text-xs font-bold text-orange-400 uppercase tracking-widest mb-4">
            <i class="fas fa-tags mr-2"></i>Tags Overview
        </p>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            @php
                $totalTags  = $tags->total() ?? count($tags);
                $activeTags = \App\Models\Tag::active()->count();
                $styles     = \App\Models\Tag::active()->select('style')->distinct()->count();
                $taggedArts = \App\Models\Article::has('tags')->published()->count();
            @endphp
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-black text-white mb-1 counter-admin" data-target="{{ $totalTags }}">{{ $totalTags }}</div>
                <p class="text-xs text-gray-400 font-medium">Total Tags</p>
            </div>
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-black text-green-400 mb-1 counter-admin" data-target="{{ $activeTags }}">{{ $activeTags }}</div>
                <p class="text-xs text-gray-400 font-medium">Active</p>
            </div>
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-black text-orange-400 mb-1 counter-admin" data-target="{{ $styles }}">{{ $styles }}</div>
                <p class="text-xs text-gray-400 font-medium">Styles Used</p>
            </div>
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-black text-blue-400 mb-1 counter-admin" data-target="{{ $taggedArts }}">{{ $taggedArts }}</div>
                <p class="text-xs text-gray-400 font-medium">Tagged Articles</p>
            </div>
        </div>
    </div>
</div>

{{-- ════ INTERACTIVE STYLE PICKER ════ --}}
<div class="card mb-6" id="style-picker-section">

    {{-- Header row --}}
    <div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-5">
        <div class="flex-1">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-palette text-orange-500"></i> Tag Style Picker
                <span class="ml-2 inline-flex items-center gap-1 text-[10px] bg-green-100 text-green-600 font-bold px-2 py-0.5 rounded-full uppercase tracking-wide">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse inline-block"></span> Live
                </span>
            </h3>
            <p class="text-xs text-gray-400 mt-0.5">Pick a color below, then click any style card to create a tag with that design</p>
        </div>
        {{-- Global color picker for the picker section --}}
        <div class="flex items-center gap-2 bg-gray-50 rounded-xl px-3 py-2 border border-gray-100">
            <span class="text-xs font-semibold text-gray-500">Preview color:</span>
            <input type="color" id="picker-color" value="#f97316"
                   class="w-8 h-8 rounded-lg border border-gray-200 cursor-pointer p-0.5"
                   oninput="pickerColorChange(this.value)">
            <input type="text" id="picker-color-hex" value="#f97316"
                   class="w-20 text-xs font-mono px-2 py-1.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-orange-400 text-center"
                   oninput="pickerHexInput(this.value)">
            {{-- Preset swatches --}}
            <div class="flex gap-1.5 ml-1">
                @foreach([
                    '#f97316','#3b82f6','#22c55e',
                    '#a855f7','#ec4899','#ef4444','#14b8a6','#eab308'
                ] as $pc)
                <button type="button"
                        class="picker-swatch w-5 h-5 rounded-full border-2 border-white shadow-sm hover:scale-125 transition-transform focus:outline-none"
                        style="background:{{ $pc }}"
                        data-color="{{ $pc }}"
                        onclick="pickerColorChange('{{ $pc }}')"></button>
                @endforeach
            </div>
        </div>
    </div>

    {{-- 5 style cards — clicking opens modal pre-filled --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
        @foreach([
            ['key'=>'pill',    'label'=>'Pill',    'desc'=>'Tinted bg + border', 'default'=>true],
            ['key'=>'solid',   'label'=>'Solid',   'desc'=>'Filled, white text',  'default'=>false],
            ['key'=>'outline', 'label'=>'Outline', 'desc'=>'Border only',          'default'=>false],
            ['key'=>'soft',    'label'=>'Soft',    'desc'=>'Subtle tinted fill',   'default'=>false],
            ['key'=>'minimal', 'label'=>'Minimal', 'desc'=>'Underline only',       'default'=>false],
        ] as $s)
        <div class="picker-card relative group rounded-2xl border-2 border-gray-100 bg-gray-50 p-4
                    hover:border-orange-400 hover:bg-orange-50 hover:shadow-lg
                    transition-all duration-200 cursor-pointer overflow-hidden"
             data-style="{{ $s['key'] }}"
             onclick="pickerSelectAndOpen('{{ $s['key'] }}')">

            {{-- Shine effect on hover --}}
            <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                 style="background:linear-gradient(135deg,rgba(255,255,255,0.4) 0%,transparent 60%)"></div>

            {{-- Default badge --}}
            @if($s['default'])
            <span class="absolute top-2 right-2 text-[9px] font-black bg-orange-500 text-white px-1.5 py-0.5 rounded-full uppercase tracking-wide">
                Default
            </span>
            @endif

            {{-- Live preview badge (large) --}}
            <div class="h-12 flex items-center justify-center mb-3">
                <span class="picker-badge-{{ $s['key'] }} text-xs font-bold transition-all duration-200"
                      id="pgbadge-{{ $s['key'] }}"
                      @if($s['key']==='pill')
                          style="padding:4px 12px;border-radius:999px;background:#f9731622;color:#f97316;border:1px solid #f9731655;"
                      @elseif($s['key']==='solid')
                          style="padding:4px 12px;border-radius:5px;background:#f97316;color:#fff;"
                      @elseif($s['key']==='outline')
                          style="padding:4px 12px;border-radius:999px;border:2px solid #f97316;color:#f97316;background:transparent;"
                      @elseif($s['key']==='soft')
                          style="padding:4px 12px;border-radius:8px;background:#f9731622;color:#f97316;"
                      @else
                          style="color:#f97316;text-decoration:underline;text-underline-offset:3px;"
                      @endif>
                    Education
                </span>
            </div>

            {{-- Label --}}
            <div class="relative z-10">
                <p class="text-xs font-black text-gray-700 uppercase tracking-wide leading-none">{{ $s['label'] }}</p>
                <p class="text-[10px] text-gray-400 mt-1 leading-tight">{{ $s['desc'] }}</p>
            </div>

            {{-- Click hint --}}
            <div class="absolute bottom-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                <span class="text-[9px] text-orange-500 font-bold flex items-center gap-0.5">
                    Create <i class="fas fa-arrow-right text-[8px]"></i>
                </span>
            </div>
        </div>
        @endforeach
    </div>

    <p class="text-xs text-gray-400 mt-4 flex items-center gap-1.5">
        <i class="fas fa-lightbulb text-yellow-400"></i>
        Change the color above to preview all 5 styles with your color, then click a card to create a tag instantly.
    </p>
</div>

{{-- ════ TAGS TABLE ════ --}}
<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tag</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Preview</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden md:table-cell">Style</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider hidden lg:table-cell">Articles</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($tags as $tag)
                    <tr class="hover:bg-gray-50 transition">
                        <!-- Tag name + color swatch -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-5 h-5 rounded-full border-2 border-white shadow flex-shrink-0"
                                     style="background-color:{{ $tag->color }}"></div>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $tag->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $tag->slug }}</p>
                                </div>
                            </div>
                        </td>
                        <!-- Live preview of the badge -->
                        <td class="px-6 py-4">
                            <span class="{{ $tag->badge_classes }}" style="{{ $tag->badge_style }}">
                                {{ $tag->name }}
                            </span>
                        </td>
                        <!-- Style -->
                        <td class="px-6 py-4 hidden md:table-cell">
                            <span class="px-2.5 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-medium capitalize">
                                {{ $tag->style }}
                            </span>
                        </td>
                        <!-- Article count -->
                        <td class="px-6 py-4 hidden lg:table-cell">
                            <span class="text-sm font-medium text-gray-700">
                                {{ $tag->articles_count ?? $tag->articles()->count() }}
                            </span>
                        </td>
                        <!-- Status -->
                        <td class="px-6 py-4">
                            @if($tag->is_active)
                                <span class="px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Active</span>
                            @else
                                <span class="px-2.5 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-semibold">Inactive</span>
                            @endif
                        </td>
                        <!-- Actions -->
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-1">
                                <button onclick="editTag({{ $tag->id }}, '{{ $tag->name }}', '{{ $tag->color }}', '{{ $tag->style }}', {{ $tag->is_active ? 'true' : 'false' }})"
                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                    <i class="fas fa-edit text-sm"></i>
                                </button>
                                <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST"
                                      class="inline" onsubmit="return confirm('Delete tag \'{{ $tag->name }}\'?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Delete">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-tags text-gray-300 text-3xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">No tags yet</h3>
                            <p class="text-gray-500 mb-6">Create your first tag to start organising articles.</p>
                            <button onclick="openModal()" class="action-btn"><i class="fas fa-plus"></i><span>New Tag</span></button>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(isset($tags) && method_exists($tags,'hasPages') && $tags->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">{{ $tags->links() }}</div>
    @endif
</div>

{{-- ════════════════════════════════════════════════════════
     CREATE / EDIT MODAL
════════════════════════════════════════════════════════ --}}
<div id="tag-modal" class="fixed inset-0 bg-black/50 z-50 hidden items-start justify-center pt-20 px-4"
     onclick="if(event.target===this) closeModal()">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
        <!-- Modal header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-100">
            <h3 id="modal-title" class="text-lg font-bold text-gray-900">New Tag</h3>
            <button onclick="closeModal()" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 transition">
                <i class="fas fa-times text-gray-500"></i>
            </button>
        </div>

        <!-- Form -->
        <form id="tag-form" action="{{ route('admin.tags.store') }}" method="POST" class="p-6 space-y-5">
            @csrf
            <input type="hidden" id="modal-method" name="_method" value="">
            <input type="hidden" id="modal-tag-id" name="tag_id" value="">

            <!-- Name -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tag Name <span class="text-red-500">*</span></label>
                <input type="text" id="modal-name" name="name" required placeholder="e.g. Education"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition">
            </div>

            <!-- Color -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Color</label>
                <div class="flex items-center gap-3">
                    <input type="color" id="modal-color" name="color" value="#f97316"
                           class="w-10 h-10 rounded-lg border border-gray-300 cursor-pointer p-0.5"
                           oninput="updatePreview()">
                    <input type="text" id="modal-color-text" value="#f97316"
                           class="flex-1 px-3 py-2.5 border border-gray-300 rounded-lg text-sm font-mono focus:ring-2 focus:ring-orange-500 outline-none"
                           oninput="syncColor(this.value)" placeholder="#f97316">
                    <!-- Quick presets -->
                    <div class="flex gap-1.5">
                        @foreach(['#f97316','#3b82f6','#22c55e','#a855f7','#ec4899','#ef4444','#14b8a6'] as $pc)
                        <div class="w-6 h-6 rounded-full cursor-pointer border-2 border-white shadow-sm hover:scale-110 transition-transform"
                             style="background:{{ $pc }}"
                             onclick="quickColor('{{ $pc }}')"></div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Style — visual card picker -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Style <span class="text-xs text-gray-400 font-normal">(click to pick)</span>
                </label>
                {{-- Hidden real input that gets submitted --}}
                <input type="hidden" id="modal-style" name="style" value="pill">
                <div class="grid grid-cols-5 gap-2" id="style-picker-cards">
                    @foreach([
                        ['key'=>'pill',    'label'=>'Pill',    'desc'=>'Tinted'],
                        ['key'=>'solid',   'label'=>'Solid',   'desc'=>'Filled'],
                        ['key'=>'outline', 'label'=>'Outline', 'desc'=>'Border'],
                        ['key'=>'soft',    'label'=>'Soft',    'desc'=>'Subtle'],
                        ['key'=>'minimal', 'label'=>'Minimal', 'desc'=>'Line'],
                    ] as $s)
                    <div class="modal-style-card border-2 rounded-xl p-2.5 text-center cursor-pointer transition-all duration-150 hover:scale-105
                                {{ $s['key']==='pill' ? 'border-orange-500 bg-orange-50' : 'border-gray-200 bg-gray-50' }}"
                         data-style="{{ $s['key'] }}"
                         id="mscard-{{ $s['key'] }}"
                         onclick="pickModalStyle('{{ $s['key'] }}')">
                        <div class="h-7 flex items-center justify-center mb-1.5">
                            <span id="mspreview-{{ $s['key'] }}" class="text-[10px] font-bold"
                                  @if($s['key']==='pill') style="padding:2px 7px;border-radius:999px;background:#f9731622;color:#f97316;border:1px solid #f9731655;"
                                  @elseif($s['key']==='solid') style="padding:2px 7px;border-radius:4px;background:#f97316;color:#fff;"
                                  @elseif($s['key']==='outline') style="padding:2px 7px;border-radius:999px;border:2px solid #f97316;color:#f97316;"
                                  @elseif($s['key']==='soft') style="padding:2px 7px;border-radius:6px;background:#f9731622;color:#f97316;"
                                  @else style="color:#f97316;text-decoration:underline;text-underline-offset:2px;"
                                  @endif>Aa</span>
                        </div>
                        <p class="text-[9px] font-black text-gray-600 uppercase tracking-wide leading-none">{{ $s['label'] }}</p>
                        <p class="text-[8px] text-gray-400 mt-0.5">{{ $s['desc'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Live Preview -->
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Live Preview</p>
                <div class="flex flex-wrap gap-2 items-center">
                    <div id="preview-badge" class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold"
                         style="background-color:#f9731622;color:#f97316;border:1px solid #f9731655;">
                        Tag Name
                    </div>
                    <p class="text-xs text-gray-400">← updates as you type</p>
                </div>
            </div>

            <!-- Active toggle -->
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-700">Active</p>
                    <p class="text-xs text-gray-400">Show this tag on articles</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="modal-active" name="is_active" value="1" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-500"></div>
                </label>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeModal()"
                        class="flex-1 px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium text-sm">
                    Cancel
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-2.5 bg-orange-500 hover:bg-orange-600 text-white rounded-lg transition font-semibold text-sm">
                    <i class="fas fa-save mr-1"></i><span id="modal-submit-label">Create Tag</span>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// ── Visual style card picker ───────────────────────────────────────────────
function pickModalStyle(style) {
    document.getElementById('modal-style').value = style;
    document.querySelectorAll('.modal-style-card').forEach(el => {
        const active = el.dataset.style === style;
        el.classList.toggle('border-orange-500', active);
        el.classList.toggle('bg-orange-50', active);
        el.classList.toggle('border-gray-200', !active);
        el.classList.toggle('bg-gray-50', !active);
    });
    updatePreview();
}
function quickColor(hex) {
    document.getElementById('modal-color').value = hex;
    document.getElementById('modal-color-text').value = hex;
    updatePreview();
}
// Update style-card previews when color changes
function updateStyleCardPreviews(color) {
    const styles = {
        'pill':    `padding:2px 7px;border-radius:999px;background:${color}22;color:${color};border:1px solid ${color}55;`,
        'solid':   `padding:2px 7px;border-radius:4px;background:${color};color:#fff;`,
        'outline': `padding:2px 7px;border-radius:999px;border:2px solid ${color};color:${color};`,
        'soft':    `padding:2px 7px;border-radius:6px;background:${color}22;color:${color};`,
        'minimal': `color:${color};text-decoration:underline;text-underline-offset:2px;`,
    };
    Object.keys(styles).forEach(s => {
        const el = document.getElementById('mspreview-' + s);
        if (el) el.style.cssText = styles[s];
    });
}

// ── PAGE-LEVEL style picker (above table) ─────────────────────────────────
function updatePickerBadges(color) {
    const map = {
        'pill':    `padding:4px 12px;border-radius:999px;background:${color}22;color:${color};border:1px solid ${color}55;`,
        'solid':   `padding:4px 12px;border-radius:5px;background:${color};color:#fff;`,
        'outline': `padding:4px 12px;border-radius:999px;border:2px solid ${color};color:${color};background:transparent;`,
        'soft':    `padding:4px 12px;border-radius:8px;background:${color}22;color:${color};`,
        'minimal': `color:${color};text-decoration:underline;text-underline-offset:3px;`,
    };
    Object.keys(map).forEach(s => {
        const el = document.getElementById('pgbadge-' + s);
        if (el) el.style.cssText = map[s];
    });
    // highlight active swatch
    document.querySelectorAll('.picker-swatch').forEach(sw => {
        const isActive = sw.dataset.color === color;
        sw.style.boxShadow = isActive ? `0 0 0 2px white, 0 0 0 4px ${color}` : '';
    });
}

function pickerColorChange(hex) {
    if (!/^#[0-9a-fA-F]{3,6}$/.test(hex)) return;
    document.getElementById('picker-color').value = hex;
    document.getElementById('picker-color-hex').value = hex;
    updatePickerBadges(hex);
}

function pickerHexInput(val) {
    if (/^#[0-9a-fA-F]{6}$/.test(val)) pickerColorChange(val);
}

// Click picker card → pre-fill modal with this style + current picker color, then open
function pickerSelectAndOpen(style) {
    const color = document.getElementById('picker-color').value || '#f97316';
    // pre-fill modal
    document.getElementById('modal-color').value = color;
    document.getElementById('modal-color-text').value = color;
    pickModalStyle(style);
    // reset other modal fields for a clean create
    document.getElementById('tag-form').action = '{{ route("admin.tags.store") }}';
    document.getElementById('modal-method').value = '';
    document.getElementById('modal-tag-id').value = '';
    document.getElementById('modal-title').textContent = 'New Tag';
    document.getElementById('modal-submit-label').textContent = 'Create Tag';
    document.getElementById('modal-name').value = '';
    document.getElementById('modal-active').checked = true;
    updatePreview();
    updateStyleCardPreviews(color);
    openModal();
    // focus name field
    setTimeout(() => document.getElementById('modal-name').focus(), 100);
}

// Sync picker color input → update badges in real time
document.getElementById('picker-color').addEventListener('input', function(){
    document.getElementById('picker-color-hex').value = this.value;
    updatePickerBadges(this.value);
});

function openModal(){ document.getElementById('tag-modal').classList.replace('hidden','flex'); }
function closeModal(){ document.getElementById('tag-modal').classList.replace('flex','hidden'); resetModal(); }
function resetModal(){
    document.getElementById('tag-form').action='{{ route("admin.tags.store") }}';
    document.getElementById('modal-method').value='';
    document.getElementById('modal-tag-id').value='';
    document.getElementById('modal-title').textContent='New Tag';
    document.getElementById('modal-submit-label').textContent='Create Tag';
    document.getElementById('modal-name').value='';
    document.getElementById('modal-color').value='#f97316';
    document.getElementById('modal-color-text').value='#f97316';
    pickModalStyle('pill');
    document.getElementById('modal-active').checked=true;
    updatePreview();
}
function editTag(id, name, color, style, active){
    document.getElementById('tag-form').action=`/admin/tags/${id}`;
    document.getElementById('modal-method').value='PUT';
    document.getElementById('modal-tag-id').value=id;
    document.getElementById('modal-title').textContent='Edit Tag';
    document.getElementById('modal-submit-label').textContent='Save Changes';
    document.getElementById('modal-name').value=name;
    document.getElementById('modal-color').value=color;
    document.getElementById('modal-color-text').value=color;
    pickModalStyle(style);
    document.getElementById('modal-active').checked=active;
    updatePreview();
    openModal();
}

// ── Live preview ───────────────────────────────────────────────────────────
function updatePreview(){
    const color = document.getElementById('modal-color').value || '#f97316';
    const style = document.getElementById('modal-style').value;
    const name  = document.getElementById('modal-name').value || 'Tag Name';
    const el    = document.getElementById('preview-badge');

    el.textContent = name;
    // reset classes
    el.className = 'inline-flex items-center gap-1';
    el.removeAttribute('style');

    if(style==='pill'){
        el.className += ' px-3 py-1 rounded-full text-xs font-bold';
        el.style.cssText = `background-color:${color}22;color:${color};border:1px solid ${color}55;`;
    } else if(style==='solid'){
        el.className += ' px-2.5 py-0.5 rounded text-xs font-bold text-white';
        el.style.backgroundColor = color;
    } else if(style==='outline'){
        el.className += ' px-2.5 py-0.5 rounded-full text-xs font-bold border-2 bg-transparent';
        el.style.cssText = `border-color:${color};color:${color};`;
    } else if(style==='soft'){
        el.className += ' px-2.5 py-0.5 rounded-lg text-xs font-semibold';
        el.style.cssText = `background-color:${color}22;color:${color};`;
    } else {
        el.className += ' text-xs font-bold underline underline-offset-2';
        el.style.color = color;
    }
    // also update style card mini-badge previews
    updateStyleCardPreviews(color);
}
function syncColor(hex){
    if(/^#[0-9a-fA-F]{6}$/.test(hex)){
        document.getElementById('modal-color').value=hex;
        updatePreview();
    }
}

// Sync hex text when color picker changes
document.getElementById('modal-color').addEventListener('input', function(){
    document.getElementById('modal-color-text').value = this.value;
    updatePreview();
});
// Preview updates on name input
document.getElementById('modal-name').addEventListener('input', updatePreview);

// ── Counter animation ──────────────────────────────────────────────────────
document.querySelectorAll('.counter-admin').forEach(el => {
    const target = +el.getAttribute('data-target');
    if(!target) return;
    const step = Math.max(1, Math.ceil(target/80));
    let cur=0;
    const obs = new IntersectionObserver(entries => {
        if(!entries[0].isIntersecting) return;
        const tick=()=>{ cur=Math.min(cur+step,target); el.textContent=cur.toLocaleString(); if(cur<target) requestAnimationFrame(tick); };
        tick(); obs.disconnect();
    },{threshold:0.5});
    obs.observe(el);
});
</script>
@endpush
@endsection