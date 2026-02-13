{{-- resources/views/layouts/ads.blade.php --}}

<!-- ========== POPUP MODAL — #1 Most-Viewed Article ========== -->
<div id="popup-modal" class="popup-overlay">
    <div class="popup-container">

        <!-- Close Button -->
        <button id="close-popup" class="popup-close" aria-label="Close">
            <i class="fas fa-times"></i>
        </button>

        @if(!empty($popupArticle))
        {{-- ═══ LEFT — Article image ═══ --}}
        <div class="popup-image-side">
            @if($popupArticle->image)
                <img src="{{ $popupArticle->image->url }}"
                     alt="{{ $popupArticle->title }}"
                     class="popup-image">
            @else
                <div class="popup-image" style="background:linear-gradient(135deg,{{ $popupArticle->category->color ?? '#f97316' }}33,{{ $popupArticle->category->color ?? '#f97316' }}11);display:flex;align-items:center;justify-content:center;">
                    <i class="{{ $popupArticle->category->icon ?? 'fas fa-newspaper' }}" style="font-size:5rem;opacity:.2;color:{{ $popupArticle->category->color ?? '#f97316' }}"></i>
                </div>
            @endif
            <div class="popup-image-overlay">
                <div style="display:flex;flex-direction:column;gap:6px">
                    <span class="popup-badge">
                        <i class="fas fa-fire" style="color:#fde047;margin-right:4px"></i>
                        #1 Most Read
                    </span>
                    <span class="popup-views-badge">
                        <i class="fas fa-eye" style="margin-right:4px;opacity:.8"></i>
                        {{ number_format($popupArticle->views_count) }} views
                    </span>
                </div>
            </div>
        </div>

        {{-- ═══ RIGHT — Content ═══ --}}
        <div class="popup-content-side">

            <!-- Logo -->
            <div class="popup-logo">
                <div class="popup-logo-icon"><i class="fas fa-heart"></i></div>
                <span class="popup-logo-text">Hope &amp; Impact</span>
            </div>

            <!-- Category -->
            @if($popupArticle->category)
            <div style="margin-bottom:8px">
                <span style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:{{ $popupArticle->category->color ?? '#f97316' }}">
                    @if($popupArticle->category->icon)<i class="{{ $popupArticle->category->icon }}" style="margin-right:4px"></i>@endif
                    {{ $popupArticle->category->name }}
                </span>
            </div>
            @endif

            <!-- Article title -->
            <h2 class="popup-title">{{ Str::limit($popupArticle->title, 60) }}</h2>

            <!-- Excerpt -->
            @if($popupArticle->excerpt)
            <p class="popup-description">
                {{ Str::limit(strip_tags($popupArticle->excerpt), 120) }}
            </p>
            @endif

            <!-- Time + views strip -->
            <div class="popup-meta">
                <span><i class="fas fa-clock" style="color:#f97316;margin-right:4px"></i>{{ $popupArticle->published_at?->diffForHumans() ?? 'Recently' }}</span>
                <span style="color:#e5e7eb">·</span>
                <span><i class="fas fa-eye" style="color:#f97316;margin-right:4px"></i>{{ number_format($popupArticle->views_count) }}</span>
            </div>

            <!-- Stats -->
            <div class="popup-stats">
                <div class="popup-stat">
                    <span class="popup-stat-number">95K+</span>
                    <span class="popup-stat-label">Children Helped</span>
                </div>
                <div class="popup-stat-divider"></div>
                <div class="popup-stat">
                    <span class="popup-stat-number">84%</span>
                    <span class="popup-stat-label">To Programs</span>
                </div>
                <div class="popup-stat-divider"></div>
                <div class="popup-stat">
                    <span class="popup-stat-number">7</span>
                    <span class="popup-stat-label">Countries</span>
                </div>
            </div>

            <!-- CTA Buttons -->
            <div class="popup-actions">
                <a href="{{ route('detail') }}" class="popup-btn-primary">
                    <i class="fas fa-heart" style="margin-right:8px"></i>
                    Sponsor a Child Now
                </a>
                <a href="{{ route('articles.show', $popupArticle->encrypted_slug) }}" class="popup-btn-secondary">
                    <i class="fas fa-book-open" style="margin-right:8px"></i>
                    Read This Story
                </a>
            </div>

            <button id="remind-later" class="popup-dismiss">
                Maybe later — remind me next time
            </button>

            <!-- Trust -->
            <div class="popup-trust">
                <span class="popup-trust-item"><i class="fas fa-shield-alt" style="color:#22c55e;margin-right:4px"></i>100% Secure</span>
                <span class="popup-trust-item"><i class="fas fa-certificate" style="color:#3b82f6;margin-right:4px"></i>Certified NGO</span>
                <span class="popup-trust-item"><i class="fas fa-check-circle" style="color:#f97316;margin-right:4px"></i>IDEAS Labeled</span>
            </div>
        </div>

        @else
        {{-- ═══ Fallback — static ═══ --}}
        <div class="popup-image-side">
            <img src="https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=600"
                 alt="Sponsored Child" class="popup-image">
            <div class="popup-image-overlay">
                <span class="popup-badge"><i class="fas fa-heart" style="margin-right:4px"></i>Change a Life Today</span>
            </div>
        </div>
        <div class="popup-content-side">
            <div class="popup-logo">
                <div class="popup-logo-icon"><i class="fas fa-heart"></i></div>
                <span class="popup-logo-text">Hope &amp; Impact</span>
            </div>
            <h2 class="popup-title">Sponsor a Child<br><span class="popup-title-highlight">for just $1/day</span></h2>
            <p class="popup-description">Your small contribution provides a child with education, meals, healthcare, and hope for a brighter future.</p>
            <div class="popup-stats">
                <div class="popup-stat"><span class="popup-stat-number">95K+</span><span class="popup-stat-label">Children Helped</span></div>
                <div class="popup-stat-divider"></div>
                <div class="popup-stat"><span class="popup-stat-number">84%</span><span class="popup-stat-label">To Programs</span></div>
                <div class="popup-stat-divider"></div>
                <div class="popup-stat"><span class="popup-stat-number">7</span><span class="popup-stat-label">Countries</span></div>
            </div>
            <div class="popup-actions">
                <a href="{{ route('detail') }}" class="popup-btn-primary">
                    <i class="fas fa-child" style="margin-right:8px"></i>Sponsor a Child Now
                </a>
            </div>
            <button id="remind-later" class="popup-dismiss">Maybe later — remind me next time</button>
            <div class="popup-trust">
                <span class="popup-trust-item"><i class="fas fa-shield-alt" style="color:#22c55e;margin-right:4px"></i>100% Secure</span>
                <span class="popup-trust-item"><i class="fas fa-certificate" style="color:#3b82f6;margin-right:4px"></i>Certified NGO</span>
                <span class="popup-trust-item"><i class="fas fa-check-circle" style="color:#f97316;margin-right:4px"></i>IDEAS Labeled</span>
            </div>
        </div>
        @endif

    </div>
