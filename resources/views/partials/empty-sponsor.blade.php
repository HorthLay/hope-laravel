<div class="w-full py-16 px-4 flex flex-col items-center justify-center text-center scroll-animate">
    <div class="max-w-2xl mx-auto">
        {{-- Icon --}}
        <div class="relative w-24 h-24 mx-auto mb-6">
            <div class="w-24 h-24 rounded-full bg-orange-100 flex items-center justify-center">
                <i class="fas fa-newspaper text-4xl text-orange-300"></i>
            </div>
            <div class="absolute -bottom-1 -right-1 w-8 h-8 rounded-full bg-orange-500 flex items-center justify-center shadow">
                <i class="fas fa-plus text-white text-sm font-bold"></i>
            </div>
        </div>

        <h3 class="text-xl md:text-2xl font-bold text-gray-700 mb-2">No Articles Yet</h3>
        <p class="text-gray-500 text-sm md:text-base mb-8 max-w-md mx-auto">
            Stories are being prepared. In the meantime, consider sponsoring a child and making a direct impact today.
        </p>

        {{-- Sponsor nudge --}}
        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl p-6 md:p-8 border border-orange-200 max-w-lg mx-auto">
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-full bg-orange-500 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-child text-white text-xl"></i>
                </div>
                <div class="text-left">
                    <p class="font-black text-gray-900 text-lg leading-tight">Sponsor a Child Today</p>
                    <p class="text-orange-600 font-semibold text-sm">Change a life for just $1/day</p>
                </div>
            </div>
            <p class="text-sm text-gray-600 mb-5 leading-relaxed">
                While we prepare our latest stories, you can take immediate action. Your sponsorship provides
                <span class="font-semibold text-gray-800">education, meals, and hope</span> to children across Southeast Asia.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('detail') }}"
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold text-sm rounded-full transition shadow-md hover:shadow-lg">
                    <i class="fas fa-heart"></i> Sponsor Now
                </a>
                <a href="{{ route('learn-more') }}"
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 border-2 border-orange-400 text-orange-600 font-bold text-sm rounded-full hover:bg-orange-50 transition">
                    <i class="fas fa-info-circle"></i> Learn More
                </a>
            </div>
        </div>
    </div>
</div>