{{-- resources/views/pages/childhood/childrens-homes.blade.php --}}
@extends('layouts.app')

@section('title', "Soutien aux Maisons d'Enfants")
@section('content')
<style>
@keyframes fadeUp     { from{opacity:0;transform:translateY(32px)} to{opacity:1;transform:translateY(0)} }
@keyframes pulse-soft { 0%,100%{transform:scale(1)} 50%{transform:scale(1.04)} }
.reveal       {opacity:0;transform:translateY(28px); transition:opacity .65s cubic-bezier(.16,1,.3,1),transform .65s cubic-bezier(.16,1,.3,1)}
.reveal-left  {opacity:0;transform:translateX(-36px);transition:opacity .65s cubic-bezier(.16,1,.3,1),transform .65s cubic-bezier(.16,1,.3,1)}
.reveal-right {opacity:0;transform:translateX(36px); transition:opacity .65s cubic-bezier(.16,1,.3,1),transform .65s cubic-bezier(.16,1,.3,1)}
.reveal-scale {opacity:0;transform:scale(.93);       transition:opacity .65s cubic-bezier(.16,1,.3,1),transform .65s cubic-bezier(.16,1,.3,1)}
.reveal.visible,.reveal-left.visible,.reveal-right.visible,.reveal-scale.visible{opacity:1;transform:none}
.stagger-1{transition-delay:.05s}.stagger-2{transition-delay:.12s}.stagger-3{transition-delay:.19s}
.stagger-4{transition-delay:.26s}.stagger-5{transition-delay:.33s}.stagger-6{transition-delay:.40s}
.page-hero{position:relative;overflow:hidden;background:#1a1a1a;min-height:380px}
.page-hero-bg{position:absolute;inset:0;background-size:cover;background-position:center;filter:brightness(.45) saturate(1.1);transition:transform 8s ease}
.page-hero:hover .page-hero-bg{transform:scale(1.04)}
.page-hero-overlay{position:absolute;inset:0;background:linear-gradient(135deg,rgba(0,0,0,.65) 0%,rgba(0,0,0,.2) 60%,transparent 100%)}
.page-hero-content{position:relative;z-index:2;padding:80px 40px 72px;max-width:1280px;margin:0 auto}
.breadcrumb{display:flex;align-items:center;gap:8px;flex-wrap:wrap;font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:rgba(255,255,255,.6);margin-bottom:18px}
.breadcrumb a:hover{color:#fff}
.breadcrumb span{color:rgba(255,255,255,.9)}
.section-card{background:#fff;border-radius:20px;border:1px solid #f1f5f9;transition:transform .28s cubic-bezier(.16,1,.3,1),box-shadow .28s;overflow:hidden}
.section-card:hover{transform:translateY(-5px);box-shadow:0 20px 48px rgba(0,0,0,.10)}
.icon-badge{display:inline-flex;align-items:center;justify-content:center;border-radius:16px;flex-shrink:0}
.pill{display:inline-flex;align-items:center;gap:6px;padding:5px 14px;border-radius:999px;font-size:11px;font-weight:800;letter-spacing:.06em;text-transform:uppercase}
.wave-divider{line-height:0;overflow:hidden}.wave-divider svg{display:block}
.text-gradient{background:linear-gradient(135deg,#f97316 0%,#f59e0b 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.faq-body{max-height:0;transition:max-height .35s ease}
.faq-item.open .faq-body{max-height:600px}
.faq-item.open .faq-chevron{transform:rotate(180deg)}
.faq-chevron{transition:transform .3s ease}
@media(max-width:640px){.page-hero-content{padding:60px 20px 56px}}
</style>

<script>
(function(){
  /* ── Scroll-reveal ── */
  const o = new IntersectionObserver(e=>{
    e.forEach(x=>{ if(x.isIntersecting){ x.target.classList.add('visible'); o.unobserve(x.target) } })
  },{threshold:.08,rootMargin:'0px 0px -50px 0px'});
  document.addEventListener('DOMContentLoaded',()=>{
    document.querySelectorAll('.reveal,.reveal-left,.reveal-right,.reveal-scale').forEach(el=>o.observe(el));
    document.querySelectorAll('.faq-toggle').forEach(b=>{
      b.addEventListener('click',()=>{
        const i=b.closest('.faq-item');
        const w=i.classList.contains('open');
        document.querySelectorAll('.faq-item.open').forEach(x=>x.classList.remove('open'));
        if(!w)i.classList.add('open');
      });
    });

    /* ── Apply current language on load ── */
    const lang = localStorage.getItem('gt_lang') || 'fr';
    applyPageLang(lang);
  });

  /* ── Language switcher — called by global header switcher ── */
  window.applyPageLang = function(lang) {
    document.querySelectorAll('[data-fr],[data-en],[data-km]').forEach(el => {
      const val = el.getAttribute('data-' + lang);
      if (val !== null) el.textContent = val;
    });
  };
})();
</script>

{{-- ══════════════════════════════════════════
     HERO
══════════════════════════════════════════ --}}
<section class="page-hero" style="min-height:380px">
    <div class="page-hero-bg" style="background-image:url('{{ asset('images/cambodia-bg.jpg') }}')"></div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content">

        <nav class="breadcrumb">
            <a href="{{ route('home') }}"
               data-fr="Accueil"
               data-en="Home"
               data-km="ទំព័រដើម">Accueil</a>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span
               data-fr="Nos Actions"
               data-en="Our Actions"
               data-km="សកម្មភាពរបស់យើង">Nos Actions</span>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span
               data-fr="Enfance"
               data-en="Childhood"
               data-km="កុមារភាព">Enfance</span>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span translate="no"
               data-fr="Maisons d'Enfants"
               data-en="Children's Homes"
               data-km="មណ្ឌលកុមារ">Maisons d'Enfants</span>
        </nav>

        <div class="pill bg-orange-500/20 border border-orange-400/30 text-orange-300 mb-5" style="animation:fadeUp .7s ease both">
            <i class="fas fa-home text-xs"></i>
            <span data-fr="Maisons d'Enfants"
                  data-en="Children's Homes"
                  data-km="មណ្ឌលកុមារ">Maisons d'Enfants</span>
        </div>

        <h1 class="text-4xl md:text-5xl font-black text-white leading-tight mb-4" style="animation:fadeUp .9s ease both">
            <span data-fr="Soutien aux"
                  data-en="Support for"
                  data-km="ការគាំទ្រ">Soutien aux</span><br>
            <span class="text-gradient"
                  data-fr="Maisons d'Enfants"
                  data-en="Children's Homes"
                  data-km="មណ្ឌលកុមារ">Maisons d'Enfants</span>
        </h1>

        <p class="text-lg text-white/80 font-medium max-w-xl" style="animation:fadeUp .9s .15s ease both"
           data-fr="Renforcer les institutions qui offrent chaque jour un refuge sûr aux enfants vulnérables."
           data-en="Strengthening the institutions that give vulnerable children a safe haven every day."
           data-km="ពង្រឹងស្ថាប័នដែលផ្តល់ជម្រកសុវត្ថិភាពដល់កុមារងាយរងគ្រោះរៀងរាល់ថ្ងៃ។">
            Renforcer les institutions qui offrent chaque jour un refuge sûr aux enfants vulnérables.
        </p>

    </div>
</section>

<div class="wave-divider" style="background:#f9fafb">
    <svg viewBox="0 0 1440 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,30 C360,55 1080,5 1440,30 L1440,0 L0,0 Z" fill="#ffffff"/>
    </svg>
</div>

{{-- ══════════════════════════════════════════
     NOTRE SOUTIEN
══════════════════════════════════════════ --}}
<section class="section bg-white py-16 md:py-20">
    <div class="max-w-7xl mx-auto px-4">

        <div class="reveal mb-10">
            <div class="pill bg-orange-100 text-orange-600 mb-3">
                <i class="fas fa-home text-xs"></i>
                <span data-fr="Notre Soutien"
                      data-en="Our Support"
                      data-km="ការគាំទ្ររបស់យើង">Notre Soutien</span>
            </div>
            <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-2">
                <span data-fr="Comment nous soutenons les Maisons d'Enfants"
                      data-en="How We Support Children's Homes"
                      data-km="របៀបដែលយើងគាំទ្រមណ្ឌលកុមារ">Comment nous soutenons les Maisons d'Enfants</span>
            </h2>
            <div class="w-20 h-1 bg-orange-500 rounded-full"></div>
        </div>

        <div class="space-y-5 mb-16">

            {{-- Card 1 — Supporting Structures --}}
            <div class="section-card p-7 reveal stagger-1">
                <div class="flex items-start gap-5 mb-3">
                    <div class="icon-badge w-14 h-14 bg-orange-100 flex-shrink-0">
                        <i class="fas fa-hands-helping text-orange-500 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-black text-gray-900"
                        data-fr="Soutien aux Structures"
                        data-en="Supporting the Structures"
                        data-km="ការគាំទ្រដល់ស្ថាប័ន">Soutien aux Structures</h3>
                </div>
                <p class="text-gray-600 leading-relaxed"
                   data-fr="Les Maisons d'Enfants et les orphelinats jouent un rôle central dans la protection et l'accompagnement des enfants vulnérables. Des Ailes pour Grandir soutient ces institutions en travaillant étroitement avec leur personnel, en apportant conseils, suivi et assistance opérationnelle pour renforcer leur capacité à répondre aux besoins des enfants."
                   data-en="Children's homes and orphanages play a central role in protecting and supporting vulnerable children. Des Ailes pour Grandir supports these institutions by working closely with their staff, providing guidance, monitoring, and operational assistance to strengthen their capacity to meet children's needs."
                   data-km="មណ្ឌលកុមារ និងផ្ទះកុមារអនាថាដើរតួនាទីសំខាន់ក្នុងការការពារ និងជួយដល់កុមារងាយរងគ្រោះ។ Des Ailes pour Grandir គាំទ្រស្ថាប័នទាំងនេះដោយធ្វើការយ៉ាងជិតស្និទ្ធជាមួយបុគ្គលិករបស់ពួកគេ ដោយផ្តល់ការណែនាំ ការតាមដាន និងជំនួយប្រតិបត្តិការ ដើម្បីពង្រឹងសមត្ថភាពរបស់ពួកគេ។">
                    Les Maisons d'Enfants et les orphelinats jouent un rôle central dans la protection et l'accompagnement des enfants vulnérables. Des Ailes pour Grandir soutient ces institutions en travaillant étroitement avec leur personnel, en apportant conseils, suivi et assistance opérationnelle pour renforcer leur capacité à répondre aux besoins des enfants.
                </p>
            </div>

            {{-- Card 2 — Staff Training --}}
            <div class="section-card p-7 reveal stagger-2">
                <div class="flex items-center gap-3 mb-3">
                    <div class="icon-badge w-10 h-10 bg-blue-100 flex-shrink-0">
                        <i class="fas fa-chalkboard-teacher text-blue-500"></i>
                    </div>
                    <h3 class="text-lg font-black text-gray-900"
                        data-fr="Formation du Personnel"
                        data-en="Staff Training"
                        data-km="ការបណ្តុះបណ្តាលបុគ្គលិក">Formation du Personnel</h3>
                </div>
                <p class="text-gray-600 leading-relaxed"
                   data-fr="La qualité de la prise en charge est essentielle au bien-être et au développement des enfants. Nous finançons et organisons des formations pour le personnel afin d'améliorer leurs compétences en matière d'éducation, de protection de l'enfance, de santé et de soutien psychosocial."
                   data-en="The quality of care is essential for children's well-being and development. We fund and organize training for staff to improve their skills in education, child protection, health, and psychosocial support."
                   data-km="គុណភាពនៃការថែទាំគឺមានសារៈសំខាន់សម្រាប់សុខុមាលភាព និងការអភិវឌ្ឍន៍របស់កុមារ។ យើងផ្តល់ហិរញ្ញប្បទាន និងរៀបចំការបណ្តុះបណ្តាលសម្រាប់បុគ្គលិក ដើម្បីបង្កើនជំនាញរបស់ពួកគេ។">
                    La qualité de la prise en charge est essentielle au bien-être et au développement des enfants. Nous finançons et organisons des formations pour le personnel afin d'améliorer leurs compétences en matière d'éducation, de protection de l'enfance, de santé et de soutien psychosocial.
                </p>
            </div>

            {{-- Card 3 — Materials --}}
            <div class="section-card p-7 reveal stagger-3">
                <div class="flex items-center gap-3 mb-3">
                    <div class="icon-badge w-10 h-10 bg-green-100 flex-shrink-0">
                        <i class="fas fa-boxes text-green-500"></i>
                    </div>
                    <h3 class="text-lg font-black text-gray-900"
                        data-fr="Fourniture de Matériel et de Ressources"
                        data-en="Provision of Materials and Resources"
                        data-km="ការផ្តល់សម្ភារៈ និងធនធាន">Fourniture de Matériel et de Ressources</h3>
                </div>
                <p class="text-gray-600 leading-relaxed"
                   data-fr="Un environnement bien équipé et adapté est crucial pour le développement des enfants. Des Ailes pour Grandir fournit du matériel pédagogique, des équipements sanitaires et des ressources essentielles, garantissant un cadre sûr, stimulant et confortable pour les enfants."
                   data-en="A well-equipped and suitable environment is crucial for children's development. Des Ailes pour Grandir provides educational materials, sanitation equipment, and essential resources, ensuring a safe, stimulating, and comfortable setting for children."
                   data-km="បរិស្ថានដែលបំពាក់ល្អ និងសមស្រប គឺមានសារៈសំខាន់សម្រាប់ការអភិវឌ្ឍន៍របស់កុមារ។ Des Ailes pour Grandir ផ្តល់សម្ភារៈអប់រំ ឧបករណ៍អនាម័យ និងធនធានចាំបាច់ ធានាបរិស្ថានសុវត្ថិភាព ជំរុញ និងស្រួលស្បើយសម្រាប់កុមារ។">
                    Un environnement bien équipé et adapté est crucial pour le développement des enfants. Des Ailes pour Grandir fournit du matériel pédagogique, des équipements sanitaires et des ressources essentielles, garantissant un cadre sûr, stimulant et confortable pour les enfants.
                </p>
            </div>

            {{-- Card 4 — Well-being --}}
            <div class="section-card p-7 reveal stagger-4">
                <div class="flex items-center gap-3 mb-3">
                    <div class="icon-badge w-10 h-10 bg-purple-100 flex-shrink-0">
                        <i class="fas fa-heart text-purple-500"></i>
                    </div>
                    <h3 class="text-lg font-black text-gray-900"
                        data-fr="Amélioration du Bien-être des Enfants"
                        data-en="Enhancing Children's Well-being"
                        data-km="ការលើកកម្ពស់សុខុមាលភាពកុមារ">Amélioration du Bien-être des Enfants</h3>
                </div>
                <p class="text-gray-600 leading-relaxed"
                   data-fr="Au-delà du soutien matériel et éducatif, notre travail avec les Maisons d'Enfants vise à créer un environnement protecteur, chaleureux et bienveillant où chaque enfant peut grandir en sécurité, développer ses compétences et s'épanouir pleinement."
                   data-en="Beyond material and educational support, our work with children's homes aims to create a protective, warm, and caring environment where each child can grow safely, develop skills, and thrive fully."
                   data-km="លើសពីការគាំទ្រផ្នែកសម្ភារៈ និងការអប់រំ ការងាររបស់យើងជាមួយមណ្ឌលកុមារ មានគោលបំណងបង្កើតបរិស្ថានការពារ ក្តៅក្រហាយ និងយកចិត្តទុកដាក់ ដែលកុមារម្នាក់ៗអាចលូតលាស់ដោយសុវត្ថិភាព។">
                    Au-delà du soutien matériel et éducatif, notre travail avec les Maisons d'Enfants vise à créer un environnement protecteur, chaleureux et bienveillant où chaque enfant peut grandir en sécurité, développer ses compétences et s'épanouir pleinement.
                </p>
            </div>

        </div>

        {{-- ── Locations ── --}}
        <div class="reveal mb-6">
            <div class="pill bg-orange-100 text-orange-600 mb-3">
                <i class="fas fa-map-marker-alt text-xs"></i>
                <span data-fr="Nos Emplacements"
                      data-en="Our Locations"
                      data-km="ទីតាំងរបស់យើង">Nos Emplacements</span>
            </div>
            <h2 class="text-2xl font-black text-gray-900 mb-8">
                <span data-fr="Nos Maisons d'Enfants au Cambodge"
                      data-en="Our Children's Homes in Cambodia"
                      data-km="មណ្ឌលកុមាររបស់យើងនៅកម្ពុជា">Nos Maisons d'Enfants au Cambodge</span>
            </h2>
        </div>

        @php
        $homes = [
            [
                'city'    => 'Kampong Cham',
                'icon'    => 'fas fa-water',
                'desc_fr' => "Une ville dynamique sur le fleuve Mékong — notre foyer y soutient les enfants des communautés environnantes en matière d'éducation, de santé et de soins quotidiens.",
                'desc_en' => "A vibrant city on the Mekong River — our home here supports children in the surrounding communities with education, healthcare, and daily care.",
                'desc_km' => "ក្រុងដ៏រស់រវើកនៅលើទន្លេមេគង្គ — មណ្ឌលរបស់យើងនៅទីនេះគាំទ្រកុមារនៅក្នុងសហគមន៍ជិតខាង ក្នុងការអប់រំ សុខភាព និងការថែទាំប្រចាំថ្ងៃ។",
            ],
            [
                'city'    => 'Kampot',
                'icon'    => 'fas fa-mountain',
                'desc_fr' => "Dans cette paisible ville au bord de la rivière, notre foyer offre un refuge sûr aux enfants les plus vulnérables de la région, avec une prise en charge résidentielle complète.",
                'desc_en' => "In this peaceful riverside town, our home provides a safe haven for the most vulnerable children of the region with full-time residential care and support.",
                'desc_km' => "នៅក្នុងក្រុងដ៏សន្តិស្ងប់ជាប់ទន្លេ មណ្ឌលរបស់យើងផ្តល់ជម្រកសុវត្ថិភាពដល់កុមារងាយរងគ្រោះជាងគេបំផុតក្នុងតំបន់ ជាមួយការថែទាំលំនៅឋានពេញម៉ោង។",
            ],
        ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($homes as $i => $home)
            <div class="section-card bg-gradient-to-br from-orange-50 to-amber-50 border border-orange-100 p-8 reveal stagger-{{ $i+1 }}">
                <div class="flex items-start gap-5 mb-5">
                    <div class="icon-badge w-14 h-14 bg-orange-500 text-white shadow-lg shadow-orange-200">
                        <i class="{{ $home['icon'] }} text-xl"></i>
                    </div>
                    <div>
                        <p class="text-xs font-black text-orange-400 uppercase tracking-wider mb-1"
                           data-fr="Foyer pour Enfants"
                           data-en="Children's Home"
                           data-km="មណ្ឌលកុមារ">Foyer pour Enfants</p>
                        <h3 class="text-2xl font-black text-gray-900" translate="no">{{ $home['city'] }}</h3>
                    </div>
                </div>
                <p class="text-sm text-gray-600 leading-relaxed mb-6"
                   data-fr="{{ $home['desc_fr'] }}"
                   data-en="{{ $home['desc_en'] }}"
                   data-km="{{ $home['desc_km'] }}">{{ $home['desc_fr'] }}</p>
                <a href="#" class="inline-flex items-center gap-2 px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-black rounded-xl transition shadow-md shadow-green-200">
                    <i class="fas fa-eye text-sm"></i>
                    <span data-fr="Découvrir ce Foyer"
                          data-en="Discover This Home"
                          data-km="រកស្វែងយល់មណ្ឌលនេះ">Découvrir ce Foyer</span>
                </a>
            </div>
            @endforeach
        </div>

    </div>
</section>

<div class="wave-divider" style="background:#ffffff">
    <svg viewBox="0 0 1440 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,30 C360,5 1080,55 1440,30 L1440,50 L0,50 Z" fill="#ffffff"/>
    </svg>
</div>

{{-- ══════════════════════════════════════════
     CTA BANNER
══════════════════════════════════════════ --}}
<section class="section bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="bg-gradient-to-r from-orange-500 via-orange-500 to-amber-500 rounded-3xl p-10 md:p-14 relative overflow-hidden reveal">
            <div class="absolute inset-0 opacity-10" style="background-image:url('{{ asset('images/cambodia-bg.jpg') }}');background-size:cover;"></div>
            <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-8">
                <div class="text-white text-center lg:text-left">
                    <h2 class="text-3xl md:text-4xl font-black mb-3"
                        data-fr="Agissez Aujourd'hui"
                        data-en="Make a Difference Today"
                        data-km="ធ្វើសកម្មភាពថ្ងៃនេះ">Agissez Aujourd'hui</h2>
                    <p class="text-white/85 text-lg max-w-xl"
                       data-fr="Votre soutien finance des programmes comme celui-ci."
                       data-en="Your support funds programs like this one."
                       data-km="ការគាំទ្ររបស់អ្នកផ្តល់ហិរញ្ញប្បទានដល់កម្មវិធីដូចនេះ។">
                        Votre soutien finance des programmes comme celui-ci.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 flex-shrink-0">
                    <a href="{{ route('sponsor.children') }}"
                       class="inline-flex items-center gap-3 px-8 py-4 bg-white text-orange-600 font-black rounded-xl hover:bg-orange-50 transition shadow-lg justify-center">
                        <i class="fas fa-heart"></i>
                        <span data-fr="Parrainer un Enfant"
                              data-en="Sponsor a Child"
                              data-km="ឧបត្ថម្ភកុមារ">Parrainer un Enfant</span>
                    </a>
                    <a href="{{ route('support.donate') }}"
                       class="inline-flex items-center gap-3 px-8 py-4 border-2 border-white/50 text-white font-black rounded-xl hover:bg-white/10 transition justify-center">
                        <i class="fas fa-hand-holding-heart"></i>
                        <span data-fr="Faire un Don"
                              data-en="Make a Donation"
                              data-km="ធ្វើការបរិច្ចាគ">Faire un Don</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection