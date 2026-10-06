<?php
// ---------- Settings: edit these ----------
const BRAND        = 'Darsafar';
const EMAIL        = 'darasafar@gmail.com';
const WA_NUMBER    = '91XXXXXXXXXX'; // country code + number, digits only. Example: 919876543210
const CURRENCY     = '₹';

// ---------- Packages (same data as init.sql) ----------
$packages = [
  ['Kashmir Snow Escape',      'Gulmarg, Kashmir',     '2026-12-15', '5 Days / 4 Nights', 28999, 18, 'Experience the snow-covered mountains, winter landscapes and unforgettable beauty of Gulmarg.',                 'https://images.unsplash.com/photo-1605649487212-4dcb18a2bc72?auto=format&fit=crop&w=800&q=80'],
  ['Dal Lake Dream',           'Srinagar, Kashmir',    '2026-11-20', '4 Days / 3 Nights', 19999, 24, 'Enjoy the beauty of Srinagar with a peaceful Shikara experience on the iconic Dal Lake.',                     'https://images.unsplash.com/photo-1595815771614-ade9d652a65d?auto=format&fit=crop&w=800&q=80'],
  ['Pahalgam Valley Retreat',  'Pahalgam, Kashmir',    '2026-12-05', '5 Days / 4 Nights', 24999, 15, 'Explore the peaceful valleys, rivers and breathtaking mountain scenery of Pahalgam.',                         'https://images.unsplash.com/photo-1626244498304-a1309dffefae?auto=format&fit=crop&w=800&q=80'],
  ['Sonamarg Winter Escape',   'Sonamarg, Kashmir',    '2026-12-22', '4 Days / 3 Nights', 23999, 16, 'Discover the golden meadows, snowy mountains and spectacular Himalayan landscapes of Sonamarg.',                'https://images.unsplash.com/photo-1610214643330-84c1f1ec76d1?auto=format&fit=crop&w=800&q=80'],
  ['Doodhpathri Valley Retreat','Doodhpathri, Kashmir','2027-01-08', '4 Days / 3 Nights', 21999, 20, 'Escape into the peaceful meadows, pine forests and beautiful streams of Doodhpathri.',                        'https://images.unsplash.com/photo-1593693397690-362bb9a11542?auto=format&fit=crop&w=800&q=80'],
  ['Gurez Valley Expedition',  'Gurez Valley, Kashmir','2027-01-18', '6 Days / 5 Nights', 32999, 12, 'Journey through the dramatic mountains, traditional villages and breathtaking landscapes of Gurez Valley.',      'https://images.unsplash.com/photo-1627915570081-0076a0d4c944?auto=format&fit=crop&w=800&q=80'],
];
$keys = ['name','dest','date','duration','price','seats','desc','img'];
$packages = array_map(fn($p) => array_combine($keys, $p), $packages);

// Distinct fallback colours shown if an online image fails to load
$fallbacks = [
  ['#2b4a6b','#9fc4e0'], ['#1f5c63','#7fd0c7'], ['#2f5a3a','#a5d08a'],
  ['#6b5a2b','#e6c77a'], ['#27503f','#8cc7a5'], ['#3b3f63','#a7abd8'],
];

// Wikipedia page titles used to fetch a real photo of each place when the direct image link fails
$wikiTitles = [
  ['Gulmarg','Gulmarg Gondola'],
  ['Dal Lake','Srinagar'],
  ['Pahalgam','Lidder River'],
  ['Sonamarg','Thajiwas Glacier'],
  ['Doodhpathri','Budgam district'],
  ['Gurez','Gurez Valley','Habba Khatoon'],
];

