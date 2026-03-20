{{-- resources/views/layouts/cookie-consent.blade.php --}}
{{-- ═══════════════════════════════════════════════════════
     COOKIE CONSENT BANNER — Hope & Impact Design System
     Include ONCE in home.blade.php and layouts/page.blade.php
     Usage: @include('layouts.cookie-consent')
     Place it just before the closing </body> tag, after all @include('layouts.footer') etc.
═══════════════════════════════════════════════════════ --}}

<style>
/* ── Cookie consent variables ──────────────────────────────── */
:root {
    --ck-orange:        #f97316;
    --ck-orange-dark:   #ea580c;
    --ck-orange-light:  #fff7ed;
    --ck-navy:          #1a2e3b;
    --ck-navy-2:        #243444;
    --ck-white:         #ffffff;
    --ck-gray-50:       #f9fafb;
    --ck-gray-100:      #f3f4f6;
    --ck-gray-200:      #e5e7eb;
    --ck-gray-400:      #9ca3af;
    --ck-gray-600:      #4b5563;
    --ck-gray-800:      #1f2937;
    --ck-radius:        20px;
    --ck-shadow:        0 -4px 32px rgba(0,0,0,.10), 0 8px 64px rgba(0,0,0,.06);
    --ck-ease:          cubic-bezier(.34,1.1,.64,1);
}

/* ── Banner wrapper ────────────────────────────────────────── */
#ck-banner {
    position: fixed;
    bottom: 0; left: 0; right: 0;
    z-index: 9999;
    padding: 0 16px 16px;
    pointer-events: none;
    display: flex;
    justify-content: center;
    align-items: flex-end;
}
#ck-banner.ck-hidden { display: none; }

/* ── Lift above bottom nav bar on mobile ───────────────────── */
@media (max-width: 767px) {
    #ck-banner {
        /* bottom nav is ~70px tall — add safe-area too */
        padding-bottom: calc(70px + env(safe-area-inset-bottom, 0px) + 10px);
    }
}

/* ── Banner card ───────────────────────────────────────────── */
#ck-card {
    pointer-events: all;
    background: var(--ck-white);
    border: 1px solid var(--ck-gray-200);
    border-radius: var(--ck-radius);
    box-shadow: var(--ck-shadow);
    max-width: 960px; width: 100%;
    overflow: hidden;

    /* Slide-up animation */
    transform: translateY(110%);
    opacity: 0;
    transition: transform .55s var(--ck-ease), opacity .45s ease;
}
#ck-card.ck-visible {
    transform: translateY(0);
    opacity: 1;
}

/* ── Card inner layout ─────────────────────────────────────── */
.ck-inner {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 20px 22px;
}
@media (max-width: 700px) {
    .ck-inner {
        flex-direction: column; align-items: stretch;
        gap: 10px; padding: 14px 14px 12px;
    }
}

