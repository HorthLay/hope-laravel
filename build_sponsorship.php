<?php
$newsFile = '/Applications/XAMPP/xamppfiles/htdocs/laravel/hope-laravel/resources/views/sponsor/news.blade.php';
$newsContent = file_get_contents($newsFile);

// Extract top part up to the end of header include
$headerPos = strpos($newsContent, "@include('sponsor.layouts.header')") + strlen("@include('sponsor.layouts.header')");
$top = substr($newsContent, 0, $headerPos);

// Extract bottom part from the closing script down
$scriptPos = strpos($newsContent, "<script>\nconst DLANG");
$bottom = substr($newsContent, $scriptPos);

$body = <<<'HTML'

@php
    $children = $sponsor->children->sortByDesc(fn($c) => $c->pivot->created_at)->values();
    $families = $sponsor->families->sortByDesc(fn($f) => $f->pivot->created_at)->values();
    $hasActiveSponsorship = $children->count() > 0 || $families->count() > 0;
@endphp

<div class="pw" style="max-width: 960px; margin: 0 auto; padding-top: 48px;">
    
    {{-- ══════════ HERO SECTION ══════════ --}}
    <div style="background: linear-gradient(135deg, var(--brand) 0%, #ea580c 100%); border-radius: 24px; padding: 40px 48px; display: flex; align-items: center; justify-content: space-between; gap: 32px; margin-bottom: 48px; box-shadow: 0 20px 40px rgba(234,88,12,.2); position: relative; overflow: hidden;" class="anim-up">
        <div style="position: absolute; right: -50px; top: -100px; width: 300px; height: 300px; background: radial-gradient(circle, rgba(255,255,255,0.15), transparent 70%); border-radius: 50%;"></div>
        <div style="position: absolute; left: 20%; bottom: -150px; width: 250px; height: 250px; background: radial-gradient(circle, rgba(255,255,255,0.1), transparent 70%); border-radius: 50%;"></div>
        
        <div style="position: relative; z-index: 1;">
            <div style="display: inline-flex; align-items: center; justify-content: center; width: 56px; height: 56px; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25); border-radius: 16px; margin-bottom: 20px;">
                <i class="fas fa-hand-holding-heart" style="color: #fff; font-size: 24px;"></i>
            </div>
            <h1 style="color: #fff; font-family: 'Lora', serif; font-size: 40px; font-weight: 700; margin-bottom: 12px; line-height: 1.1;">Sponsorship Details</h1>
            <p style="color: rgba(255,255,255,0.9); font-size: 16px; max-width: 500px; line-height: 1.6;">Thank you for being a vital part of our mission, {{ $sponsor->first_name }}. Here you can view and manage the details of the children and families you support.</p>
        </div>
        
        <div style="position: relative; z-index: 1; display: flex; flex-direction: column; gap: 12px; min-width: 200px;">
            <a href="{{ route('support.donate') }}" style="background: #fff; color: var(--brand); font-weight: 800; padding: 14px 24px; border-radius: 12px; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 8px 24px rgba(0,0,0,0.1); transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 12px 28px rgba(0,0,0,0.15)'" onmouseout="this.style.transform='none';this.style.boxShadow='0 8px 24px rgba(0,0,0,0.1)'">
                <i class="fas fa-plus-circle"></i> Add Sponsorship
            </a>
        </div>
    </div>

    @if($hasActiveSponsorship)
        {{-- ══════════ SPONSORED CHILDREN ══════════ --}}
        @if($children->count() > 0)
        <div class="anim-up" style="animation-delay: 0.1s; margin-bottom: 48px;">
            <h2 style="font-family: 'Lora', serif; font-size: 24px; font-weight: 700; color: var(--dark); margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-child" style="color: var(--brand);"></i> Sponsored Children
                <span style="font-size: 13px; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; background: var(--brand-lt); color: var(--brand); padding: 4px 12px; border-radius: 999px;">{{ $children->count() }}</span>
            </h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px;">
                @foreach($children as $child)
                <div style="background: #fff; border-radius: 20px; border: 1px solid var(--border); overflow: hidden; box-shadow: var(--card-sh); transition: transform 0.3s, box-shadow 0.3s; display: flex; flex-direction: column;" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='var(--card-sh2)'" onmouseout="this.style.transform='none';this.style.boxShadow='var(--card-sh)'">
                    <div style="height: 180px; position: relative;">
                        @if($child->profile_photo)
                            <img src="{{ $child->profile_photo_url }}" alt="{{ $child->first_name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, var(--brand-lt), #fde9b8); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-child" style="font-size: 48px; color: var(--brand);"></i>
                            </div>
                        @endif
                        <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 80px; background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);"></div>
                        <div style="position: absolute; bottom: 16px; left: 24px;">
                            <h3 style="color: #fff; font-family: 'Lora', serif; font-size: 22px; font-weight: 700; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">{{ $child->first_name }} {{ $child->last_name }}</h3>
                        </div>
                    </div>
                    <div style="padding: 24px; flex: 1; display: flex; flex-direction: column;">
                        <div style="display: flex; gap: 12px; margin-bottom: 24px;">
                            <span style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 700; color: var(--brand); background: var(--brand-lt); padding: 4px 12px; border-radius: 8px;">
                                <i class="fas fa-birthday-cake"></i> {{ $child->date_of_birth ? \Carbon\Carbon::parse($child->date_of_birth)->age . ' yrs' : 'N/A' }}
                            </span>
                            @if($child->country)
                            <span style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 700; color: #4b5563; background: #f3f4f6; padding: 4px 12px; border-radius: 8px;">
                                <i class="fas fa-map-marker-alt"></i> {{ $child->country }}
                            </span>
                            @endif
                        </div>
                        
                        <div style="margin-top: auto; border-top: 1px dashed var(--border); padding-top: 16px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                                <span style="font-size: 13px; color: var(--muted); font-weight: 500;">Start Date</span>
                                <span style="font-size: 13px; font-weight: 700; color: var(--dark);">{{ $child->pivot->created_at ? $child->pivot->created_at->format('M d, Y') : '—' }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="font-size: 13px; color: var(--muted); font-weight: 500;">Monthly Amount</span>
                                <span style="font-size: 13px; font-weight: 700; color: var(--brand);">As arranged</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ══════════ SPONSORED FAMILIES ══════════ --}}
        @if($families->count() > 0)
        <div class="anim-up" style="animation-delay: 0.2s; margin-bottom: 48px;">
            <h2 style="font-family: 'Lora', serif; font-size: 24px; font-weight: 700; color: var(--dark); margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-house-user" style="color: #2563eb;"></i> Sponsored Families
                <span style="font-size: 13px; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; background: #dbeafe; color: #2563eb; padding: 4px 12px; border-radius: 999px;">{{ $families->count() }}</span>
            </h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px;">
                @foreach($families as $family)
                <div style="background: #fff; border-radius: 20px; border: 1px solid var(--border); overflow: hidden; box-shadow: var(--card-sh); transition: transform 0.3s, box-shadow 0.3s; display: flex; flex-direction: column;" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='var(--card-sh2)'" onmouseout="this.style.transform='none';this.style.boxShadow='var(--card-sh)'">
                    <div style="height: 180px; position: relative;">
                        @if($family->profile_photo)
                            <img src="{{ $family->profile_photo_url }}" alt="{{ $family->name }} Family" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #dbeafe, #bfdbfe); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-house-user" style="font-size: 48px; color: #2563eb;"></i>
                            </div>
                        @endif
                        <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 80px; background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);"></div>
                        <div style="position: absolute; bottom: 16px; left: 24px;">
                            <h3 style="color: #fff; font-family: 'Lora', serif; font-size: 22px; font-weight: 700; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">{{ $family->name }} Family</h3>
                        </div>
                    </div>
                    <div style="padding: 24px; flex: 1; display: flex; flex-direction: column;">
                        <div style="display: flex; gap: 12px; margin-bottom: 24px;">
                            <span style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 700; color: #2563eb; background: #dbeafe; padding: 4px 12px; border-radius: 8px;">
                                <i class="fas fa-users"></i> {{ $family->members ? $family->members->count() : 'Unknown' }} Members
                            </span>
                            @if($family->country)
                            <span style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 700; color: #4b5563; background: #f3f4f6; padding: 4px 12px; border-radius: 8px;">
                                <i class="fas fa-map-marker-alt"></i> {{ $family->country }}
                            </span>
                            @endif
                        </div>
                        
                        <div style="margin-top: auto; border-top: 1px dashed var(--border); padding-top: 16px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                                <span style="font-size: 13px; color: var(--muted); font-weight: 500;">Start Date</span>
                                <span style="font-size: 13px; font-weight: 700; color: var(--dark);">{{ $family->pivot->created_at ? $family->pivot->created_at->format('M d, Y') : '—' }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="font-size: 13px; color: var(--muted); font-weight: 500;">Monthly Amount</span>
                                <span style="font-size: 13px; font-weight: 700; color: #2563eb;">As arranged</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    @else
        {{-- ══════════ NO ACTIVE SPONSORSHIPS ══════════ --}}
        <div class="anim-up" style="animation-delay: 0.1s; text-align: center; padding: 80px 24px; background: #fff; border-radius: 24px; border: 1px dashed #d1d5db; margin-bottom: 48px;">
            <div style="width: 80px; height: 80px; background: #f3f4f6; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 24px;">
                <i class="fas fa-box-open" style="font-size: 32px; color: #9ca3af;"></i>
            </div>
            <h2 style="font-family: 'Lora', serif; font-size: 28px; font-weight: 700; color: var(--dark); margin-bottom: 16px;">No Active Sponsorships</h2>
            <p style="font-size: 16px; color: var(--muted); max-width: 500px; margin: 0 auto 32px; line-height: 1.6;">You are not currently sponsoring any families or children. Explore our families and children in need and make a lasting impact today.</p>
            <a href="{{ route('support.donate') }}" style="display: inline-flex; align-items: center; gap: 8px; padding: 14px 32px; background: var(--brand); color: #fff; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 16px; box-shadow: 0 8px 24px rgba(239, 125, 0, 0.25); transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 12px 28px rgba(239, 125, 0, 0.35)'" onmouseout="this.style.transform='none';this.style.boxShadow='0 8px 24px rgba(239, 125, 0, 0.25)'">
                Become a Sponsor <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    @endif
</div>

@include('sponsor.layouts.nav')

HTML;

file_put_contents('/Applications/XAMPP/xamppfiles/htdocs/laravel/hope-laravel/resources/views/sponsor/sponsorship.blade.php', $top . "\n" . $body . "\n" . $bottom);
echo "Sponsorship page correctly formatted.\n";