function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function wa_link($text) { return 'https://wa.me/' . WA_NUMBER . '?text=' . rawurlencode($text); }
function money($n) { return CURRENCY . number_format($n); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e(BRAND) ?> – Kashmir Travel Packages</title>
<meta name="description" content="<?= e(BRAND) ?> plans Kashmir trips to Gulmarg, Srinagar, Pahalgam, Sonamarg, Doodhpathri and Gurez Valley.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,700&family=Hanken+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
:root{
  --night:#0d1513;
  --night-2:#131f1c;
  --paper:#f7f5f0;
  --ink:#1a1f1e;
  --muted:#6d7673;
  --glacier:#1fa7a3;
  --saffron:#e9a23b;
  --wa:#25d366;
  --wa-dark:#075e54;
  --display:'Fraunces',Georgia,serif;
  --body:'Hanken Grotesk',system-ui,sans-serif;
  --card-w:300px;
}
*{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{font-family:var(--body);background:var(--night);color:#e9efec;line-height:1.55;overflow-x:hidden}
a{color:inherit;text-decoration:none}
:focus-visible{outline:3px solid var(--saffron);outline-offset:3px;border-radius:6px}
img{display:block;max-width:100%}

/* contour-line backdrop */
.backdrop{position:fixed;inset:0;z-index:-1;background:
  radial-gradient(ellipse at 50% 30%,#1b2e29 0%,transparent 60%),
  radial-gradient(ellipse at 15% 90%,#2a2116 0%,transparent 45%),
  var(--night)}
.backdrop svg{position:absolute;inset:0;width:100%;height:100%;opacity:.16}

/* header */
header{position:sticky;top:0;z-index:50;background:rgba(13,21,19,.78);backdrop-filter:blur(12px);border-bottom:1px solid rgba(255,255,255,.07)}
.nav{max-width:1180px;margin:auto;padding:14px 24px;display:flex;align-items:center;justify-content:space-between;gap:16px}
.logo{font-family:var(--display);font-weight:700;font-size:1.6rem;letter-spacing:.01em;display:flex;align-items:center;gap:10px}
.logo i{width:30px;height:30px;border-radius:9px;background:linear-gradient(135deg,var(--glacier),var(--saffron));display:grid;place-items:center}
.logo i svg{width:17px;height:17px}
.nav ul{display:flex;gap:28px;list-style:none;font-weight:500;font-size:.95rem;color:#c5d0cc}
.nav ul a:hover{color:#fff}
.btn{display:inline-flex;align-items:center;gap:8px;padding:11px 20px;border-radius:999px;font-weight:600;font-size:.95rem;border:0;cursor:pointer;font-family:inherit}
.btn-wa{background:var(--wa);color:#04331d}
.btn-wa:hover{filter:brightness(1.07)}
.btn-ghost{background:rgba(255,255,255,.08);color:#fff;border:1px solid rgba(255,255,255,.16)}
.btn-ghost:hover{background:rgba(255,255,255,.14)}

/* hero */
.hero{max-width:1180px;margin:auto;padding:64px 24px 0;text-align:center}
.hero h1{font-family:var(--display);font-weight:700;font-size:clamp(2.3rem,5.4vw,4.4rem);line-height:1.05;letter-spacing:-.01em;max-width:15ch;margin:0 auto 18px}
.hero p{max-width:52ch;margin:0 auto;color:#aebbb6;font-size:1.08rem}


/* hero photo background */
.hero-wrap{position:relative;padding-bottom:30px;overflow:hidden}
.hero-bg{position:absolute;inset:0;z-index:0;background:linear-gradient(160deg,#16373a,#0d1513 70%);opacity:1}
.hero-bg i{position:absolute;inset:0;background-size:cover;background-position:center 50%;opacity:0;transition:opacity 1.2s ease}
.hero-bg i.on{opacity:1}
.hero-bg::after{content:"";position:absolute;inset:0;background:
  linear-gradient(180deg,rgba(13,21,19,.55) 0%,rgba(13,21,19,.25) 30%,rgba(13,21,19,.55) 65%,var(--night) 100%)}
.hero-wrap>*:not(.hero-bg){position:relative;z-index:1}
.hero h1{text-shadow:0 4px 30px rgba(0,0,0,.45)}
.hero p{color:#e2ebe7;text-shadow:0 2px 14px rgba(0,0,0,.5)}

/* floating card stage */
.stage{position:relative;height:620px;margin-top:34px;perspective:1400px}
.card{position:absolute;left:50%;top:40px;width:var(--card-w);margin-left:calc(var(--card-w) / -2);
  transition:transform .7s cubic-bezier(.22,.8,.24,1),opacity .5s,filter .5s;cursor:pointer;will-change:transform}
.card-in{background:#fff;color:var(--ink);border-radius:26px;padding:10px 10px 18px;
  box-shadow:0 30px 60px -20px rgba(0,0,0,.65),0 8px 20px rgba(0,0,0,.25);text-align:left}
.card.active .card-in{animation:float 6s ease-in-out infinite}
@keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-12px)}}
.card.side{filter:brightness(.72) saturate(.9)}
.photo{position:relative;height:210px;border-radius:18px;overflow:hidden;background:var(--fb)}
.photo img{width:100%;height:100%;object-fit:cover}
.photo .tag{position:absolute;left:10px;top:10px;background:rgba(13,21,19,.7);backdrop-filter:blur(6px);color:#fff;font-size:.78rem;font-weight:600;padding:5px 11px;border-radius:999px}
.card-body{padding:16px 10px 0}
.card h3{font-family:var(--display);font-size:1.32rem;line-height:1.15;font-weight:700}
.loc{display:flex;align-items:center;gap:6px;color:var(--muted);font-size:.86rem;margin:6px 0 10px}
.loc svg{width:14px;height:14px;flex:none}
.card p.d{font-size:.84rem;color:#4b5451;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;min-height:3.9em}
.stats{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin:14px 0 4px;padding-top:12px;border-top:1px solid #ebe8e1}
.stats span{display:block;font-size:.72rem;color:var(--muted)}
.stats b{font-size:.95rem;color:var(--glacier);font-weight:700}
.foot{display:flex;align-items:flex-end;justify-content:space-between;margin-top:12px}
.foot small{display:block;color:var(--muted);font-size:.74rem}
.foot strong{font-size:1.5rem;font-weight:700;letter-spacing:-.01em}
.fly{width:50px;height:50px;border-radius:50%;background:var(--ink);color:#fff;display:grid;place-items:center;transition:transform .2s,background .2s}
.fly:hover{background:var(--glacier);transform:scale(1.08)}
.fly svg{width:22px;height:22px}

.controls{display:flex;justify-content:center;align-items:center;gap:18px;margin-top:6px}
.arrow{width:46px;height:46px;border-radius:50%;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.18);color:#fff;cursor:pointer;display:grid;place-items:center}
.arrow:hover{background:rgba(255,255,255,.16)}
.arrow svg{width:20px;height:20px}
.dots{display:flex;gap:8px}
.dots button{width:9px;height:9px;border-radius:99px;border:0;background:rgba(255,255,255,.28);cursor:pointer;transition:width .3s,background .3s}
.dots button.on{width:28px;background:var(--saffron)}

/* sections */
section{max-width:1180px;margin:auto;padding:96px 24px 0}
.sec-head{display:flex;justify-content:space-between;align-items:end;gap:20px;flex-wrap:wrap;margin-bottom:34px}
.sec-head h2{font-family:var(--display);font-size:clamp(1.8rem,3.4vw,2.7rem);line-height:1.1;max-width:18ch}
.sec-head p{color:#aebbb6;max-width:42ch}
.grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:24px}
.tile{background:var(--night-2);border:1px solid rgba(255,255,255,.08);border-radius:22px;overflow:hidden;display:flex;flex-direction:column}
.tile .photo{height:200px;border-radius:0}
.tile-b{padding:20px;display:flex;flex-direction:column;gap:10px;flex:1}
.tile h3{font-family:var(--display);font-size:1.25rem}
.tile p{color:#aebbb6;font-size:.92rem;flex:1}
.meta{display:flex;flex-wrap:wrap;gap:8px}
.meta span{font-size:.8rem;background:rgba(255,255,255,.07);padding:5px 11px;border-radius:999px;color:#d6e0dc}
.tile-f{display:flex;justify-content:space-between;align-items:center;margin-top:6px}
.tile-f strong{font-size:1.35rem}
.tile-f a{background:var(--wa);color:#04331d;font-weight:600;font-size:.88rem;padding:9px 16px;border-radius:999px}

.contact{background:linear-gradient(135deg,#123a37,#1b2d27 60%,#33260f);border-radius:28px;padding:56px 40px;display:grid;grid-template-columns:1.2fr 1fr;gap:36px;align-items:center;border:1px solid rgba(255,255,255,.08)}
.contact h2{font-family:var(--display);font-size:clamp(1.8rem,3.4vw,2.6rem);line-height:1.1;margin-bottom:12px}
.contact p{color:#c3d1cc;max-width:44ch}
.ways{display:grid;gap:14px}
.way{display:flex;align-items:center;gap:14px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.12);padding:16px 18px;border-radius:16px}
.way:hover{background:rgba(255,255,255,.12)}
.way svg{width:26px;height:26px;flex:none}
.way b{display:block;font-size:1rem}
.way span{font-size:.86rem;color:#b8c7c2}
footer{max-width:1180px;margin:auto;padding:70px 24px 40px;color:#8b9994;font-size:.88rem;display:flex;justify-content:space-between;gap:16px;flex-wrap:wrap}

/* whatsapp floating window */
.wa-fab{position:fixed;right:22px;bottom:22px;z-index:90;width:62px;height:62px;border-radius:50%;background:var(--wa);border:0;cursor:pointer;display:grid;place-items:center;box-shadow:0 12px 30px rgba(0,0,0,.45)}
.wa-fab svg{width:34px;height:34px}
.wa-win{position:fixed;right:22px;bottom:96px;z-index:90;width:340px;max-width:calc(100vw - 32px);border-radius:20px;overflow:hidden;background:#efeae2;color:var(--ink);
  box-shadow:0 30px 70px rgba(0,0,0,.55);transform-origin:bottom right;transform:scale(.6) translateY(30px);opacity:0;pointer-events:none;transition:transform .3s cubic-bezier(.22,.9,.3,1),opacity .25s}
.wa-win.open{transform:none;opacity:1;pointer-events:auto}
.wa-top{background:var(--wa-dark);color:#fff;padding:16px 18px;display:flex;align-items:center;gap:12px}
.wa-av{width:42px;height:42px;border-radius:50%;background:linear-gradient(135deg,var(--glacier),var(--saffron));display:grid;place-items:center;font-family:var(--display);font-weight:700;font-size:1.2rem}
.wa-top b{display:block;line-height:1.2}
.wa-top small{opacity:.85;font-size:.8rem}
.wa-x{margin-left:auto;background:none;border:0;color:#fff;font-size:1.5rem;cursor:pointer;line-height:1}
.wa-body{padding:18px;min-height:130px}
.bubble{background:#fff;padding:11px 14px;border-radius:0 14px 14px 14px;font-size:.92rem;max-width:88%;box-shadow:0 1px 1px rgba(0,0,0,.12)}
.wa-body select{margin-top:14px;width:100%;padding:10px 12px;border-radius:10px;border:1px solid #cfc8bb;background:#fff;font-family:inherit;font-size:.9rem}
.wa-form{display:flex;gap:8px;padding:12px;background:#f7f4ee}
.wa-form input{flex:1;padding:12px 14px;border-radius:999px;border:1px solid #d6d0c4;font-family:inherit;font-size:.92rem;min-width:0}
.wa-form button{width:44px;height:44px;border-radius:50%;border:0;background:var(--wa-dark);color:#fff;cursor:pointer;display:grid;place-items:center;flex:none}
.wa-form button svg{width:20px;height:20px}
.wa-mail{display:block;text-align:center;font-size:.82rem;color:#4b5451;padding:0 12px 14px;background:#f7f4ee}
.wa-mail a{color:var(--wa-dark);font-weight:600;text-decoration:underline}

@media (max-width:820px){
  .nav ul{display:none}
  .contact{grid-template-columns:1fr;padding:36px 24px}
  :root{--card-w:270px}
  .photo{height:180px}
  .stage{height:600px}
}
@media (prefers-reduced-motion:reduce){
  .card,.wa-win{transition:none}
  .card.active .card-in{animation:none}
  html{scroll-behavior:auto}
}

/* ================= Responsive polish (all screen sizes) ================= */
html{-webkit-text-size-adjust:100%}
.grid{grid-template-columns:repeat(auto-fill,minmax(min(100%,320px),1fr))}
.card,.tile,.contact{max-width:100%}
.wa-fab{right:max(22px,env(safe-area-inset-right));bottom:max(22px,env(safe-area-inset-bottom))}
.wa-win{right:max(22px,env(safe-area-inset-right));bottom:calc(max(22px,env(safe-area-inset-bottom)) + 74px);max-height:calc(100vh - 120px);overflow-y:auto}

/* Large desktops */
@media (min-width:1500px){
  :root{--card-w:330px}
  .stage{height:660px}
  .nav,.hero,section,footer{max-width:1320px}
}

/* Laptops and small desktops */
@media (max-width:1100px){
  .stage{height:600px}
  .nav ul{gap:20px}
}

/* Tablets */
@media (max-width:820px){
  .nav{padding:12px 18px}
  .hero{padding:44px 18px 0}
  .hero-bg i{background-position:center 30%}
  section{padding:72px 18px 0}
  .sec-head{margin-bottom:26px}
  .stage{height:590px}
  .contact{border-radius:22px}
  footer{padding:56px 18px 34px}
}

/* Phones */
@media (max-width:600px){
  :root{--card-w:260px}
  .logo{font-size:1.35rem}
  .logo i{width:26px;height:26px;border-radius:8px}
  .nav .btn{padding:9px 14px;font-size:.85rem}
  .hero{padding-top:34px}
  .hero p{font-size:1rem}
  .stage{height:575px;margin-top:22px}
  .photo{height:170px}
  .card-body{padding:14px 8px 0}
  .card h3{font-size:1.2rem}
  .foot strong{font-size:1.3rem}
  .fly{width:46px;height:46px}
  .arrow{width:42px;height:42px}
  .dots button{width:8px;height:8px}
  .dots button.on{width:22px}
  section{padding-top:60px}
  .tile .photo{height:190px}
  .contact{padding:28px 20px}
  .way{padding:14px}
  footer{flex-direction:column;text-align:center;align-items:center}
  .wa-fab{width:56px;height:56px}
  .wa-fab svg{width:30px;height:30px}
  .wa-win{width:calc(100vw - 28px);right:14px}
}

/* Very small phones */
@media (max-width:380px){
  :root{--card-w:236px}
  .nav .btn{display:none}
  .stage{height:555px}
  .photo{height:150px}
  .card p.d{-webkit-line-clamp:2;min-height:2.6em}
  .stats b{font-size:.85rem}
  .foot strong{font-size:1.2rem}
  .meta span{font-size:.75rem}
}

/* Short landscape phones */
@media (max-height:520px) and (orientation:landscape){
  .hero{padding-top:24px}
  .hero h1{font-size:2rem}
  .wa-win{max-height:calc(100vh - 100px)}
}

/* Touch devices: no hover-only effects needed */
@media (hover:none){
  .fly:hover{transform:none}
}
</style>
<script>
/* If a package photo fails to load, fetch a real photo of the place from Wikipedia */

/* Find good landscape photos on Wikimedia Commons (free to use) */
var PEOPLE = /\b(man|men|woman|women|people|person|persons|girl|girls|boy|boys|child|children|kid|kids|family|couple|tourist|tourists|visitor|visitors|crowd|group|portrait|selfie|vendor|seller|shopkeeper|farmer|farmers|worker|workers|pickers?|skier|skiers|skiing|snowboard\w*|wedding|bride|groom|dancers?|dance|musician|band|player|players|team|army|soldier|soldiers|police|minister|leader|chef|cook|cooking|eating|feast|diners?|guests?|standing|sitting|riding|walking|posing|tour|tours|festival|procession|protest|rally|pilgrims?|yatra)\b/i;
function commonsPhoto(query, minWidth){
  var url = 'https://commons.wikimedia.org/w/api.php?action=query&generator=search&gsrnamespace=6&gsrlimit=30'
    + '&gsrsearch=' + encodeURIComponent(query)
    + '&prop=imageinfo&iiprop=url|size|mime|extmetadata&iiurlwidth=1920&format=json&origin=*';
  return fetch(url).then(function(r){ return r.json(); }).then(function(d){
    var pages = d && d.query ? Object.values(d.query.pages) : [];
    pages.sort(function(a,b){ return a.index - b.index; });
    for (var i = 0; i < pages.length; i++){
      var ii = pages[i].imageinfo && pages[i].imageinfo[0];
      if (!ii || !/jpe?g/i.test(ii.mime)) continue;
      var em = ii.extmetadata || {};
      var text = (pages[i].title + ' ' + ((em.ImageDescription || {}).value || '') + ' ' + ((em.Categories || {}).value || '')).toLowerCase();
      if (PEOPLE.test(text)) continue;
      if (ii.width >= minWidth && ii.width >= ii.height * 1.25 && ii.thumburl) return ii.thumburl;
    }
    return null;
  }).catch(function(){ return null; });
}

var wikiCache = {};
function wikiImg(img){
  var list = [];
  try { list = JSON.parse(img.getAttribute('data-wiki') || '[]'); } catch (e) {}
  function next(){
    var t = list.shift();
    if (!t) { img.style.display = 'none'; return; }
    if (!wikiCache[t]) {
      wikiCache[t] = fetch('https://en.wikipedia.org/api/rest_v1/page/summary/' + encodeURIComponent(t))
        .then(function(r){ return r.ok ? r.json() : {}; })
        .catch(function(){ return {}; });
    }
    wikiCache[t].then(function(d){
      var src = d && d.thumbnail && d.thumbnail.source;
      if (!src) { next(); return; }
      img.onerror = next;
      img.style.display = '';
      img.src = src.replace(/\/\d+px-/, '/960px-');
    });
  }
  next();
}
</script>
</head>
<body>
<div class="backdrop" aria-hidden="true">
  <svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" viewBox="0 0 1200 800" fill="none" stroke="#c9a66b" stroke-width="1">
    <?php for ($i = 1; $i <= 9; $i++): ?>
    <ellipse cx="380" cy="300" rx="<?= 60 + $i * 70 ?>" ry="<?= 40 + $i * 46 ?>" transform="rotate(-14 380 300)"/>
    <ellipse cx="900" cy="560" rx="<?= 40 + $i * 58 ?>" ry="<?= 30 + $i * 38 ?>" transform="rotate(18 900 560)"/>
    <?php endfor; ?>
  </svg>
</div>

<header>
  <div class="nav">
    <a href="#top" class="logo" id="top">
      <i><svg viewBox="0 0 24 24" fill="#0d1513"><path d="M21 16v-2l-8-5V3.5a1.5 1.5 0 0 0-3 0V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L13 19v-5.5z"/></svg></i>
      <?= e(BRAND) ?>
    </a>
    <ul>
      <li><a href="#packages">Packages</a></li>
      <li><a href="#contact">Contact</a></li>
    </ul>
    <a class="btn btn-wa" href="<?= e(wa_link('Hello ' . BRAND . ', I want to plan a Kashmir trip.')) ?>" target="_blank" rel="noopener">Chat on WhatsApp</a>
  </div>
</header>

<main>
<div class="hero-wrap">
<div class="hero-bg" aria-hidden="true"><i id="heroImg"></i></div>
<div class="hero">
  <h1>Kashmir, planned for you</h1>
  <p>Snow in Gulmarg, shikaras on Dal Lake, quiet valleys in Pahalgam and Gurez. Pick a trip and we handle the rest.</p>
</div>

<!-- Floating cards -->
<div class="stage" id="stage" aria-roledescription="carousel" aria-label="Featured Kashmir packages">
<?php foreach ($packages as $i => $p): ?>
  <article class="card" data-i="<?= $i ?>" style="--fb:linear-gradient(135deg,<?= $fallbacks[$i][0] ?>,<?= $fallbacks[$i][1] ?>)">
    <div class="card-in">
      <div class="photo">
        <img src="<?= e($p['img']) ?>" alt="<?= e($p['name']) ?> in <?= e($p['dest']) ?>" loading="<?= $i < 3 ? 'eager' : 'lazy' ?>" referrerpolicy="no-referrer" data-wiki='<?= e(json_encode($wikiTitles[$i])) ?>' <?= $i === 0 ? 'data-place="gulmarg"' : '' ?> onerror="wikiImg(this)">
        <span class="tag"><?= e($p['duration']) ?></span>
      </div>
      <div class="card-body">
        <h3><?= e($p['name']) ?></h3>
        <div class="loc">
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a7 7 0 0 0-7 7c0 5.2 7 13 7 13s7-7.8 7-13a7 7 0 0 0-7-7zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5z"/></svg>
          <?= e($p['dest']) ?>
        </div>
        <p class="d"><?= e($p['desc']) ?></p>
        <div class="stats">
          <div><span>Departs</span><b><?= e(date('j M Y', strtotime($p['date']))) ?></b></div>
          <div><span>Nights</span><b><?= e(explode('/', $p['duration'])[1] ?? '') ?></b></div>
          <div><span>Seats left</span><b><?= (int)$p['seats'] ?></b></div>
        </div>
        <div class="foot">
          <div><small>Price per person</small><strong><?= e(money($p['price'])) ?></strong></div>
          <a class="fly" href="<?= e(wa_link("Hello " . BRAND . ", I'm interested in the " . $p['name'] . " (" . date('j M Y', strtotime($p['date'])) . ").")) ?>" target="_blank" rel="noopener" aria-label="Enquire about <?= e($p['name']) ?> on WhatsApp">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M21 16v-2l-8-5V3.5a1.5 1.5 0 0 0-3 0V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L13 19v-5.5z"/></svg>
          </a>
        </div>
      </div>
    </div>
  </article>
<?php endforeach; ?>
</div>

<div class="controls">
  <button class="arrow" id="prev" aria-label="Previous package"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M15 5l-7 7 7 7"/></svg></button>
  <div class="dots" id="dots"></div>
  <button class="arrow" id="next" aria-label="Next package"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5l7 7-7 7"/></svg></button>
</div>
</div><!-- /hero-wrap -->

<!-- All packages -->
<section id="packages">
  <div class="sec-head">
    <h2>Every trip we run this season</h2>
    <p>Dates, nights and seats are updated in our package list. Tap Enquire to ask about any trip on WhatsApp.</p>
  </div>
  <div class="grid">
  <?php foreach ($packages as $i => $p): ?>
    <div class="tile">
      <div class="photo" style="--fb:linear-gradient(135deg,<?= $fallbacks[$i][0] ?>,<?= $fallbacks[$i][1] ?>)">
        <img src="<?= e($p['img']) ?>" alt="<?= e($p['dest']) ?>" loading="lazy" referrerpolicy="no-referrer" data-wiki='<?= e(json_encode($wikiTitles[$i])) ?>' <?= $i === 0 ? 'data-place="gulmarg"' : '' ?> onerror="wikiImg(this)">
      </div>
      <div class="tile-b">
        <h3><?= e($p['name']) ?></h3>
        <div class="meta">
          <span><?= e($p['dest']) ?></span>
          <span><?= e($p['duration']) ?></span>
          <span><?= e(date('j M Y', strtotime($p['date']))) ?></span>
          <span><?= (int)$p['seats'] ?> seats left</span>
        </div>
        <p><?= e($p['desc']) ?></p>
        <div class="tile-f">
          <strong><?= e(money($p['price'])) ?></strong>
          <a href="<?= e(wa_link("Hello " . BRAND . ", I'm interested in the " . $p['name'] . ".")) ?>" target="_blank" rel="noopener">Enquire</a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
  </div>
</section>

<!-- Contact -->
<section id="contact">
  <div class="contact">
    <div>
      <h2>Tell us where you want to go</h2>
      <p>Send us your dates and group size. We'll reply with a plan and a final price.</p>
    </div>
    <div class="ways">
      <a class="way" href="<?= e(wa_link('Hello ' . BRAND . ', I want to plan a Kashmir trip.')) ?>" target="_blank" rel="noopener">
        <svg viewBox="0 0 32 32" fill="#25d366"><path d="M16 3a13 13 0 0 0-11 19.9L3 29l6.3-1.9A13 13 0 1 0 16 3zm0 23.6a10.6 10.6 0 0 1-5.4-1.5l-.4-.2-3.7 1.1 1.2-3.6-.3-.4A10.6 10.6 0 1 1 16 26.600zm5.800-7.900c-.3-.2-1.900-.9-2.200-1s-.5-.2-.7.2-.8 1-1 1.200-.4.200-.7.100a8.700 8.700 0 0 1-4.300-3.800c-.3-.6.300-.5.900-1.700.1-.2 0-.4 0-.5l-1-2.300c-.3-.6-.5-.5-.7-.5h-.6a1.200 1.200 0 0 0-.9.400 3.700 3.700 0 0 0-1.100 2.700 6.400 6.400 0 0 0 1.300 3.400 14.700 14.700 0 0 0 5.600 4.900c2.100.9 2.900 1 3.900.8a3.300 3.300 0 0 0 2.200-1.600 2.700 2.700 0 0 0 .2-1.600c-.1-.1-.3-.2-.6-.4z"/></svg>
        <div><b>WhatsApp</b><span>Chat with us directly</span></div>
      </a>
      <a class="way" href="mailto:<?= e(EMAIL) ?>?subject=<?= rawurlencode('Kashmir trip enquiry') ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="#e9a23b" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="3"/><path d="M4 7l8 6 8-6"/></svg>
        <div><b>Email</b><span><?= e(EMAIL) ?></span></div>
      </a>
    </div>
  </div>
</section>
</main>

<footer>
  <span>© <?= date('Y') ?> <?= e(BRAND) ?>. All rights reserved.</span>
  <span><a href="mailto:<?= e(EMAIL) ?>"><?= e(EMAIL) ?></a></span>
</footer>

<!-- WhatsApp floating window -->
<div class="wa-win" id="waWin" role="dialog" aria-label="Chat with <?= e(BRAND) ?> on WhatsApp">
  <div class="wa-top">
    <div class="wa-av">D</div>
    <div><b><?= e(BRAND) ?></b><small>Chat with our team</small></div>
    <button class="wa-x" id="waClose" aria-label="Close chat">&times;</button>
  </div>
  <div class="wa-body">
    <div class="bubble">Hello! Which Kashmir trip are you planning? Choose a package or type your question below.</div>
    <label class="sr-only" for="waPick" style="position:absolute;left:-9999px">Package</label>
    <select id="waPick">
      <option value="">Not sure yet</option>
      <?php foreach ($packages as $p): ?>
      <option value="<?= e($p['name']) ?>"><?= e($p['name']) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <form class="wa-form" id="waForm">
    <input id="waMsg" type="text" placeholder="Type your message" aria-label="Your message" autocomplete="off">
    <button type="submit" aria-label="Send on WhatsApp"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 20.5l18-8.5L3 3.500v6.600l12 1.900-12 1.900z"/></svg></button>
  </form>
  <span class="wa-mail">Prefer email? <a href="mailto:<?= e(EMAIL) ?>"><?= e(EMAIL) ?></a></span>
</div>
<button class="wa-fab" id="waFab" aria-label="Open WhatsApp chat" aria-expanded="false">
  <svg viewBox="0 0 32 32" fill="#fff"><path d="M16 3a13 13 0 0 0-11 19.9L3 29l6.3-1.9A13 13 0 1 0 16 3zm0 23.6a10.6 10.6 0 0 1-5.4-1.5l-.4-.2-3.7 1.1 1.2-3.6-.3-.4A10.6 10.6 0 1 1 16 26.600zm5.800-7.900c-.3-.2-1.900-.9-2.200-1s-.5-.2-.7.2-.8 1-1 1.200-.4.200-.7.100a8.700 8.700 0 0 1-4.300-3.800c-.3-.6.300-.5.900-1.700.1-.2 0-.4 0-.5l-1-2.300c-.3-.6-.5-.5-.7-.5h-.6a1.200 1.200 0 0 0-.9.400 3.700 3.700 0 0 0-1.100 2.700 6.400 6.400 0 0 0 1.300 3.400 14.700 14.700 0 0 0 5.600 4.900c2.100.9 2.900 1 3.900.8a3.300 3.300 0 0 0 2.200-1.600 2.700 2.700 0 0 0 .2-1.600c-.1-.1-.3-.2-.6-.4z"/></svg>
</button>

<script>
(function(){
  var cards = Array.prototype.slice.call(document.querySelectorAll('.card'));
  var n = cards.length, cur = 0, timer;
  var dots = document.getElementById('dots');
  cards.forEach(function(_, i){
    var b = document.createElement('button');
    b.setAttribute('aria-label', 'Show package ' + (i + 1));
    b.onclick = function(){ go(i); restart(); };
    dots.appendChild(b);
  });

  function cardW(){ return cards[0].offsetWidth; }
  function render(){
    var narrow = window.innerWidth < 820;
    var gap = cardW() * (narrow ? 0.62 : 0.86);
    cards.forEach(function(c, i){
      var o = ((i - cur) % n + n) % n;
      if (o > n / 2) o -= n;           // -3..2
      var a = Math.abs(o);
      var visible = narrow ? a <= 1 : a <= 2;
      var scale = a === 0 ? 1.06 : (a === 1 ? 0.88 : 0.74);
      var rot = o * -7;
      c.style.transform = 'translateX(' + (o * gap) + 'px) translateY(' + (a * 26) + 'px) scale(' + scale + ') rotateY(' + rot + 'deg)';
      c.style.zIndex = 10 - a;
      c.style.opacity = visible ? (a === 2 ? 0.7 : 1) : 0;
      c.style.pointerEvents = visible ? 'auto' : 'none';
      c.classList.toggle('active', a === 0);
      c.classList.toggle('side', a !== 0);
      c.setAttribute('aria-hidden', a === 0 ? 'false' : 'true');
    });
    Array.prototype.forEach.call(dots.children, function(d, i){ d.classList.toggle('on', i === cur); });
  }
  function go(i){ cur = (i % n + n) % n; render(); }
  function restart(){
    clearInterval(timer);
    if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) timer = setInterval(function(){ go(cur + 1); }, 5500);
  }
  cards.forEach(function(c, i){
    c.addEventListener('click', function(e){
      if (i !== cur && !e.target.closest('.fly')) { e.preventDefault(); go(i); restart(); }
    });
  });
  document.getElementById('prev').onclick = function(){ go(cur - 1); restart(); };
  document.getElementById('next').onclick = function(){ go(cur + 1); restart(); };
  document.getElementById('stage').addEventListener('mouseenter', function(){ clearInterval(timer); });
  document.getElementById('stage').addEventListener('mouseleave', restart);
  var sx = null, st = document.getElementById('stage');
  st.addEventListener('touchstart', function(e){ sx = e.touches[0].clientX; }, {passive:true});
  st.addEventListener('touchend', function(e){
    if (sx === null) return;
    var dx = e.changedTouches[0].clientX - sx;
    if (Math.abs(dx) > 40) { go(cur + (dx < 0 ? 1 : -1)); restart(); }
    sx = null;
  });
  window.addEventListener('resize', render);
  render(); restart();


  /* Hero background (nature) and snowy Gulmarg photo */
  /* Cover photo: Kashmir landscape from Wikimedia Commons, people filtered out */
  function preload(u, ok){ var im = new Image(); im.onload = function(){ ok(u); }; im.src = u; }
  var heroQueries = ['Dal Lake Srinagar landscape', 'Kashmir valley landscape', 'Pahalgam valley', 'Sonamarg meadow mountains', 'Gurez valley', 'Kashmir mountains lake', 'Chinar tree autumn Kashmir'];
  (function tryHero(q){
    if (!q.length) return;
    commonsPhoto(q.shift(), 1200).then(function(u){
      if (!u) return tryHero(q);
      preload(u, function(){
        var el = document.getElementById('heroImg');
        el.style.backgroundImage = 'url(' + u + ')';
        el.classList.add('on');
      });
    });
  })(heroQueries.slice());

  var snowQueries = ['Gulmarg snow', 'Gulmarg winter snow', 'Gulmarg meadow snow', 'Gulmarg Apharwat'];
  (function trySnow(q){
    if (!q.length) return;
    commonsPhoto(q.shift(), 1200).then(function(u){
      if (!u) return trySnow(q);
      preload(u, function(){
        document.querySelectorAll('[data-place="gulmarg"]').forEach(function(im){
          im.onerror = null; im.style.display = ''; im.src = u;
        });
      });
    });
  })(snowQueries.slice());

  /* WhatsApp window */
  var win = document.getElementById('waWin'), fab = document.getElementById('waFab');
  function toggle(open){
    win.classList.toggle('open', open);
    fab.setAttribute('aria-expanded', open);
    if (open) document.getElementById('waMsg').focus();
  }
  fab.onclick = function(){ toggle(!win.classList.contains('open')); };
  document.getElementById('waClose').onclick = function(){ toggle(false); };
  document.addEventListener('keydown', function(e){ if (e.key === 'Escape') toggle(false); });
  document.getElementById('waForm').addEventListener('submit', function(e){
    e.preventDefault();
    var pick = document.getElementById('waPick').value;
    var msg = document.getElementById('waMsg').value.trim();
    var text = 'Hello <?= e(BRAND) ?>' + (pick ? ', I am interested in the ' + pick + '.' : '.') + (msg ? ' ' + msg : '');
    window.open('https://wa.me/<?= e(WA_NUMBER) ?>?text=' + encodeURIComponent(text), '_blank', 'noopener');
  });
})();
</script>
</body>
</html>