/* ── Orange accent bar at top ──────────────────────────────── */
.ck-accent-bar {
    height: 3px;
    background: linear-gradient(to right, var(--ck-orange), #f59e0b, var(--ck-orange));
    background-size: 200% 100%;
    animation: ck-shimmer 3s linear infinite;
}
@keyframes ck-shimmer {
    0%   { background-position: -200% center; }
    100% { background-position:  200% center; }
}

/* ── Icon badge ────────────────────────────────────────────── */
.ck-icon-wrap {
    flex-shrink: 0;
    width: 52px; height: 52px;
    background: var(--ck-orange-light);
    border: 1.5px solid #fed7aa;
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    font-size: 24px;
    animation: ck-float 3s ease-in-out infinite;
}
@keyframes ck-float {
    0%,100% { transform: translateY(0);   }
    50%      { transform: translateY(-4px); }
}
@media (max-width: 700px) { .ck-icon-wrap { display: none; } }

/* ── Text block ────────────────────────────────────────────── */
.ck-text { flex: 1; min-width: 0; }
.ck-title {
    font-size: 14px; font-weight: 900;
    color: var(--ck-gray-800); margin-bottom: 3px;
    display: flex; align-items: center; gap: 8px;
}
.ck-title .ck-badge {
    font-size: 9px; font-weight: 800; letter-spacing: .06em; text-transform: uppercase;
    background: var(--ck-orange); color: #fff;
    padding: 2px 8px; border-radius: 99px;
}
.ck-desc {
    font-size: 12px; color: var(--ck-gray-600); line-height: 1.6; margin: 0;
}
.ck-desc a {
    color: var(--ck-orange); font-weight: 700; text-decoration: none;
    border-bottom: 1px solid transparent; transition: border-color .15s;
}
.ck-desc a:hover { border-bottom-color: var(--ck-orange); }

/* ── Actions row ───────────────────────────────────────────── */
.ck-actions {
    display: flex; align-items: center;
    gap: 8px; flex-shrink: 0; flex-wrap: wrap;
}
@media (max-width: 700px) {
    .ck-actions {
        justify-content: stretch;
        gap: 6px;
    }
    /* Accept All takes more width, others share the rest */
    .ck-actions .ck-btn-accept    { flex: 2; }
    .ck-actions .ck-btn-necessary { flex: 1; }
    .ck-actions .ck-btn-manage    { flex: 0 0 auto; }
}

/* ── Buttons ───────────────────────────────────────────────── */
.ck-btn {
    display: inline-flex; align-items: center; justify-content: center; gap: 7px;
    font-size: 12px; font-weight: 900; cursor: pointer; border: none;
    border-radius: 12px; padding: 10px 18px;
    transition: transform .15s, box-shadow .15s, background .15s, opacity .15s;
    font-family: inherit; white-space: nowrap;
}
.ck-btn:hover  { transform: translateY(-2px); }
.ck-btn:active { transform: scale(.97); }

/* Accept All — orange primary */
.ck-btn-accept {
    background: linear-gradient(135deg, var(--ck-orange), var(--ck-orange-dark));
    color: #fff;
    box-shadow: 0 4px 16px rgba(249,115,22,.35);
}
.ck-btn-accept:hover { box-shadow: 0 6px 24px rgba(249,115,22,.48); }

/* Necessary only — ghost */
.ck-btn-necessary {
    background: var(--ck-gray-100);
    color: var(--ck-gray-600);
    border: 1.5px solid var(--ck-gray-200);
}
.ck-btn-necessary:hover { background: var(--ck-gray-200); color: var(--ck-gray-800); }

/* Manage — text link style */
.ck-btn-manage {
    background: transparent;
    color: var(--ck-orange);
    border: 1.5px solid #fed7aa;
    padding: 10px 14px;
}
.ck-btn-manage:hover { background: var(--ck-orange-light); }

@media (max-width: 700px) {
    .ck-btn { flex: 1; padding: 11px 12px; }
    .ck-btn-manage { flex: 0 0 auto; }
}

/* ── Preferences modal ─────────────────────────────────────── */
#ck-prefs-overlay {
    position: fixed; inset: 0;
    /* above the bottom nav (z ~100) and the banner (9999) */
    z-index: 10100;
    background: rgba(0,0,0,.55); backdrop-filter: blur(6px);
    display: none; align-items: flex-end; justify-content: center;
    padding: 0;
}
#ck-prefs-overlay.ck-open { display: flex; }

#ck-prefs-sheet {
    background: var(--ck-white);
    border-radius: 24px 24px 0 0;
    width: 100%; max-width: 540px; max-height: 90dvh;
    overflow-y: auto;
    transform: translateY(110%);
    transition: transform .38s var(--ck-ease);
    /* pad enough for the bottom nav + device safe area */
    padding-bottom: max(env(safe-area-inset-bottom, 0px), 16px);
}
#ck-prefs-overlay.ck-open #ck-prefs-sheet { transform: translateY(0); }