</div>

<!-- ========== STYLES ========== -->
<style>
.popup-overlay {
    position: fixed; inset: 0;
    background: rgba(0,0,0,.65);
    backdrop-filter: blur(4px);
    z-index: 9999;
    display: flex; align-items: center; justify-content: center;
    padding: 1rem;
    opacity: 0; visibility: hidden;
    transition: opacity .4s ease, visibility .4s ease;
}
.popup-overlay.active { opacity: 1; visibility: visible; }

.popup-container {
    background: #fff;
    border-radius: 1.25rem;
    overflow: hidden;
    max-width: 820px; width: 100%;
    display: flex; position: relative;
    box-shadow: 0 25px 60px rgba(0,0,0,.35);
    transform: scale(.92) translateY(20px);
    transition: transform .4s cubic-bezier(.34,1.56,.64,1);
    max-height: 90vh;
}
.popup-overlay.active .popup-container { transform: scale(1) translateY(0); }

.popup-close {
    position: absolute; top: .875rem; right: .875rem;
    width: 2rem; height: 2rem;
    background: rgba(0,0,0,.25); border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: .875rem;
    cursor: pointer; z-index: 10; border: none;
    transition: background .2s, transform .2s;
}
.popup-close:hover { background: rgba(0,0,0,.5); transform: rotate(90deg); }

/* Left image */
.popup-image-side {
    width: 45%; flex-shrink: 0;
    position: relative; display: none;
}
@media(min-width:640px){ .popup-image-side { display: block; } }

.popup-image {
    width: 100%; height: 100%;
    object-fit: cover; min-height: 480px;
}
.popup-image-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,.65) 0%, transparent 55%);
    display: flex; align-items: flex-end; padding: 1.5rem;
}
.popup-badge {
    display: inline-flex; align-items: center;
    background: #f97316; color: #fff;
    font-size: .8rem; font-weight: 700;
    padding: .45rem 1rem; border-radius: 999px;
    letter-spacing: .02em;
}
.popup-views-badge {
    display: inline-flex; align-items: center;
    background: rgba(0,0,0,.45); color: #fff;
    font-size: .72rem; font-weight: 600;
    padding: .35rem .8rem; border-radius: 999px;
}

