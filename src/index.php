<?php
// ---------- Settings: edit these ----------
const BRAND        = 'Dar-As-Safar';
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

// Muted fallback colours shown if an online image fails to load
$fallbacks = [
  ['#3a4a57','#a9b8c3'], ['#2f4a4c','#9db8b5'], ['#3b4d3f','#a9bba3'],
  ['#5a5238','#c4b88f'], ['#34493f','#9fb5a8'], ['#3f4259','#aeb1c6'],
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
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Hanken+Grotesk:wght@400;500;600&display=swap" rel="stylesheet">
<style>
:root{
  --paper:#fbfaf7;
  --white:#ffffff;
  --ink:#16221e;
  --ink-2:#3d4a45;
  --muted:#75807b;
  --line:#e2e0d9;
  --forest:#1f3a31;
  --gold:#8f7338;
  --wa:#25d366;
  --wa-dark:#075e54;
  --display:'Cormorant Garamond',Georgia,'Times New Roman',serif;
  --body:'Hanken Grotesk',system-ui,sans-serif;
}
*{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth;-webkit-text-size-adjust:100%}
body{font-family:var(--body);background:var(--paper);color:var(--ink);line-height:1.6;overflow-x:hidden}
a{color:inherit;text-decoration:none}
img{display:block;max-width:100%}
:focus-visible{outline:2px solid var(--gold);outline-offset:3px}
.wrap{max-width:1160px;margin:auto;padding:0 28px}

/* header */
header{position:sticky;top:0;z-index:50;background:rgba(251,250,247,.94);backdrop-filter:blur(8px);border-bottom:1px solid var(--line)}
.nav{display:flex;align-items:center;justify-content:space-between;gap:20px;height:72px}
.logo{font-family:var(--display);font-weight:700;font-size:1.75rem;letter-spacing:.01em;color:var(--forest)}
.nav ul{display:flex;gap:34px;list-style:none;font-size:.95rem;color:var(--ink-2)}
.nav ul a:hover{color:var(--gold)}
.btn{display:inline-block;padding:11px 24px;border-radius:2px;font-weight:500;font-size:.92rem;border:1px solid var(--forest);background:var(--forest);color:#fff;cursor:pointer;font-family:inherit;transition:background .2s,color .2s}
.btn:hover{background:transparent;color:var(--forest)}
.btn-light{background:#fff;color:var(--forest);border-color:#fff}
.btn-light:hover{background:transparent;color:#fff}

/* hero */
.hero{position:relative;color:#fff;background:linear-gradient(160deg,#2a4540,#16221e 70%)}
.hero-bg{position:absolute;inset:0;overflow:hidden}
.hero-bg i{position:absolute;inset:0;background-size:cover;background-position:center 45%;opacity:0;transition:opacity 1.2s ease}
.hero-bg i.on{opacity:1}
.hero-bg::after{content:"";position:absolute;inset:0;background:linear-gradient(90deg,rgba(14,24,21,.78) 0%,rgba(14,24,21,.5) 55%,rgba(14,24,21,.3) 100%)}
.hero .wrap{position:relative;z-index:1;padding-top:140px;padding-bottom:150px}
.hero h1{font-family:var(--display);font-weight:600;font-size:clamp(2.8rem,6vw,5rem);line-height:1.04;max-width:13ch;margin-bottom:22px}
.hero p{max-width:46ch;font-size:1.08rem;color:#e6ece9;margin-bottom:34px}
.hero-actions{display:flex;gap:14px;flex-wrap:wrap}
.btn-line{background:transparent;color:#fff;border-color:rgba(255,255,255,.6)}
.btn-line:hover{background:#fff;color:var(--forest)}

/* sections */
section{padding:96px 0 0}
.sec-head{max-width:560px;margin-bottom:48px}
.sec-head h2{font-family:var(--display);font-weight:600;font-size:clamp(2rem,3.6vw,2.8rem);line-height:1.1;color:var(--forest);margin-bottom:12px}
.sec-head p{color:var(--ink-2)}

/* packages */
.grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(min(100%,330px),1fr));gap:36px 30px}
.pkg{background:var(--white);border:1px solid var(--line);display:flex;flex-direction:column}
.photo{position:relative;aspect-ratio:4/3;overflow:hidden;background:var(--fb)}
.photo img{width:100%;height:100%;object-fit:cover}
.pkg-b{padding:24px 24px 22px;display:flex;flex-direction:column;flex:1}
.pkg h3{font-family:var(--display);font-weight:700;font-size:1.55rem;line-height:1.15;color:var(--forest)}
.loc{color:var(--gold);font-size:.9rem;font-weight:500;margin:4px 0 12px}
.pkg p.d{color:var(--ink-2);font-size:.92rem;margin-bottom:18px;flex:1}
dl{border-top:1px solid var(--line)}
dl div{display:flex;justify-content:space-between;gap:12px;padding:9px 0;border-bottom:1px solid var(--line);font-size:.9rem}
dt{color:var(--muted)}
dd{font-weight:500;text-align:right}
.pkg-f{display:flex;justify-content:space-between;align-items:center;margin-top:18px}
.price small{display:block;color:var(--muted);font-size:.78rem;line-height:1.2}
.price strong{font-family:var(--display);font-size:1.8rem;font-weight:700;color:var(--ink);line-height:1.1}
.enq{border:1px solid var(--forest);color:var(--forest);padding:9px 20px;font-size:.9rem;font-weight:500;border-radius:2px;transition:background .2s,color .2s}
.enq:hover{background:var(--forest);color:#fff}

/* contact */
.contact{display:grid;grid-template-columns:1.1fr 1fr;gap:48px;align-items:center;border-top:1px solid var(--line);padding-top:72px}
.contact h2{font-family:var(--display);font-weight:600;font-size:clamp(2rem,3.6vw,2.8rem);line-height:1.1;color:var(--forest);margin-bottom:12px}
.contact p{color:var(--ink-2);max-width:42ch}
.ways{display:grid;gap:0;border:1px solid var(--line);background:var(--white)}
.way{display:flex;align-items:center;gap:16px;padding:22px 24px}
.way+.way{border-top:1px solid var(--line)}
.way:hover{background:var(--paper)}
.way svg{width:24px;height:24px;flex:none}
.way b{display:block;font-weight:600}
.way span{font-size:.88rem;color:var(--muted)}
footer{padding:80px 0 40px;color:var(--muted);font-size:.88rem}
footer .wrap{display:flex;justify-content:space-between;gap:16px;flex-wrap:wrap;border-top:1px solid var(--line);padding-top:26px}
footer a:hover{color:var(--gold)}

/* whatsapp floating window */
.wa-fab{position:fixed;right:max(22px,env(safe-area-inset-right));bottom:max(22px,env(safe-area-inset-bottom));z-index:90;width:58px;height:58px;border-radius:50%;background:var(--wa);border:0;cursor:pointer;display:grid;place-items:center;box-shadow:0 8px 22px rgba(0,0,0,.25)}
.wa-fab svg{width:30px;height:30px}
.wa-win{position:fixed;right:max(22px,env(safe-area-inset-right));bottom:calc(max(22px,env(safe-area-inset-bottom)) + 72px);z-index:90;width:330px;max-width:calc(100vw - 28px);max-height:calc(100vh - 120px);overflow-y:auto;border-radius:6px;overflow:hidden;background:#efeae2;color:var(--ink);
  box-shadow:0 20px 50px rgba(0,0,0,.3);transform-origin:bottom right;transform:scale(.7) translateY(20px);opacity:0;pointer-events:none;transition:transform .25s ease,opacity .2s}
.wa-win.open{transform:none;opacity:1;pointer-events:auto}
.wa-top{background:var(--wa-dark);color:#fff;padding:14px 16px;display:flex;align-items:center;gap:12px}
.wa-av{width:38px;height:38px;border-radius:50%;background:#fff;color:var(--forest);display:grid;place-items:center;font-family:var(--display);font-weight:700;font-size:1.3rem}
.wa-top b{display:block;line-height:1.2}
.wa-top small{opacity:.85;font-size:.8rem}
.wa-x{margin-left:auto;background:none;border:0;color:#fff;font-size:1.5rem;cursor:pointer;line-height:1}
.wa-body{padding:16px;min-height:120px}
.bubble{background:#fff;padding:10px 13px;border-radius:0 10px 10px 10px;font-size:.92rem;max-width:90%;box-shadow:0 1px 1px rgba(0,0,0,.1)}
.wa-body select{margin-top:14px;width:100%;padding:10px 12px;border-radius:4px;border:1px solid #cfc8bb;background:#fff;font-family:inherit;font-size:.9rem}
.wa-form{display:flex;gap:8px;padding:12px;background:#f7f4ee}
.wa-form input{flex:1;padding:11px 14px;border-radius:999px;border:1px solid #d6d0c4;font-family:inherit;font-size:.92rem;min-width:0}
.wa-form button{width:42px;height:42px;border-radius:50%;border:0;background:var(--wa-dark);color:#fff;cursor:pointer;display:grid;place-items:center;flex:none}
.wa-form button svg{width:18px;height:18px}
.wa-mail{display:block;text-align:center;font-size:.82rem;color:var(--ink-2);padding:0 12px 14px;background:#f7f4ee}
.wa-mail a{color:var(--wa-dark);font-weight:600;text-decoration:underline}

@media (max-width:860px){
  .nav ul{display:none}
  .contact{grid-template-columns:1fr;gap:32px}
  .hero .wrap{padding-top:90px;padding-bottom:96px}
  section{padding-top:72px}
}
@media (max-width:560px){
  .wrap{padding:0 20px}
  .nav{height:64px}
  .logo{font-size:1.5rem}
  .nav .btn{padding:9px 14px;font-size:.85rem}
  .hero .wrap{padding-top:64px;padding-bottom:72px}
  .pkg-b{padding:20px}
  .wa-win{right:14px;width:calc(100vw - 28px)}
}
@media (max-width:360px){ .nav .btn{display:none} }
@media (prefers-reduced-motion:reduce){
  *{transition:none!important}
  html{scroll-behavior:auto}
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

<header>
  <div class="wrap nav">
    <a href="#top" class="logo" id="top"><?= e(BRAND) ?></a>
    <ul>
      <li><a href="#packages">Packages</a></li>
      <li><a href="#contact">Contact</a></li>
    </ul>
    <a class="btn" href="<?= e(wa_link('Hello ' . BRAND . ', I want to plan a Kashmir trip.')) ?>" target="_blank" rel="noopener">Chat on WhatsApp</a>
  </div>
</header>

<main>
<div class="hero">
  <div class="hero-bg" aria-hidden="true"><i id="heroImg"></i></div>
  <div class="wrap">
    <h1>Kashmir, planned for you</h1>
    <p>Snow in Gulmarg, shikaras on Dal Lake, quiet valleys in Pahalgam and Gurez. Pick a trip and we handle the rest.</p>
    <div class="hero-actions">
      <a class="btn btn-light" href="#packages">View packages</a>
      <a class="btn btn-line" href="<?= e(wa_link('Hello ' . BRAND . ', I want to plan a Kashmir trip.')) ?>" target="_blank" rel="noopener">Plan with us</a>
    </div>
  </div>
</div>

<!-- Packages -->
<section id="packages">
  <div class="wrap">
    <div class="sec-head">
      <h2>Every trip we run this season</h2>
      <p>Dates, nights and seats are updated in our package list. Tap Enquire to ask about any trip on WhatsApp.</p>
    </div>
    <div class="grid">
    <?php foreach ($packages as $i => $p): ?>
      <article class="pkg">
        <div class="photo" style="--fb:linear-gradient(135deg,<?= $fallbacks[$i][0] ?>,<?= $fallbacks[$i][1] ?>)">
          <img src="<?= e($p['img']) ?>" alt="<?= e($p['name']) ?> in <?= e($p['dest']) ?>" loading="<?= $i < 3 ? 'eager' : 'lazy' ?>" referrerpolicy="no-referrer" data-wiki='<?= e(json_encode($wikiTitles[$i])) ?>' <?= $i === 0 ? 'data-place="gulmarg"' : '' ?> onerror="wikiImg(this)">
        </div>
        <div class="pkg-b">
          <h3><?= e($p['name']) ?></h3>
          <div class="loc"><?= e($p['dest']) ?></div>
          <p class="d"><?= e($p['desc']) ?></p>
          <dl>
            <div><dt>Departs</dt><dd><?= e(date('j M Y', strtotime($p['date']))) ?></dd></div>
            <div><dt>Duration</dt><dd><?= e($p['duration']) ?></dd></div>
            <div><dt>Seats left</dt><dd><?= (int)$p['seats'] ?></dd></div>
          </dl>
          <div class="pkg-f">
            <div class="price"><small>Price per person</small><strong><?= e(money($p['price'])) ?></strong></div>
            <a class="enq" href="<?= e(wa_link("Hello " . BRAND . ", I'm interested in the " . $p['name'] . " (" . date('j M Y', strtotime($p['date'])) . ").")) ?>" target="_blank" rel="noopener" aria-label="Enquire about <?= e($p['name']) ?> on WhatsApp">Enquire</a>
          </div>
        </div>
      </article>
    <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Contact -->
<section id="contact">
  <div class="wrap">
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
          <svg viewBox="0 0 24 24" fill="none" stroke="#8f7338" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M4 7l8 6 8-6"/></svg>
          <div><b>Email</b><span><?= e(EMAIL) ?></span></div>
        </a>
      </div>
    </div>
  </div>
</section>
</main>

<footer>
  <div class="wrap">
    <span>© <?= date('Y') ?> <?= e(BRAND) ?>. All rights reserved.</span>
    <span><a href="mailto:<?= e(EMAIL) ?>"><?= e(EMAIL) ?></a></span>
  </div>
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
    <label for="waPick" style="position:absolute;left:-9999px">Package</label>
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
  function preload(u, ok){ var im = new Image(); im.onload = function(){ ok(u); }; im.src = u; }

  /* Cover photo: Kashmir landscape from Wikimedia Commons, people filtered out */
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

  /* Snowy Gulmarg photo for the first package */
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