.ck-prefs-handle {
    width: 40px; height: 4px; background: var(--ck-gray-200);
    border-radius: 2px; margin: 14px auto 0;
}
.ck-prefs-head {
    padding: 14px 20px 12px;
    border-bottom: 1px solid var(--ck-gray-100);
    position: sticky; top: 0; background: var(--ck-white); z-index: 1;
    display: flex; align-items: center; justify-content: space-between;
}
.ck-prefs-title { font-size: 16px; font-weight: 900; color: var(--ck-gray-800); }
.ck-prefs-close {
    width: 32px; height: 32px; border-radius: 50%;
    border: none; background: var(--ck-gray-100); cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    color: var(--ck-gray-600); font-size: 12px; transition: background .2s;
    font-family: inherit;
}
.ck-prefs-close:hover { background: var(--ck-gray-200); }
.ck-prefs-body { padding: 18px 20px 24px; }
.ck-prefs-desc { font-size: 13px; color: var(--ck-gray-600); line-height: 1.65; margin-bottom: 18px; }

/* ── Toggle rows ───────────────────────────────────────────── */
.ck-toggle-row {
    display: flex; align-items: flex-start; justify-content: space-between;
    gap: 16px; padding: 14px 0;
    border-bottom: 1px solid var(--ck-gray-100);
}
.ck-toggle-row:last-of-type { border-bottom: none; }
.ck-toggle-info { flex: 1; min-width: 0; }
.ck-toggle-label { font-size: 13px; font-weight: 800; color: var(--ck-gray-800); margin-bottom: 3px; }
.ck-toggle-sub   { font-size: 11px; color: var(--ck-gray-400); line-height: 1.5; }

/* HTML toggle switch */
.ck-switch { position: relative; display: inline-block; width: 44px; height: 24px; flex-shrink: 0; margin-top: 1px; }
.ck-switch input { opacity: 0; width: 0; height: 0; }
.ck-slider {
    position: absolute; inset: 0; cursor: pointer;
    background: var(--ck-gray-200); border-radius: 24px;
    transition: background .25s;
}
.ck-slider::before {
    content: ''; position: absolute;
    width: 18px; height: 18px; border-radius: 50%;
    background: var(--ck-white);
    left: 3px; top: 3px;
    transition: transform .25s var(--ck-ease);
    box-shadow: 0 1px 4px rgba(0,0,0,.18);
}
.ck-switch input:checked + .ck-slider { background: var(--ck-orange); }
.ck-switch input:checked + .ck-slider::before { transform: translateX(20px); }
.ck-switch input:disabled + .ck-slider { opacity: .5; cursor: not-allowed; }

/* Required badge on essential row */
.ck-required-tag {
    font-size: 10px; font-weight: 700; letter-spacing: .05em;
    background: var(--ck-gray-100); color: var(--ck-gray-400);
    padding: 2px 8px; border-radius: 99px;
    display: inline-block; margin-top: 4px;
}

/* ── Prefs footer ──────────────────────────────────────────── */
.ck-prefs-footer {
    display: flex; gap: 10px;
    padding: 16px 20px 20px;
    border-top: 1px solid var(--ck-gray-100);
    position: sticky; bottom: 0; background: var(--ck-white);
}
.ck-prefs-footer .ck-btn { flex: 1; padding: 12px; }

/* ── Floating revoke pill (shows after consent) ────────────── */
#ck-revoke {
    position: fixed;
    bottom: 20px; right: 20px;
    z-index: 9000;
    display: none;
}
#ck-revoke.ck-visible { display: flex; }

/* Lift above bottom nav on mobile */
@media (max-width: 767px) {
    #ck-revoke {
        bottom: calc(70px + env(safe-area-inset-bottom, 0px) + 12px);
        right: 14px;
    }
}
#ck-revoke-btn {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--ck-navy);
    color: rgba(255,255,255,.8);
    font-size: 11px; font-weight: 700;
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 99px; padding: 8px 14px;
    cursor: pointer; box-shadow: 0 4px 20px rgba(0,0,0,.25);
    transition: background .2s, color .2s, transform .15s;
    font-family: inherit;
}
#ck-revoke-btn:hover { background: var(--ck-navy-2); color: #fff; transform: translateY(-2px); }
#ck-revoke-btn i { font-size: 13px; }
</style>