/* Right content */
.popup-content-side {
    flex: 1; padding: 1.75rem 1.75rem;
    display: flex; flex-direction: column; justify-content: center;
    overflow-y: auto;
}

.popup-logo { display: flex; align-items: center; gap: .5rem; margin-bottom: 1rem; }
.popup-logo-icon {
    width: 2rem; height: 2rem;
    background: linear-gradient(135deg,#f97316,#ea580c);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: .875rem;
}
.popup-logo-text { font-weight: 800; font-size: 1rem; color: #111827; letter-spacing: -.01em; }

.popup-title {
    font-size: 1.45rem; font-weight: 800;
    color: #111827; line-height: 1.25;
    margin-bottom: .6rem;
}
.popup-title-highlight { color: #f97316; }

.popup-description {
    color: #6b7280; font-size: .875rem;
    line-height: 1.6; margin-bottom: .875rem;
}

.popup-meta {
    display: flex; align-items: center; gap: .5rem;
    font-size: .72rem; color: #9ca3af;
    margin-bottom: 1rem;
}

.popup-stats {
    display: flex; align-items: center; gap: .75rem;
    background: #fff7ed; border: 1px solid #fed7aa;
    border-radius: .75rem; padding: .75rem 1rem;
    margin-bottom: 1rem;
}
.popup-stat { flex: 1; text-align: center; }
.popup-stat-number { display: block; font-size: 1.05rem; font-weight: 800; color: #f97316; line-height: 1.2; }
.popup-stat-label  { display: block; font-size: .68rem; color: #9a3412; font-weight: 500; margin-top: 2px; }
.popup-stat-divider { width: 1px; height: 2rem; background: #fed7aa; flex-shrink: 0; }

.popup-actions { display: flex; flex-direction: column; gap: .6rem; margin-bottom: .75rem; }

.popup-btn-primary {
    display: flex; align-items: center; justify-content: center;
    padding: .8rem 1.5rem;
    background: linear-gradient(135deg,#f97316,#ea580c);
    color: #fff; font-weight: 700; font-size: .92rem;
    border-radius: .625rem; text-decoration: none;
    box-shadow: 0 4px 14px rgba(249,115,22,.35);
    transition: transform .2s, box-shadow .2s;
}
.popup-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(249,115,22,.45); color: #fff; }

.popup-btn-secondary {
    display: flex; align-items: center; justify-content: center;
    padding: .8rem 1.5rem;
    border: 2px solid #e5e7eb; color: #374151;
    font-weight: 600; font-size: .875rem;
    border-radius: .625rem; text-decoration: none;
    transition: border-color .2s, background .2s, color .2s;
}
.popup-btn-secondary:hover { border-color: #f97316; background: #fff7ed; color: #f97316; }

.popup-dismiss {
    background: none; border: none;
    color: #9ca3af; font-size: .75rem;
    cursor: pointer; width: 100%;
    text-align: center; text-decoration: underline;
    margin-bottom: .75rem; padding: 0;
    transition: color .2s;
}
.popup-dismiss:hover { color: #6b7280; }

.popup-trust {
    display: flex; justify-content: center;
    gap: .75rem; flex-wrap: wrap;
    border-top: 1px solid #f3f4f6; padding-top: .75rem;
}
.popup-trust-item { font-size: .68rem; color: #6b7280; font-weight: 500; display: flex; align-items: center; }

@media(max-width:639px){
    .popup-container { max-height: 88vh; }
    .popup-content-side { padding: 1.4rem 1.2rem; }
    .popup-title { font-size: 1.25rem; }
    .popup-stats { gap: .4rem; padding: .65rem .75rem; }
    .popup-stat-number { font-size: .9rem; }
}
</style>

<!-- ========== POPUP SCRIPT ========== -->
<script>
(function () {
    const modal    = document.getElementById('popup-modal');
    const closeBtn = document.getElementById('close-popup');
    const remindBtn= document.getElementById('remind-later');
    if (!modal) return;

    const KEY      = 'popup_closed_at';
    const COOLDOWN = 24 * 60 * 60 * 1000; // 24 h

    function close() {
        modal.classList.remove('active');
        sessionStorage.setItem(KEY, Date.now());
    }

    function maybeShow() {
        const last = sessionStorage.getItem(KEY);
        if (last && Date.now() - parseInt(last) < COOLDOWN) return;
        setTimeout(() => modal.classList.add('active'), 3500);
    }

    closeBtn ?.addEventListener('click', close);
    remindBtn?.addEventListener('click', close);
    modal.addEventListener('click', e => { if (e.target === modal) close(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') close(); });

    if (document.readyState === 'complete') maybeShow();
    else window.addEventListener('load', maybeShow);
})();
</script>