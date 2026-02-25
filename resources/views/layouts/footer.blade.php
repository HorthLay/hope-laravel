<footer class="py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-8">
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-3 mb-4">
                  @if(!empty($settings['logo']))
                    <img src="{{ asset($settings['logo']) }}" 
                        alt="{{ $settings['site_name'] ?? 'Logo' }}" 
                        class="h-[70px] w-auto object-contain">
                @else
                    <div class="w-[70px] h-[70px] bg-gradient-to-br from-[#f4b630] to-[#e0a500] rounded-full flex items-center justify-center">
                        <i class="fas fa-heart text-white text-2xl"></i>
                    </div>
                @endif
                </div>

                <p class="text-gray-400 text-sm mb-4">
                    {{ $settings['site_description'] ?? '' }}
                </p>

                <div class="flex gap-3">
                    @if(!empty($settings['facebook_url']))
                    <a href="{{ $settings['facebook_url'] }}" target="_blank"
                       class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center hover:bg-[#f4b630] transition">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    @endif

                    @if(!empty($settings['instagram_url']))
                    <a href="{{ $settings['instagram_url'] }}" target="_blank"
                       class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center hover:bg-[#f4b630] transition">
                        <i class="fab fa-instagram"></i>
                    </a>
                    @endif

                    @if(!empty($settings['youtube_url']))
                    <a href="{{ $settings['youtube_url'] }}" target="_blank"
                       class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center hover:bg-[#f4b630] transition">
                        <i class="fab fa-youtube"></i>
                    </a>
                    @endif

                    @if(!empty($settings['telegram_url']))
                    <a href="https://t.me/{{ $settings['telegram_url'] }}" target="_blank"
                       class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center hover:bg-[#f4b630] transition">
                        <i class="fab fa-telegram"></i>
                    </a>
                    @endif

                    @if(!empty($settings['whatsapp_url']))
                    <a href="https://wa.me/{{ $settings['whatsapp_url'] }}" target="_blank"
                       class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center hover:bg-[#f4b630] transition">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    @endif

                    @if(!empty($settings['linkedin_url']))
                    <a href="{{ $settings['linkedin_url'] }}" target="_blank"
                       class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center hover:bg-[#f4b630] transition">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    @endif
                </div>
            </div>

            <div>
                <h4 class="font-bold text-lg mb-4">Our Work</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="{{ route('learn-more') }}" class="hover:text-[#f4b630] transition">Education Programs</a></li>
                    <li><a href="{{ route('learn-more') }}" class="hover:text-[#f4b630] transition">Healthcare Access</a></li>
                    <li><a href="{{ route('learn-more') }}" class="hover:text-[#f4b630] transition">Nutrition Support</a></li>
                    <li><a href="{{ route('learn-more') }}" class="hover:text-[#f4b630] transition">Emergency Relief</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-lg mb-4">Get Involved</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="{{ route('sponsor.children') }}" class="hover:text-[#f4b630] transition">Sponsor a Child</a></li>
                    <li><a href="{{ route('sponsor.login') }}" class="hover:text-[#f4b630] transition">Donate</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-lg mb-4">Contact</h4>
                <ul class="space-y-3 text-sm text-gray-400">

                    @if(!empty($settings['contact_email']))
                    <li class="flex items-start gap-2">
                        <i class="fas fa-envelope text-[#f4b630] mt-1"></i>
                        <a href="mailto:{{ $settings['contact_email'] }}" class="hover:text-[#f4b630] transition">
                            {{ $settings['contact_email'] }}
                        </a>
                    </li>
                    @endif

                    @if(!empty($settings['contact_phone']))
                    <li class="flex items-start gap-2">
                        <i class="fas fa-phone text-[#f4b630] mt-1"></i>
                        <span>{{ $settings['contact_phone'] }}</span>
                    </li>
                    @endif

                    @if(!empty($settings['address']))
                    <li class="flex items-start gap-2">
                        <i class="fas fa-map-marker-alt text-[#f4b630] mt-1"></i>
                        <span>{{ $settings['address'] }}</span>
                    </li>
                    @endif

                </ul>
            </div>
        </div>

        <div class="pt-8 border-t border-gray-700 text-center text-sm text-gray-400">
            <p>
                © {{ date('Y') }} {{ $settings['site_name'] ?? 'Hope & Impact' }}. All rights reserved.
                | <a href="#" class="hover:text-[#f4b630]">Privacy Policy</a>
                | <a href="#" class="hover:text-[#f4b630]">Terms</a>
            </p>
        </div>
    </div>
</footer>