{{-- ════════════════════════════════════════
     COOKIE BANNER
════════════════════════════════════════ --}}
<div id="ck-banner" class="ck-hidden" role="dialog" aria-label="Cookie Consent" aria-describedby="ck-desc-text">
    <div id="ck-card">
        <div class="ck-accent-bar"></div>
        <div class="ck-inner">

            {{-- Cookie icon --}}
            <div class="ck-icon-wrap" aria-hidden="true">🍪</div>

            {{-- Text --}}
            <div class="ck-text">
                <div class="ck-title">
                    We use cookies
                    <span class="ck-badge">Privacy</span>
                </div>
                <p class="ck-desc" id="ck-desc-text">
                    We use cookies to personalise content, analyse traffic, and improve your experience on
                    <strong>{{ $settings['site_name'] ?? 'Hope & Impact' }}</strong>.
                    By clicking <strong>"Accept All"</strong> you consent to our use of cookies.
                    <a href="#" onclick="openCkPrefs(event)">Manage preferences</a> or read our
                    @if(Route::has('privacy.policy'))
                    <a href="{{ route('privacy.policy') }}" target="_blank">Privacy Policy</a>.
                    @else
                    <a href="/privacy-policy" target="_blank">Privacy Policy</a>.
                    @endif
                </p>
            </div>

            {{-- Action buttons --}}
            <div class="ck-actions">
                <button class="ck-btn ck-btn-manage"   onclick="openCkPrefs(event)"    aria-label="Manage cookie preferences">
                    <i class="fas fa-sliders-h" style="font-size:11px"></i> Manage
                </button>
                <button class="ck-btn ck-btn-necessary" onclick="ckAcceptNecessary()"  aria-label="Accept necessary cookies only">
                    Necessary Only
                </button>
                <button class="ck-btn ck-btn-accept"    onclick="ckAcceptAll()"         aria-label="Accept all cookies">
                    <i class="fas fa-check" style="font-size:10px"></i> Accept All
                </button>
            </div>

        </div>
    </div>
</div>

