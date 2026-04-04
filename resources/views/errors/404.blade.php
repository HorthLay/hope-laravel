<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 — Page Not Found | Hope & Impact</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,600;1,700&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
    *{box-sizing:border-box;margin:0;padding:0;}
    :root{
        --gold:#fbbf24;--gold-d:#d97706;--ember:#f97316;
        --sky:#04091f;--navy:#0c1445;--ink:#1c1033;--muted:#64748b;
    }

    /* ── Keyframes ── */
    @keyframes twinkle   {0%,100%{opacity:.15;transform:scale(1)}50%{opacity:1;transform:scale(1.5)}}
    @keyframes float     {0%,100%{transform:translateY(0)}50%{transform:translateY(-16px)}}
    @keyframes ray       {0%,100%{opacity:.18;transform:scaleY(1)}50%{opacity:.52;transform:scaleY(1.12)}}
    @keyframes orb       {0%,100%{transform:translate(0,0)}50%{transform:translate(28px,-20px)}}
    @keyframes fadeUp    {from{opacity:0;transform:translateY(36px)}to{opacity:1;transform:translateY(0)}}
    @keyframes pulse     {0%,100%{box-shadow:0 0 0 0 rgba(251,191,36,.5)}70%{box-shadow:0 0 0 16px rgba(251,191,36,0)}}
    @keyframes shimmer   {from{left:-100%}to{left:200%}}
    @keyframes scanline  {0%{top:-100%}100%{top:200%}}
    @keyframes glitch1   {0%,95%,100%{clip-path:none;transform:none}96%{clip-path:inset(20% 0 60% 0);transform:translateX(-4px)}98%{clip-path:inset(60% 0 10% 0);transform:translateX(4px)}}
    @keyframes glitch2   {0%,93%,100%{clip-path:none;transform:none;opacity:0}94%{clip-path:inset(40% 0 40% 0);transform:translateX(6px);opacity:.4}96%{clip-path:inset(10% 0 70% 0);transform:translateX(-6px);opacity:.4}}
    @keyframes childFloat{0%,100%{transform:translateY(0) rotate(-1deg) scale(1)}50%{transform:translateY(-14px) rotate(1deg) scale(1.02)}}
    @keyframes countDown {0%{stroke-dashoffset:0}100%{stroke-dashoffset:440}}
    @keyframes fadeIn    {from{opacity:0}to{opacity:1}}
    @keyframes slideIn   {from{opacity:0;transform:translateX(-20px)}to{opacity:1;transform:translateX(0)}}

    html,body{height:100%;width:100%;}

    /* ── Full page ── */
    .page{
        min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;
        position:relative;overflow:hidden;
        background:radial-gradient(ellipse at 50% 110%,#1a0a3d 0%,#0c1445 40%,#04091f 100%);
    }

    /* ── Star canvas ── */
    #c{position:absolute;inset:0;z-index:0;pointer-events:none;}

    /* ── Dawn glow ── */
    .glow{
        position:absolute;bottom:-100px;left:50%;transform:translateX(-50%);
        width:900px;height:400px;border-radius:50%;
        background:radial-gradient(ellipse,rgba(251,191,36,.18) 0%,rgba(249,115,22,.08) 40%,transparent 70%);
        z-index:1;pointer-events:none;animation:orb 9s ease-in-out infinite;
    }

    /* ── Rays ── */
    .rays{position:absolute;bottom:0;left:50%;transform:translateX(-50%);z-index:1;width:100%;pointer-events:none;}
    .ray{position:absolute;bottom:0;width:2px;border-radius:999px;transform-origin:bottom center;animation:ray 3s ease-in-out infinite;}

    /* ── Content ── */
    .inner{
        position:relative;z-index:3;
        display:flex;flex-direction:column;align-items:center;
        text-align:center;padding:40px 20px 60px;
        max-width:700px;width:100%;
    }

    /* ── Floating child silhouette ── */
    .child-wrap{
        width:120px;height:120px;
        border-radius:50%;overflow:hidden;
        border:3px solid rgba(251,191,36,.3);
        box-shadow:0 0 0 8px rgba(251,191,36,.06),0 0 48px rgba(251,191,36,.2);
        margin-bottom:32px;
        animation:childFloat 5s ease-in-out infinite;
        flex-shrink:0;
        position:relative;
    }
    .child-wrap img{width:100%;height:100%;object-fit:cover;filter:saturate(.7) brightness(.85);}
    .child-wrap::after{
        content:'';position:absolute;inset:0;
        background:linear-gradient(135deg,rgba(251,191,36,.1),transparent);
        border-radius:50%;
    }

    /* Scanline effect over image */
    .child-wrap .scanline{
        position:absolute;left:0;right:0;height:2px;
        background:rgba(251,191,36,.15);
        animation:scanline 3s linear infinite;
        pointer-events:none;
    }

    /* ── 404 glitch number ── */
    .num-wrap{position:relative;margin-bottom:16px;}
    .num{
        font-family:'Cormorant Garamond',serif;
        font-size:clamp(7rem,20vw,14rem);
        font-weight:700;line-height:1;
        color:transparent;
        -webkit-text-stroke:1.5px rgba(251,191,36,.35);
        letter-spacing:-.04em;
        animation:fadeUp .7s ease both;
        position:relative;
        user-select:none;
    }
    /* Gold gradient fill */
    .num-fill{
        position:absolute;inset:0;
        font-family:'Cormorant Garamond',serif;
        font-size:clamp(7rem,20vw,14rem);
        font-weight:700;line-height:1;
        letter-spacing:-.04em;
        background:linear-gradient(135deg,#fde68a 0%,#fbbf24 40%,#f97316 80%,#ea580c 100%);
        -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
        filter:drop-shadow(0 0 40px rgba(251,191,36,.5));
        animation:glitch1 8s ease-in-out infinite;
    }
    /* Glitch ghost */
    .num-ghost{
        position:absolute;inset:0;
        font-family:'Cormorant Garamond',serif;
        font-size:clamp(7rem,20vw,14rem);
        font-weight:700;line-height:1;
        letter-spacing:-.04em;
        color:rgba(249,115,22,.25);
        animation:glitch2 8s ease-in-out infinite;
        pointer-events:none;
    }

    /* ── Text ── */
    .tag{
        display:inline-flex;align-items:center;gap:7px;
        padding:7px 18px;border-radius:999px;
        background:rgba(251,191,36,.08);border:1px solid rgba(251,191,36,.22);
        font-family:'Outfit',sans-serif;font-size:10px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;
        color:var(--gold);margin-bottom:20px;
        animation:fadeUp .7s .1s ease both;
    }
    .tag-dot{width:6px;height:6px;border-radius:50%;background:var(--gold);animation:pulse 2s ease-in-out infinite;}

    .headline{
        font-family:'Cormorant Garamond',serif;
        font-size:clamp(1.6rem,5vw,2.8rem);
        font-weight:700;color:#fff;
        line-height:1.15;letter-spacing:-.02em;margin-bottom:14px;
        animation:fadeUp .7s .18s ease both;
    }
    .headline em{
        font-style:italic;
        background:linear-gradient(135deg,#fde68a,#fbbf24,#f97316);
        -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
    }

    .sub{
        font-family:'Outfit',sans-serif;font-size:.975rem;
        color:rgba(255,255,255,.45);line-height:1.82;
        max-width:440px;margin:0 auto 36px;
        animation:fadeUp .7s .26s ease both;
    }

    /* ── Buttons ── */
    .btns{display:flex;gap:12px;flex-wrap:wrap;justify-content:center;animation:fadeUp .7s .34s ease both;}

    .btn-home{
        display:inline-flex;align-items:center;gap:9px;
        padding:15px 30px;border-radius:14px;
        background:linear-gradient(135deg,#fbbf24,#f97316);
        color:#1c1033;font-family:'Outfit',sans-serif;font-size:.9rem;font-weight:800;
        text-decoration:none;
        box-shadow:0 8px 28px rgba(251,191,36,.35);
        transition:transform .22s,box-shadow .22s;
        position:relative;overflow:hidden;
    }
    .btn-home::after{content:'';position:absolute;top:0;bottom:0;left:-100%;width:60%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.2),transparent);transition:none;}
    .btn-home:hover::after{animation:shimmer .6s ease both;}
    .btn-home:hover{transform:translateY(-3px);box-shadow:0 16px 44px rgba(251,191,36,.5);color:#1c1033;}

    .btn-back{
        display:inline-flex;align-items:center;gap:9px;
        padding:15px 30px;border-radius:14px;
        background:rgba(255,255,255,.05);border:1.5px solid rgba(251,191,36,.25);
        color:rgba(255,255,255,.7);font-family:'Outfit',sans-serif;font-size:.9rem;font-weight:700;
        text-decoration:none;cursor:pointer;
        transition:background .2s,border-color .2s,color .2s;
    }
    .btn-back:hover{background:rgba(251,191,36,.1);border-color:rgba(251,191,36,.5);color:#fff;}

    /* ── Quick links ── */
    .links{
        display:flex;gap:8px;flex-wrap:wrap;justify-content:center;
        margin-top:40px;
        animation:fadeUp .7s .42s ease both;
    }
    .link-pill{
        display:inline-flex;align-items:center;gap:6px;
        padding:7px 14px;border-radius:999px;
        border:1px solid rgba(255,255,255,.08);
        background:rgba(255,255,255,.04);
        font-family:'Outfit',sans-serif;font-size:11px;font-weight:600;
        color:rgba(255,255,255,.5);text-decoration:none;
        transition:background .2s,border-color .2s,color .2s,transform .2s;
    }
    .link-pill:hover{
        background:rgba(251,191,36,.1);border-color:rgba(251,191,36,.35);
        color:rgba(255,255,255,.9);transform:translateY(-2px);
    }
    .link-pill i{font-size:9px;color:rgba(251,191,36,.6);}

    /* ── Footer note ── */
    .foot{
        position:absolute;bottom:20px;left:50%;transform:translateX(-50%);
        font-family:'Outfit',sans-serif;font-size:11px;color:rgba(255,255,255,.18);
        white-space:nowrap;z-index:3;
        animation:fadeIn 1s 1s ease both;opacity:0;
    }

    /* Responsive */
    @media(max-width:480px){
        .inner{padding:28px 16px 48px;}
        .child-wrap{width:88px;height:88px;}
        .btns{flex-direction:column;align-items:center;}
        .btn-home,.btn-back{width:100%;max-width:280px;justify-content:center;}
    }
    </style>
</head>
<body>
<div class="page">
    <canvas id="c"></canvas>
    <div class="glow"></div>
    <div class="rays" id="raysEl"></div>

    <div class="inner">

        {{-- Floating child photo --}}
        <div class="child-wrap">
            <img src="{{ asset('images/logo-no.png') }}" alt="Child">
            <div class="scanline"></div>
        </div>

        {{-- Glitch 404 --}}
        <div class="num-wrap">
            <div class="num">404</div>
            <div class="num-fill">404</div>
            <div class="num-ghost">404</div>
        </div>

        {{-- Label --}}
        <div class="tag">
            <div class="tag-dot"></div> Page Not Found
        </div>

        {{-- Headline --}}
        <h1 class="headline">
            You seem <em>lost</em> —<br>but children still need you
        </h1>

        {{-- Subtext --}}
        <p class="sub">
            The page you're looking for doesn't exist or has been moved. Let's get you back on track — there are children in Cambodia waiting for your support.
        </p>

        {{-- Buttons --}}
        <div class="btns">
            <a href="{{ route('home') }}" class="btn-home">
                <i class="fas fa-house"></i> Back to Home
            </a>
            <button onclick="history.back()" class="btn-back">
                <i class="fas fa-arrow-left"></i> Go Back
            </button>
        </div>

        {{-- Quick links --}}
        <div class="links">
            <a href="{{ route('sponsor.children') }}" class="link-pill">
                <i class="fas fa-heart"></i> Sponsor a Child
            </a>
            <a href="{{ route('support.donate') }}" class="link-pill">
                <i class="fas fa-hand-holding-heart"></i> Donate
            </a>
            <a href="{{ route('childhood.homes') }}" class="link-pill">
                <i class="fas fa-home"></i> Children's Homes
            </a>
            <a href="{{ route('support.fundraiser') }}" class="link-pill">
                <i class="fas fa-bullhorn"></i> Fundraise
            </a>
        </div>

    </div>

    <div class="foot">Hope & Impact · Des Ailes pour Grandir · Cambodia</div>
</div>

<script>
/* ── Stars ── */
(function(){
    var c=document.getElementById('c'),ctx=c.getContext('2d'),W,H,stars=[],shots=[];
    function resize(){W=c.width=window.innerWidth;H=c.height=window.innerHeight;}
    window.addEventListener('resize',resize);resize();
    for(var i=0;i<260;i++) stars.push({x:Math.random()*100,y:Math.random()*100,r:Math.random()*1.4+.2,s:Math.random()*2+1,p:Math.random()*Math.PI*2,warm:Math.random()<.2});
    function spawn(){shots.push({x:Math.random()*W*.65+W*.1,y:Math.random()*H*.5,vx:(Math.random()*4+3)*(Math.random()<.5?1:-1),vy:Math.random()*2+.5,life:1,decay:Math.random()*.014+.008,len:Math.random()*90+40});}
    setInterval(spawn,1800);setTimeout(spawn,300);setTimeout(spawn,900);
    var t=0;
    function draw(){
        ctx.clearRect(0,0,W,H);
        stars.forEach(function(p){
            var a=.1+.9*(Math.sin(t*p.s*.02+p.p)+1)*.5;
            ctx.beginPath();ctx.arc(p.x/100*W,p.y/100*H,p.r,0,Math.PI*2);
            ctx.fillStyle=p.warm?'rgba(251,191,36,'+a*.9+')':'rgba(255,255,255,'+a*.65+')';ctx.fill();
            if(p.r>1.1){var g=ctx.createRadialGradient(p.x/100*W,p.y/100*H,0,p.x/100*W,p.y/100*H,p.r*4);g.addColorStop(0,p.warm?'rgba(251,191,36,'+(a*.2)+')':'rgba(255,255,255,'+(a*.1)+')');g.addColorStop(1,'transparent');ctx.beginPath();ctx.arc(p.x/100*W,p.y/100*H,p.r*4,0,Math.PI*2);ctx.fillStyle=g;ctx.fill();}
        });
        shots=shots.filter(function(s){
            s.life-=s.decay;s.x+=s.vx;s.y+=s.vy;if(s.life<=0)return false;
            var g=ctx.createLinearGradient(s.x,s.y,s.x-s.vx*9,s.y-s.vy*9);
            g.addColorStop(0,'rgba(251,191,36,'+s.life*.95+')');g.addColorStop(.35,'rgba(255,220,100,'+s.life*.4+')');g.addColorStop(1,'transparent');
            ctx.beginPath();ctx.moveTo(s.x,s.y);ctx.lineTo(s.x-s.vx*(s.len/10),s.y-s.vy*(s.len/10));ctx.strokeStyle=g;ctx.lineWidth=s.life*2.8;ctx.lineCap='round';ctx.stroke();return true;
        });
        t++;requestAnimationFrame(draw);
    }
    draw();
})();

/* ── Rays ── */
(function(){
    var w=document.getElementById('raysEl');
    for(var i=0;i<16;i++){
        var r=document.createElement('div');r.className='ray';
        var angle=(i/15)*80-40,h=160+Math.random()*240,op=.06+Math.random()*.14,delay=Math.random()*3;
        r.style.cssText='left:calc(50%+'+angle+'px);height:'+h+'px;opacity:'+op+';animation-delay:'+delay+'s;animation-duration:'+(2.2+Math.random()*2.5)+'s;transform:rotate('+angle*.55+'deg);background:linear-gradient(to top,rgba(251,191,36,.45),transparent)';
        w.appendChild(r);
    }
})();
</script>
</body>
</html>