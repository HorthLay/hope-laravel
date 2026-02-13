{{-- resources/views/admin/settings/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Settings')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="flex items-center gap-4 mb-6">
        <div class="flex-1">
            <h1 class="page-title">Settings</h1>
            <p class="page-subtitle">Manage your site configuration</p>
        </div>
        <form action="{{ route('admin.settings.cache') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                <i class="fas fa-sync-alt mr-2"></i>Clear Cache
            </button>
        </form>
    </div>
</div>

<!-- Settings Form -->
<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Tabs -->
    <div class="card mb-6">
        <div class="flex flex-wrap border-b border-gray-200 -mb-px overflow-x-auto">
            <button type="button" onclick="switchTab('general')" id="tab-general"
                    class="tab-button active px-6 py-4 border-b-2 border-orange-500 text-orange-600 font-semibold whitespace-nowrap">
                <i class="fas fa-cog mr-2"></i>General
            </button>
            <button type="button" onclick="switchTab('contact')" id="tab-contact"
                    class="tab-button px-6 py-4 border-b-2 border-transparent text-gray-600 hover:text-gray-800 hover:border-gray-300 font-semibold transition whitespace-nowrap">
                <i class="fas fa-envelope mr-2"></i>Contact
            </button>
            <button type="button" onclick="switchTab('social')" id="tab-social"
                    class="tab-button px-6 py-4 border-b-2 border-transparent text-gray-600 hover:text-gray-800 hover:border-gray-300 font-semibold transition whitespace-nowrap">
                <i class="fas fa-share-alt mr-2"></i>Social Media
            </button>
            <button type="button" onclick="switchTab('sponsor')" id="tab-sponsor"
                    class="tab-button px-6 py-4 border-b-2 border-transparent text-gray-600 hover:text-gray-800 hover:border-gray-300 font-semibold transition whitespace-nowrap">
                <i class="fas fa-qrcode mr-2"></i>Sponsor / KHQR
            </button>
            <button type="button" onclick="switchTab('seo')" id="tab-seo"
                    class="tab-button px-6 py-4 border-b-2 border-transparent text-gray-600 hover:text-gray-800 hover:border-gray-300 font-semibold transition whitespace-nowrap">
                <i class="fas fa-search mr-2"></i>SEO
            </button>
            <button type="button" onclick="switchTab('advanced')" id="tab-advanced"
                    class="tab-button px-6 py-4 border-b-2 border-transparent text-gray-600 hover:text-gray-800 hover:border-gray-300 font-semibold transition whitespace-nowrap">
                <i class="fas fa-sliders-h mr-2"></i>Advanced
            </button>
        </div>
    </div>

    <div class="space-y-6">

        {{-- ══════════════════════════════════════════
             GENERAL
        ══════════════════════════════════════════ --}}
        <div id="content-general" class="tab-content">
            <div class="card">
                <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <i class="fas fa-cog text-orange-500"></i> General Settings
                </h2>
                <div class="space-y-6">
                    <div>
                        <label for="site_name" class="block text-sm font-semibold text-gray-700 mb-2">Site Name</label>
                        <input type="text" id="site_name" name="site_name"
                               value="{{ old('site_name', $settings['site_name'] ?? 'Hope & Impact') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                               placeholder="Hope & Impact">
                    </div>
                    <div>
                        <label for="site_tagline" class="block text-sm font-semibold text-gray-700 mb-2">Site Tagline</label>
                        <input type="text" id="site_tagline" name="site_tagline"
                               value="{{ old('site_tagline', $settings['site_tagline'] ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                               placeholder="Making a Difference Together">
                    </div>
                    <div>
                        <label for="site_description" class="block text-sm font-semibold text-gray-700 mb-2">Site Description</label>
                        <textarea id="site_description" name="site_description" rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                                  placeholder="A brief description of your charity...">{{ old('site_description', $settings['site_description'] ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Site Logo</label>
                        @if(!empty($settings['logo']))
                            <div class="mb-4 p-4 bg-gray-50 rounded-lg inline-block">
                                <img src="{{ asset(($settings['logo'] ?? '')) }}" alt="Current Logo" class="h-16 object-contain">
                                <p class="text-xs text-gray-500 mt-2">Current Logo</p>
                            </div>
                        @endif
                        <input type="file" name="logo" accept="image/*"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none transition">
                        <p class="mt-2 text-xs text-gray-500">Recommended: PNG or SVG, Max 2MB</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Favicon</label>
                        @if(!empty($settings['favicon']))
                            <div class="mb-4 p-4 bg-gray-50 rounded-lg inline-block">
                                <img src="{{ asset(($settings['favicon'] ?? '')) }}" alt="Current Favicon" class="h-8 object-contain">
                                <p class="text-xs text-gray-500 mt-2">Current Favicon</p>
                            </div>
                        @endif
                        <input type="file" name="favicon" accept="image/x-icon,image/png"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none transition">
                        <p class="mt-2 text-xs text-gray-500">Recommended: ICO or PNG, 32×32px, Max 512KB</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════
             CONTACT
        ══════════════════════════════════════════ --}}
        <div id="content-contact" class="tab-content hidden">
            <div class="card">
                <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <i class="fas fa-envelope text-orange-500"></i> Contact Information
                </h2>
                <div class="space-y-6">
                    <div>
                        <label for="contact_email" class="block text-sm font-semibold text-gray-700 mb-2">Contact Email</label>
                        <div class="relative">
                            <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="email" id="contact_email" name="contact_email"
                                   value="{{ old('contact_email', $settings['contact_email'] ?? '') }}"
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                                   placeholder="contact@example.com">
                        </div>
                    </div>
                    <div>
                        <label for="contact_phone" class="block text-sm font-semibold text-gray-700 mb-2">Contact Phone</label>
                        <div class="relative">
                            <i class="fas fa-phone absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="text" id="contact_phone" name="contact_phone"
                                   value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}"
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                                   placeholder="+855 XX XXX XXXX">
                        </div>
                    </div>
                    <div>
                        <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">Address</label>
                        <div class="relative">
                            <i class="fas fa-map-marker-alt absolute left-3 top-4 text-gray-400"></i>
                            <textarea id="address" name="address" rows="3"
                                      class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                                      placeholder="123 Main Street, Phnom Penh, Cambodia">{{ old('address', $settings['address'] ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════
             SOCIAL MEDIA
        ══════════════════════════════════════════ --}}
        <div id="content-social" class="tab-content hidden">
            <div class="card">
                <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <i class="fas fa-share-alt text-orange-500"></i> Social Media Links
                </h2>
                <div class="space-y-6">

                    {{-- Telegram --}}
                    <div>
                        <label for="telegram_url" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fab fa-telegram text-[#2ca5e0] mr-2"></i>Telegram
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 font-medium">t.me/</span>
                            <input type="text" id="telegram_url" name="telegram_url"
                                   value="{{ old('telegram_url', $settings['telegram_url'] ?? '') }}"
                                   class="w-full pl-14 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                                   placeholder="YourChannelName">
                        </div>
                        <p class="mt-1 text-xs text-gray-400">Username only — e.g. <code>YourChannelName</code> → becomes <code>https://t.me/YourChannelName</code></p>
                    </div>

                    {{-- WhatsApp --}}
                    <div>
                        <label for="whatsapp_url" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fab fa-whatsapp text-[#25d366] mr-2"></i>WhatsApp
                        </label>
                        <div class="relative">
                            <i class="fab fa-whatsapp absolute left-3 top-1/2 -translate-y-1/2 text-[#25d366]"></i>
                            <input type="text" id="whatsapp_url" name="whatsapp_url"
                                   value="{{ old('whatsapp_url', $settings['whatsapp_url'] ?? '') }}"
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                                   placeholder="855XXXXXXXXX">
                        </div>
                        <p class="mt-1 text-xs text-gray-400">Phone number with country code, no + or spaces — e.g. <code>85512345678</code></p>
                    </div>

                    {{-- Instagram --}}
                    <div>
                        <label for="instagram_url" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fab fa-instagram text-pink-600 mr-2"></i>Instagram URL
                        </label>
                        <input type="url" id="instagram_url" name="instagram_url"
                               value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                               placeholder="https://instagram.com/yourprofile">
                    </div>

                    {{-- X / Twitter --}}
                    <div>
                        <label for="x_url" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fab fa-x-twitter text-gray-900 mr-2"></i>X (Twitter) URL
                        </label>
                        <input type="url" id="x_url" name="x_url"
                               value="{{ old('x_url', $settings['x_url'] ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                               placeholder="https://x.com/yourhandle">
                    </div>

                    {{-- Facebook --}}
                    <div>
                        <label for="facebook_url" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fab fa-facebook text-blue-600 mr-2"></i>Facebook URL
                        </label>
                        <input type="url" id="facebook_url" name="facebook_url"
                               value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                               placeholder="https://facebook.com/yourpage">
                    </div>

                    {{-- YouTube --}}
                    <div>
                        <label for="youtube_url" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fab fa-youtube text-red-600 mr-2"></i>YouTube URL
                        </label>
                        <input type="url" id="youtube_url" name="youtube_url"
                               value="{{ old('youtube_url', $settings['youtube_url'] ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                               placeholder="https://youtube.com/c/yourchannel">
                    </div>

                    {{-- LinkedIn --}}
                    <div>
                        <label for="linkedin_url" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fab fa-linkedin text-blue-700 mr-2"></i>LinkedIn URL
                        </label>
                        <input type="url" id="linkedin_url" name="linkedin_url"
                               value="{{ old('linkedin_url', $settings['linkedin_url'] ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                               placeholder="https://linkedin.com/company/yourcompany">
                    </div>

                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════
             SPONSOR / KHQR  (new tab)
        ══════════════════════════════════════════ --}}
        <div id="content-sponsor" class="tab-content hidden">
            <div class="card">
                <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <i class="fas fa-qrcode text-orange-500"></i> Sponsor Page &amp; KHQR Settings
                </h2>
                <p class="text-sm text-gray-500 mb-6 bg-orange-50 border border-orange-100 rounded-lg px-4 py-3">
                    <i class="fas fa-info-circle text-orange-400 mr-2"></i>
                    These values appear on the public <strong>Sponsor</strong> page — contact buttons, QR code, and bank account details.
                </p>

                <div class="space-y-6">

                    {{-- KHQR / QR Image --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-qrcode text-red-600 mr-2"></i>KHQR / ABA QR Code Image
                        </label>

                        @if(!empty($settings['khqr_image'] ?? ''))
                            <div class="mb-4 p-4 bg-gray-50 rounded-xl inline-flex flex-col items-center gap-2">
                                <div class="bg-gradient-to-br from-red-700 to-red-600 p-3 rounded-lg">
                                    <div class="bg-white p-2 rounded">
                                        <img src="{{ asset(($settings['khqr_image'] ?? '')) }}" alt="KHQR Code" class="w-32 h-32 object-contain">
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500">Current KHQR Image</p>
                            </div>
                        @endif

                        <input type="file" name="khqr_image" accept="image/jpeg,image/jpg,image/png"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none transition">
                        <p class="mt-2 text-xs text-gray-500">Upload your KHQR or ABA QR code image. PNG recommended, Max 2MB.</p>
                    </div>

                    {{-- Account Name --}}
                    <div>
                        <label for="account_name" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user-circle text-gray-400 mr-2"></i>Account Name (shown under QR)
                        </label>
                        <input type="text" id="account_name" name="account_name"
                               value="{{ old('account_name', $settings['account_name'] ?? 'Hope & Impact Foundation') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                               placeholder="Hope & Impact Foundation">
                    </div>

                    {{-- Account Bank --}}
                    <div>
                        <label for="account_bank" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-university text-gray-400 mr-2"></i>Bank / Description (shown under account name)
                        </label>
                        <input type="text" id="account_bank" name="account_bank"
                               value="{{ old('account_bank', $settings['account_bank'] ?? 'ABA Bank · Phnom Penh, Cambodia') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                               placeholder="ABA Bank · Phnom Penh, Cambodia">
                    </div>

                    {{-- Divider --}}
                    <div class="border-t pt-4">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4">
                            <i class="fas fa-link mr-1"></i> Sponsor Contact Links
                            <span class="font-normal normal-case text-gray-400 ml-1">(pulled from Social Media tab — shown here for reference)</span>
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="bg-[#2ca5e0]/5 border border-[#2ca5e0]/20 rounded-xl p-4 flex items-center gap-3">
                                <i class="fab fa-telegram text-[#2ca5e0] text-2xl"></i>
                                <div>
                                    <p class="text-xs font-bold text-gray-700">Telegram</p>
                                    <p class="text-xs text-gray-500 font-mono">{{ !empty(($settings['telegram_url'] ?? '')) ? 't.me/'.($settings['telegram_url'] ?? '') : 'Not set — go to Social Media tab' }}</p>
                                </div>
                            </div>
                            <div class="bg-[#25d366]/5 border border-[#25d366]/20 rounded-xl p-4 flex items-center gap-3">
                                <i class="fab fa-whatsapp text-[#25d366] text-2xl"></i>
                                <div>
                                    <p class="text-xs font-bold text-gray-700">WhatsApp</p>
                                    <p class="text-xs text-gray-500 font-mono">{{ !empty(($settings['whatsapp_url'] ?? '')) ? 'wa.me/'.($settings['whatsapp_url'] ?? '') : 'Not set — go to Social Media tab' }}</p>
                                </div>
                            </div>
                            <div class="bg-pink-50 border border-pink-100 rounded-xl p-4 flex items-center gap-3">
                                <i class="fab fa-instagram text-pink-500 text-2xl"></i>
                                <div>
                                    <p class="text-xs font-bold text-gray-700">Instagram</p>
                                    <p class="text-xs text-gray-500 font-mono truncate">{{ $settings['instagram_url'] ?? 'Not set — go to Social Media tab' ?: 'Not set — go to Social Media tab' }}</p>
                                </div>
                            </div>
                            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 flex items-center gap-3">
                                <i class="fab fa-x-twitter text-gray-900 text-2xl"></i>
                                <div>
                                    <p class="text-xs font-bold text-gray-700">X (Twitter)</p>
                                    <p class="text-xs text-gray-500 font-mono truncate">{{ $settings['x_url'] ?? 'Not set — go to Social Media tab' ?: 'Not set — go to Social Media tab' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════
             SEO
        ══════════════════════════════════════════ --}}
        <div id="content-seo" class="tab-content hidden">
            <div class="card">
                <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <i class="fas fa-search text-orange-500"></i> SEO Settings
                </h2>
                <div class="space-y-6">
                    <div>
                        <label for="meta_title" class="block text-sm font-semibold text-gray-700 mb-2">Meta Title</label>
                        <input type="text" id="meta_title" name="meta_title"
                               value="{{ old('meta_title', $settings['meta_title'] ?? '') }}"
                               maxlength="60"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                               placeholder="Your Site - Tagline"
                               onkeyup="updateCharCount('meta_title', 60)">
                        <p class="mt-2 text-xs text-gray-500">
                            <span id="meta_title_count">0</span>/60 characters · Recommended: 50–60
                        </p>
                    </div>
                    <div>
                        <label for="meta_description" class="block text-sm font-semibold text-gray-700 mb-2">Meta Description</label>
                        <textarea id="meta_description" name="meta_description" rows="3" maxlength="160"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                                  placeholder="A brief description for search engines..."
                                  onkeyup="updateCharCount('meta_description', 160)">{{ old('meta_description', $settings['meta_description'] ?? '') }}</textarea>
                        <p class="mt-2 text-xs text-gray-500">
                            <span id="meta_description_count">0</span>/160 characters · Recommended: 150–160
                        </p>
                    </div>
                    <div>
                        <label for="meta_keywords" class="block text-sm font-semibold text-gray-700 mb-2">Meta Keywords</label>
                        <input type="text" id="meta_keywords" name="meta_keywords"
                               value="{{ old('meta_keywords', $settings['meta_keywords'] ?? '') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                               placeholder="charity, nonprofit, help, community">
                        <p class="mt-2 text-xs text-gray-500">Separate keywords with commas</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════
             ADVANCED
        ══════════════════════════════════════════ --}}
        <div id="content-advanced" class="tab-content hidden">
            <div class="card">
                <h2 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <i class="fas fa-sliders-h text-orange-500"></i> Advanced Settings
                </h2>
                <div class="space-y-6">
                    <div>
                        <label for="timezone" class="block text-sm font-semibold text-gray-700 mb-2">Timezone</label>
                        <select id="timezone" name="timezone"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition">
                            <option value="UTC"                {{ ($settings['timezone'] ?? 'UTC') == 'UTC' ? 'selected' : '' }}>UTC (Coordinated Universal Time)</option>
                            <option value="Asia/Phnom_Penh"   {{ ($settings['timezone'] ?? '') == 'Asia/Phnom_Penh'   ? 'selected' : '' }}>Phnom Penh (ICT, UTC+7)</option>
                            <option value="Asia/Bangkok"      {{ ($settings['timezone'] ?? '') == 'Asia/Bangkok'      ? 'selected' : '' }}>Bangkok (ICT, UTC+7)</option>
                            <option value="Asia/Singapore"    {{ ($settings['timezone'] ?? '') == 'Asia/Singapore'    ? 'selected' : '' }}>Singapore (SGT, UTC+8)</option>
                            <option value="Asia/Shanghai"     {{ ($settings['timezone'] ?? '') == 'Asia/Shanghai'     ? 'selected' : '' }}>Beijing (CST, UTC+8)</option>
                            <option value="Asia/Tokyo"        {{ ($settings['timezone'] ?? '') == 'Asia/Tokyo'        ? 'selected' : '' }}>Tokyo (JST, UTC+9)</option>
                            <option value="Europe/London"     {{ ($settings['timezone'] ?? '') == 'Europe/London'     ? 'selected' : '' }}>London</option>
                            <option value="Europe/Paris"      {{ ($settings['timezone'] ?? '') == 'Europe/Paris'      ? 'selected' : '' }}>Paris</option>
                            <option value="America/New_York"  {{ ($settings['timezone'] ?? '') == 'America/New_York'  ? 'selected' : '' }}>Eastern Time (US)</option>
                            <option value="America/Los_Angeles" {{ ($settings['timezone'] ?? '') == 'America/Los_Angeles' ? 'selected' : '' }}>Pacific Time (US)</option>
                            <option value="Australia/Sydney"  {{ ($settings['timezone'] ?? '') == 'Australia/Sydney'  ? 'selected' : '' }}>Sydney</option>
                        </select>
                    </div>
                    <div>
                        <label for="date_format" class="block text-sm font-semibold text-gray-700 mb-2">Date Format</label>
                        <select id="date_format" name="date_format"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition">
                            <option value="M d, Y" {{ ($settings['date_format'] ?? 'M d, Y') == 'M d, Y' ? 'selected' : '' }}>Jan 15, 2024</option>
                            <option value="d/m/Y"  {{ ($settings['date_format'] ?? '') == 'd/m/Y'  ? 'selected' : '' }}>15/01/2024</option>
                            <option value="m/d/Y"  {{ ($settings['date_format'] ?? '') == 'm/d/Y'  ? 'selected' : '' }}>01/15/2024</option>
                            <option value="Y-m-d"  {{ ($settings['date_format'] ?? '') == 'Y-m-d'  ? 'selected' : '' }}>2024-01-15</option>
                        </select>
                    </div>
                    <div>
                        <label for="articles_per_page" class="block text-sm font-semibold text-gray-700 mb-2">Articles Per Page</label>
                        <input type="number" id="articles_per_page" name="articles_per_page"
                               value="{{ old('articles_per_page', $settings['articles_per_page'] ?? 12) }}"
                               min="1" max="100"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition">
                    </div>
                    <div class="space-y-4 pt-4 border-t">
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <label for="enable_comments" class="font-semibold text-gray-800">Enable Comments</label>
                                <p class="text-sm text-gray-600">Allow users to comment on articles</p>
                            </div>
                            <input type="checkbox" id="enable_comments" name="enable_comments" value="1"
                                   {{ ($settings['enable_comments'] ?? false) ? 'checked' : '' }}
                                   class="w-12 h-6 rounded-full border-gray-300 text-orange-500 focus:ring-orange-500">
                        </div>
                        <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg border border-red-200">
                            <div>
                                <label for="maintenance_mode" class="font-semibold text-red-800">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>Maintenance Mode
                                </label>
                                <p class="text-sm text-red-600">Display "Under Maintenance" message to visitors</p>
                            </div>
                            <input type="checkbox" id="maintenance_mode" name="maintenance_mode" value="1"
                                   {{ ($settings['maintenance_mode'] ?? false) ? 'checked' : '' }}
                                   class="w-12 h-6 rounded-full border-gray-300 text-red-500 focus:ring-red-500">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- end tab contents --}}

    <!-- Save Button -->
    <div class="card mt-6">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-sm text-gray-600">
                <i class="fas fa-info-circle text-gray-400 mr-2"></i>
                Changes will be saved immediately and reflected on the public site
            </p>
            <button type="submit" class="action-btn w-full md:w-auto justify-center">
                <i class="fas fa-save mr-2"></i>Save Settings
            </button>
        </div>
    </div>
</form>

@push('scripts')
<script>
function switchTab(tabName) {
    document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
    document.querySelectorAll('.tab-button').forEach(b => {
        b.classList.remove('active','border-orange-500','text-orange-600');
        b.classList.add('border-transparent','text-gray-600');
    });
    document.getElementById('content-' + tabName).classList.remove('hidden');
    const t = document.getElementById('tab-' + tabName);
    t.classList.add('active','border-orange-500','text-orange-600');
    t.classList.remove('border-transparent','text-gray-600');
}

function updateCharCount(fieldId, max) {
    const f = document.getElementById(fieldId);
    const c = document.getElementById(fieldId + '_count');
    c.textContent = f.value.length;
    c.classList.toggle('text-red-600', f.value.length > max * 0.9);
    c.classList.toggle('font-bold',    f.value.length > max * 0.9);
}

document.addEventListener('DOMContentLoaded', () => {
    updateCharCount('meta_title', 60);
    updateCharCount('meta_description', 160);
});
</script>
@endpush

@endsection