{{-- ════════════════════════════════════════
     PREFERENCES MODAL
════════════════════════════════════════ --}}
<div id="ck-prefs-overlay" role="dialog" aria-modal="true" aria-label="Cookie Preferences"
     onclick="handleCkOverlayClick(event)">
    <div id="ck-prefs-sheet">
        <div class="ck-prefs-handle"></div>

        <div class="ck-prefs-head">
            <span class="ck-prefs-title">
                <i class="fas fa-cookie-bite" style="color:var(--ck-orange);margin-right:8px;font-size:14px"></i>
                Cookie Preferences
            </span>
            <button class="ck-prefs-close" onclick="closeCkPrefs()" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="ck-prefs-body">
            <p class="ck-prefs-desc">
                Choose which cookies you allow. Essential cookies cannot be disabled — they are required for the website to function properly. All other categories are optional.
            </p>

            {{-- Essential (always on) --}}
            <div class="ck-toggle-row">
                <div class="ck-toggle-info">
                    <div class="ck-toggle-label">
                        <i class="fas fa-shield-alt" style="color:var(--ck-orange);margin-right:6px;font-size:11px"></i>
                        Essential Cookies
                    </div>
                    <div class="ck-toggle-sub">Required for the site to work — login sessions, security tokens, language settings.</div>
                    <span class="ck-required-tag">Always active</span>
                </div>
                <label class="ck-switch">
                    <input type="checkbox" id="ck-essential" checked disabled>
                    <span class="ck-slider"></span>
                </label>
            </div>

            {{-- Analytics --}}
            <div class="ck-toggle-row">
                <div class="ck-toggle-info">
                    <div class="ck-toggle-label">
                        <i class="fas fa-chart-bar" style="color:#3b82f6;margin-right:6px;font-size:11px"></i>
                        Analytics Cookies
                    </div>
                    <div class="ck-toggle-sub">Help us understand how visitors interact with our website so we can improve performance and content.</div>
                </div>
                <label class="ck-switch">
                    <input type="checkbox" id="ck-analytics">
                    <span class="ck-slider"></span>
                </label>
            </div>

            {{-- Marketing --}}
            <div class="ck-toggle-row">
                <div class="ck-toggle-info">
                    <div class="ck-toggle-label">
                        <i class="fas fa-bullhorn" style="color:#8b5cf6;margin-right:6px;font-size:11px"></i>
                        Marketing Cookies
                    </div>
                    <div class="ck-toggle-sub">Used to deliver personalised content and measure the effectiveness of our campaigns.</div>
                </div>
                <label class="ck-switch">
                    <input type="checkbox" id="ck-marketing">
                    <span class="ck-slider"></span>
                </label>
            </div>

            {{-- Functional --}}
            <div class="ck-toggle-row">
                <div class="ck-toggle-info">
                    <div class="ck-toggle-label">
                        <i class="fas fa-cogs" style="color:#10b981;margin-right:6px;font-size:11px"></i>
                        Functional Cookies
                    </div>
                    <div class="ck-toggle-sub">Enable enhanced features like embedded videos, social sharing buttons, and live chat.</div>
                </div>
                <label class="ck-switch">
                    <input type="checkbox" id="ck-functional">
                    <span class="ck-slider"></span>
                </label>
            </div>
        </div>

        <div class="ck-prefs-footer">
            <button class="ck-btn ck-btn-necessary" onclick="ckSavePrefs()"  aria-label="Save preferences">
                <i class="fas fa-save" style="font-size:10px"></i> Save Preferences
            </button>
            <button class="ck-btn ck-btn-accept"    onclick="ckAcceptAll()"  aria-label="Accept all cookies">
                <i class="fas fa-check" style="font-size:10px"></i> Accept All
            </button>
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════
     FLOATING REVOKE PILL
════════════════════════════════════════ --}}
<div id="ck-revoke" title="Manage cookies">
    <button id="ck-revoke-btn" onclick="ckRevoke()" aria-label="Manage cookie settings">
        🍪 Cookie Settings
    </button>
</div>

{{-- ════════════════════════════════════════
     COOKIE CONSENT SCRIPT
════════════════════════════════════════ --}}
<script>
(function () {
    'use strict';

    /* ── Storage key ──────────────────────────────── */
    var CK_KEY        = 'hope_cookie_consent';
    var CK_EXPIRY_DAYS = 180; // re-ask after 180 days

    /* ── DOM refs ─────────────────────────────────── */
    var banner        = document.getElementById('ck-banner');
    var card          = document.getElementById('ck-card');
    var prefsOverlay  = document.getElementById('ck-prefs-overlay');
    var revokeWrap    = document.getElementById('ck-revoke');

    /* ── Helper: read / write consent ─────────────── */
    function readConsent() {
        try {
            var raw = localStorage.getItem(CK_KEY);
            if (!raw) return null;
            var obj = JSON.parse(raw);
            // Expire after CK_EXPIRY_DAYS
            if (obj.ts && (Date.now() - obj.ts) > CK_EXPIRY_DAYS * 86400000) {
                localStorage.removeItem(CK_KEY);
                return null;
            }
            return obj;
        } catch(e) { return null; }
    }

    function writeConsent(prefs) {
        prefs.ts = Date.now();
        try { localStorage.setItem(CK_KEY, JSON.stringify(prefs)); } catch(e) {}
    }

    /* ── Show / hide banner ───────────────────────── */
    function showBanner() {
        banner.classList.remove('ck-hidden');
        // Force reflow before adding .ck-visible so transition fires
        requestAnimationFrame(function() {
            requestAnimationFrame(function() { card.classList.add('ck-visible'); });
        });
        document.body.style.paddingBottom = '0'; // no layout shift
    }

    function hideBanner() {
        card.classList.remove('ck-visible');
        setTimeout(function() { banner.classList.add('ck-hidden'); }, 500);
    }

    /* ── Show revoke pill ─────────────────────────── */
    function showRevoke() {
        if (revokeWrap) revokeWrap.classList.add('ck-visible');
    }
    function hideRevoke() {
        if (revokeWrap) revokeWrap.classList.remove('ck-visible');
    }

    /* ── Apply consent (fire callbacks) ──────────── */
    function applyConsent(prefs) {
        // Google Analytics example — extend as needed
        if (typeof gtag !== 'undefined') {
            gtag('consent', 'update', {
                'analytics_storage':  prefs.analytics  ? 'granted' : 'denied',
                'ad_storage':         prefs.marketing  ? 'granted' : 'denied',
                'functionality_storage': prefs.functional ? 'granted' : 'denied'
            });
        }
        // Dispatch custom event for other scripts to listen to
        window.dispatchEvent(new CustomEvent('cookieConsentUpdated', { detail: prefs }));
    }

    /* ── Public: Accept All ───────────────────────── */
    window.ckAcceptAll = function() {
        var prefs = { accepted: true, analytics: true, marketing: true, functional: true };
        writeConsent(prefs);
        applyConsent(prefs);
        hideBanner();
        closeCkPrefs();
        showRevoke();
    };

    /* ── Public: Necessary Only ───────────────────── */
    window.ckAcceptNecessary = function() {
        var prefs = { accepted: true, analytics: false, marketing: false, functional: false };
        writeConsent(prefs);
        applyConsent(prefs);
        hideBanner();
        closeCkPrefs();
        showRevoke();
    };

    /* ── Public: Save custom prefs ────────────────── */
    window.ckSavePrefs = function() {
        var prefs = {
            accepted:   true,
            analytics:  document.getElementById('ck-analytics')?.checked  || false,
            marketing:  document.getElementById('ck-marketing')?.checked  || false,
            functional: document.getElementById('ck-functional')?.checked || false
        };
        writeConsent(prefs);
        applyConsent(prefs);
        hideBanner();
        closeCkPrefs();
        showRevoke();
    };

    /* ── Public: Revoke (re-open banner) ──────────── */
    window.ckRevoke = function() {
        localStorage.removeItem(CK_KEY);
        hideRevoke();
        // Reset toggles
        var el;
        ['analytics','marketing','functional'].forEach(function(k) {
            el = document.getElementById('ck-' + k);
            if (el) el.checked = false;
        });
        showBanner();
    };

    /* ── Public: Open preferences modal ──────────── */
    window.openCkPrefs = function(e) {
        if (e) e.preventDefault();
        // Populate toggles from saved prefs
        var prefs = readConsent();
        if (prefs) {
            ['analytics','marketing','functional'].forEach(function(k) {
                var el = document.getElementById('ck-' + k);
                if (el) el.checked = !!prefs[k];
            });
        }
        prefsOverlay.classList.add('ck-open');
        document.body.style.overflow = 'hidden';
    };

    /* ── Public: Close preferences modal ─────────── */
    window.closeCkPrefs = function() {
        prefsOverlay.classList.remove('ck-open');
        document.body.style.overflow = '';
    };

    /* ── Overlay click-outside ────────────────────── */
    window.handleCkOverlayClick = function(e) {
        if (e.target === prefsOverlay) closeCkPrefs();
    };

    /* ── Escape key ───────────────────────────────── */
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeCkPrefs();
    });

    /* ── Init ─────────────────────────────────────── */
    var saved = readConsent();
    if (saved && saved.accepted) {
        // Already consented — apply silently and show revoke pill
        applyConsent(saved);
        showRevoke();
    } else {
        // Show banner after a short delay (feels less aggressive)
        setTimeout(showBanner, 900);
    }

}());
</script>