<?php
// TyCal Painters - index.php
// Put the logo at images/logo.png (the file you uploaded). Change $to to change the inbox.
$to = 'tycalpainters@gmail.com';
$status = isset($_GET['sent']) ? 'ok' : '';
$clean = fn($v) => trim(str_replace(["\r", "\n"], ' ', strip_tags((string)$v)));
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['website'])) { $status = 'ok'; }          // honeypot
    else {
        $n = $clean($_POST['n'] ?? ''); $p = $clean($_POST['p'] ?? '');
        $e = filter_var($_POST['e'] ?? '', FILTER_VALIDATE_EMAIL) ?: '';
        $t = $clean($_POST['t'] ?? 'General'); $m = trim(strip_tags($_POST['m'] ?? ''));
        if ($n === '' || ($p === '' && $e === '')) { $status = 'missing'; }
        else {
            $host = preg_replace('/[^a-z0-9.\-]/i', '', $_SERVER['HTTP_HOST'] ?? 'localhost');
            $h = "From: TyCal Website <no-reply@{$host}>\r\n";
            if ($e) $h .= "Reply-To: {$e}\r\n";
            $h .= "Content-Type: text/plain; charset=UTF-8\r\n";
            $b = "Name: {$n}\nPhone: {$p}\nEmail: {$e}\nJob: {$t}\n\n{$m}\n";
            if (mail($to, "Free quote request: {$t}", $b, $h)) {
                header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?') . '?sent=1#contact'); exit;
            }
            $status = 'fail';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en-GB">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="theme-color" content="#050608">
<title>TyCal Painters | Residential &amp; Commercial Painters, Dudley &amp; Worcestershire</title>
<meta name="description" content="TyCal Painters: clean, reliable, fairly priced residential and commercial painting in Dudley, Stourbridge, Kidderminster and across Staffordshire and Worcestershire. Free quotes.">
<link rel="icon" type="image/png" href="images/logo-trim.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,500;1,800;1,900&amp;family=Manrope:wght@400;500;700&amp;display=swap" rel="stylesheet">
<style>
:root{--bg:#050608;--panel:#0d1017;--line:rgba(255,255,255,.12);--tx:#E9EEF5;--mut:#98A3B3;--blue:#1E9BFF;--org:#FF8A00;--lime:#7CD100;box-sizing:border-box;padding-top:env(safe-area-inset-top,0);padding-bottom:env(safe-area-inset-bottom,0)}
*,*::before,*::after{box-sizing:inherit}
html{scroll-behavior:smooth;scroll-padding-top:80px;overflow-x:hidden}
body{margin:0;background:var(--bg);color:var(--tx);font:400 17px/1.6 'Manrope','Helvetica Neue',Arial,sans-serif;overflow-x:hidden;-webkit-font-smoothing:antialiased}
a{color:inherit}
:focus-visible{outline:3px solid var(--blue);outline-offset:3px}
.wrap{max-width:1180px;margin:0 auto;padding:0 24px}
h1,h2,h3{font-family:'Exo 2','Arial Black',sans-serif;font-style:italic;font-weight:900;line-height:1;margin:0;letter-spacing:-.01em}
.chrome{background:linear-gradient(180deg,#fff 0%,#c9d3e0 55%,#8794a6 100%);-webkit-background-clip:text;background-clip:text;color:transparent}
.ic{width:1em;height:1em;flex:none;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;vertical-align:-.14em}
.rv{opacity:0;transform:translateY(28px);transition:opacity .7s ease,transform .7s cubic-bezier(.2,.65,.3,1);transition-delay:var(--d,0s)}
.rv.l{transform:translateX(-34px)}
.rv.r{transform:translateX(34px)}
.rv.z{transform:scale(.95)}
.rv.in{opacity:1;transform:none}
.progress{position:fixed;top:0;left:0;height:3px;width:100%;z-index:70;transform:scaleX(0);transform-origin:0 50%;background:linear-gradient(90deg,var(--org),var(--lime),var(--blue));pointer-events:none}

/* header */
header.top{position:fixed;inset:0 0 auto 0;z-index:50;background:rgba(5,6,8,.82);backdrop-filter:blur(12px);border-bottom:1px solid var(--line);transition:background .3s,box-shadow .3s}
header.top.scrolled{background:rgba(5,6,8,.95);box-shadow:0 14px 40px rgba(0,0,0,.5)}
header.top .wrap{display:flex;align-items:center;justify-content:space-between;gap:16px;height:68px;transition:height .3s cubic-bezier(.2,.7,.3,1)}
header.top.scrolled .wrap{height:58px}
.logo{display:block;width:140px;flex:none;transition:width .3s}
.logo img{display:block;width:100%;height:auto}
header.top.scrolled .logo{width:116px}
.links{display:flex;gap:20px;font-weight:700;font-size:15px}
.links a{position:relative;display:inline-flex;align-items:center;gap:8px;text-decoration:none;color:var(--mut);transition:color .2s}
.links a .ic{width:16px;height:16px;color:var(--blue);opacity:.85;transition:transform .25s,opacity .25s}
.links a::after{content:"";position:absolute;left:0;right:0;bottom:-6px;height:2px;border-radius:2px;background:linear-gradient(90deg,var(--org),var(--blue));transform:scaleX(0);transform-origin:0 50%;transition:transform .3s}
.links a:hover{color:#fff}
.links a:hover .ic{opacity:1;transform:translateY(-2px)}
.links a.active{color:#fff}
.links a.active .ic{opacity:1}
.links a.active::after{transform:scaleX(1)}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:10px;padding:14px 26px;border-radius:99px;font:700 16px 'Manrope',sans-serif;text-decoration:none;border:1.5px solid var(--line);color:var(--tx);background:transparent;cursor:pointer;transition:transform .2s,box-shadow .25s}
.btn:hover{transform:translateY(-2px)}
.btn.go{background:linear-gradient(135deg,#39b0ff,#1170e6);border-color:transparent;color:#fff;box-shadow:0 8px 28px rgba(30,155,255,.35)}
.btn.go:hover{box-shadow:0 12px 36px rgba(30,155,255,.55)}
header .btn{padding:10px 20px;font-size:15px}

/* hero */
.hero{position:relative;overflow:hidden;min-height:100svh;display:flex;align-items:center;padding:120px 0 90px;background:radial-gradient(90% 70% at 85% 30%,rgba(30,155,255,.16),transparent 60%),var(--bg)}
.bands{position:absolute;inset:0;pointer-events:none}
.band{position:absolute;right:-12%;width:82%;height:clamp(26px,5vw,58px);border-radius:60px 0 0 60px;transform-origin:right center;transform:rotate(-19deg);animation:sweep 1.1s cubic-bezier(.2,.75,.25,1) backwards}
.band.a{top:28%;background:linear-gradient(90deg,transparent,var(--org) 40%,#ffb347);animation-delay:.2s;box-shadow:0 0 50px rgba(255,138,0,.35)}
.band.b{top:39%;background:linear-gradient(90deg,transparent,var(--lime) 40%,#b6f24a);animation-delay:.38s;box-shadow:0 0 50px rgba(124,209,0,.3)}
.band.c{top:50%;background:linear-gradient(90deg,transparent,var(--blue) 40%,#66ccff);animation-delay:.56s;box-shadow:0 0 60px rgba(30,155,255,.45)}
@keyframes sweep{from{transform:translateX(120%) rotate(-19deg);opacity:0}}
.hero .wrap{position:relative;z-index:2;width:100%}
.eyebrow{display:inline-flex;align-items:center;gap:10px;font-weight:700;font-size:13px;letter-spacing:.2em;text-transform:uppercase;color:var(--blue);margin:0 0 20px}
.eyebrow .ic{width:18px;height:18px}
.hero h1{font-size:clamp(50px,10vw,148px);max-width:9ch;text-shadow:0 10px 60px rgba(0,0,0,.6)}
.hero h1 em{font-style:inherit;background:linear-gradient(180deg,#8fd6ff,#1E9BFF 60%,#0b5fc4);-webkit-background-clip:text;background-clip:text;color:transparent}
.hero p.lead{max-width:36ch;font-size:clamp(18px,1.8vw,22px);color:var(--tx);margin:26px 0 34px}
.btns{display:flex;gap:12px;flex-wrap:wrap}
.pillars{display:flex;gap:10px 28px;flex-wrap:wrap;margin-top:54px;font-weight:700;font-size:15px}
.pillars span{display:inline-flex;align-items:center;gap:9px}
.pillars .ic{color:var(--ic,var(--lime));width:20px;height:20px}

/* sections */
section{padding:clamp(70px,10vw,130px) 0}
.lede{font-size:clamp(32px,5.4vw,70px);max-width:16ch}
.sub{color:var(--mut);max-width:44ch;margin:18px 0 0}
.services{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:18px;margin-top:56px}
.card{position:relative;background:var(--panel);border:1px solid var(--line);border-radius:18px;padding:30px 26px 32px;overflow:hidden;transition:transform .3s,border-color .3s}
.card::before{content:"";position:absolute;left:0;right:0;top:0;height:5px;background:var(--c)}
.card::after{content:"";position:absolute;inset:auto -30% -60% -30%;height:70%;background:radial-gradient(closest-side,var(--c),transparent);opacity:.0;transition:opacity .4s}
.card:hover{transform:translateY(-6px);border-color:var(--c)}
.card:hover::after{opacity:.22}
.card .ic{width:34px;height:34px;color:var(--c);margin-bottom:22px}
.card h3{font-size:clamp(26px,2.6vw,34px);margin-bottom:12px}
.card p{margin:0;color:var(--mut);position:relative;z-index:1}
.steps{counter-reset:s;display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:30px;margin-top:56px}
.step{position:relative;border-top:2px solid var(--line);padding-top:22px}
.step .step-ic{position:absolute;top:16px;right:0;width:46px;height:46px;padding:11px;border-radius:50%;background:rgba(30,155,255,.12);border:1px solid var(--line);color:var(--blue);transition:transform .3s,background .3s,color .3s,border-color .3s}
.step:hover .step-ic{transform:translateY(-4px) rotate(-6deg);background:var(--blue);border-color:var(--blue);color:#fff}
.step::before{counter-increment:s;content:"0" counter(s);font:italic 900 46px 'Exo 2',sans-serif;background:linear-gradient(180deg,#8fd6ff,#1E9BFF);-webkit-background-clip:text;background-clip:text;color:transparent}
.step h3{font-size:24px;margin:8px 0 8px}
.step p{color:var(--mut);margin:0;max-width:30ch}

/* house tester */
.tester{background:linear-gradient(180deg,var(--panel),var(--bg))}
.house{display:grid;grid-template-columns:minmax(0,1.4fr) minmax(0,1fr);gap:clamp(24px,5vw,70px);align-items:center;margin-top:50px}
.house svg{width:100%;height:auto;display:block;border-radius:16px}
.house #walls,.house #door{transition:fill .5s ease}
.sw{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:26px}
.sw button{aspect-ratio:1;border:0;border-radius:50%;background:var(--c);cursor:pointer;box-shadow:inset 0 0 0 1px rgba(255,255,255,.3);transition:transform .2s}
.sw button:hover{transform:scale(1.1)}
.sw button[aria-pressed="true"]{outline:3px solid var(--blue);outline-offset:4px}
.tg{display:flex;gap:8px;margin-bottom:22px}
.tg button{flex:1;display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:11px;border-radius:99px;border:1.5px solid var(--line);background:transparent;color:var(--mut);font:700 14px 'Manrope',sans-serif;cursor:pointer;transition:color .2s,border-color .2s,background .2s}
.tg button .ic{width:16px;height:16px}
.tg button:hover{color:var(--tx);border-color:var(--blue)}
.tg button[aria-pressed="true"]{background:var(--blue);border-color:var(--blue);color:#fff}
.pick{font:italic 900 clamp(26px,3.4vw,42px) 'Exo 2',sans-serif;margin:0 0 20px;min-height:1.2em}

/* recent work */
.gallery{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:16px;margin-top:52px}
@media(max-width:1000px){.gallery{grid-template-columns:repeat(2,minmax(0,1fr))}}
.shot{position:relative;display:block;width:100%;aspect-ratio:1/1;margin:0;padding:0;border:1px solid var(--line);border-radius:16px;background:var(--panel);overflow:hidden;cursor:zoom-in;-webkit-appearance:none;appearance:none;font:inherit}
.shot img{display:block;width:100%;height:100%;object-fit:cover;transition:transform .55s cubic-bezier(.2,.7,.3,1)}
.shot::after{content:"";position:absolute;inset:0;background:linear-gradient(180deg,rgba(5,6,8,0) 45%,rgba(5,6,8,.72));opacity:0;transition:opacity .35s;pointer-events:none}
.shot:hover img,.shot:focus-visible img{transform:scale(1.06)}
.shot:hover::after,.shot:focus-visible::after{opacity:1}
.shot .zoom{position:absolute;right:12px;bottom:12px;z-index:1;width:38px;height:38px;padding:9px;border-radius:50%;background:rgba(30,155,255,.94);color:#fff;opacity:0;transform:translateY(8px) scale(.9);transition:opacity .3s,transform .3s}
.shot:hover .zoom,.shot:focus-visible .zoom{opacity:1;transform:none}
.gallery .shot:nth-child(4n+2){--d:.06s}
.gallery .shot:nth-child(4n+3){--d:.12s}
.gallery .shot:nth-child(4n){--d:.18s}

/* reviews */
.reviews{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:18px;margin-top:52px}
.review{display:flex;flex-direction:column;gap:16px;margin:0;background:var(--panel);border:1px solid var(--line);border-radius:18px;padding:28px 26px;transition:transform .3s,border-color .3s}
.review:hover{transform:translateY(-5px);border-color:rgba(30,155,255,.55)}
.review .stars{display:flex;gap:4px;color:var(--org)}
.review .stars .ic{width:19px;height:19px;fill:currentColor;stroke:currentColor}
.review blockquote{margin:0;flex:1;font-size:17px;line-height:1.65}
.review blockquote p{margin:0}
.review figcaption{display:flex;flex-direction:column;gap:3px;padding-top:16px;border-top:1px solid var(--line);font-size:14px}
.review .who{font-weight:700;color:var(--tx)}
.review .where{color:var(--mut)}
.ph{display:inline-flex;align-items:center;gap:7px;align-self:flex-start;margin:0;padding:5px 11px;border-radius:99px;background:rgba(255,138,0,.14);color:#ffb347;font:700 11px 'Manrope',sans-serif;letter-spacing:.14em;text-transform:uppercase}
.ph .ic{width:13px;height:13px}
.reviews .review:nth-child(2){--d:.08s}
.reviews .review:nth-child(3){--d:.16s}
.fbrow{margin:30px 0 0}

/* lightbox */
.lb{position:fixed;inset:0;z-index:80;display:grid;place-items:center;padding:clamp(16px,4vw,60px);background:rgba(3,4,6,.94);backdrop-filter:blur(10px);opacity:0;visibility:hidden;transition:opacity .3s,visibility .3s}
.lb.open{opacity:1;visibility:visible}
.lb figure{margin:0;display:grid;gap:12px;justify-items:center;max-width:100%}
.lb img{display:block;max-width:100%;max-height:80vh;border-radius:12px;box-shadow:0 30px 90px rgba(0,0,0,.7)}
.lb figcaption{font:700 14px 'Manrope',sans-serif;color:var(--mut)}
.lb button{position:absolute;border:1px solid var(--line);background:rgba(13,16,23,.92);color:#fff;cursor:pointer;display:grid;place-items:center;border-radius:50%;transition:background .25s,border-color .25s}
.lb button:hover{background:var(--blue);border-color:var(--blue)}
.lb .close{top:clamp(12px,2.4vw,22px);right:clamp(12px,2.4vw,22px);width:46px;height:46px}
.lb .prev,.lb .next{top:50%;transform:translateY(-50%);width:50px;height:50px}
.lb .prev{left:clamp(8px,2.6vw,26px)}
.lb .next{right:clamp(8px,2.6vw,26px)}
.lb .prev .ic{transform:rotate(90deg)}
.lb .next .ic{transform:rotate(-90deg)}
.lb .prev .ic,.lb .next .ic{width:24px;height:24px}
.lb .close .ic{width:22px;height:22px}
body.locked{overflow:hidden}

/* mobile menu */
.headend{display:flex;align-items:center;gap:10px;flex:none}
.burger{display:none;gap:5px;place-content:center;width:46px;height:46px;padding:0;border:1.5px solid var(--line);border-radius:13px;background:transparent;cursor:pointer;flex:none}
.burger span{display:block;width:20px;height:2px;border-radius:2px;background:var(--tx);transition:transform .3s,opacity .2s}
.burger[aria-expanded="true"] span:nth-child(1){transform:translateY(7px) rotate(45deg)}
.burger[aria-expanded="true"] span:nth-child(2){opacity:0}
.burger[aria-expanded="true"] span:nth-child(3){transform:translateY(-7px) rotate(-45deg)}
.menu{position:fixed;inset:0;z-index:49;padding:88px 0 40px;overflow-y:auto;background:rgba(4,5,7,.98);backdrop-filter:blur(14px);opacity:0;visibility:hidden;transition:opacity .3s,visibility .3s}
.menu.open{opacity:1;visibility:visible}
.menu nav a{display:flex;align-items:center;gap:13px;padding:15px 0;border-bottom:1px solid rgba(255,255,255,.07);font:700 18px 'Manrope',sans-serif;color:var(--mut);text-decoration:none;transition:color .2s,padding-left .2s}
.menu nav a .ic{width:20px;height:20px;color:var(--blue)}
.menu nav a:hover,.menu nav a.active{color:#fff;padding-left:6px}
.menu .btn{margin-top:26px;width:100%}
@media(min-width:1081px){.menu{display:none}}
@media(max-width:1080px){.links{display:none}.burger{display:grid}}

/* areas */
.towns{display:flex;flex-wrap:wrap;gap:12px;margin-top:44px}
.towns span{display:inline-flex;align-items:center;gap:10px;padding:13px 24px;border:1.5px solid var(--line);border-radius:99px;font:italic 800 clamp(18px,2.2vw,26px) 'Exo 2',sans-serif;transition:background .25s,border-color .25s,transform .25s}
.towns span .ic{width:19px;height:19px;color:var(--blue);transition:color .25s}
.towns span:hover{background:var(--blue);border-color:var(--blue);transform:translateY(-3px)}
.towns span:hover .ic{color:#fff}

/* contact */
.contact .cols{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:clamp(30px,6vw,90px)}
.big{display:flex;align-items:center;gap:14px;font:italic 800 clamp(20px,3vw,36px) 'Exo 2',sans-serif;text-decoration:none;margin-top:22px;overflow-wrap:anywhere}
.big .ic{width:44px;height:44px;padding:11px;border-radius:50%;background:var(--blue);color:#fff}
.big:hover span{text-decoration:underline;text-underline-offset:6px}
form{display:grid;gap:14px;background:var(--panel);border:1px solid var(--line);border-radius:18px;padding:clamp(20px,3vw,34px)}
label{display:grid;gap:6px;font-weight:700;font-size:14px;color:var(--mut)}
.lab{display:inline-flex;align-items:center;gap:8px}
.lab .ic{width:16px;height:16px;color:var(--blue)}
input,select,textarea{font:inherit;color:var(--tx);background:#05070b;border:1.5px solid var(--line);border-radius:10px;padding:13px 14px;width:100%}
input:focus,select:focus,textarea:focus{outline:none;border-color:var(--blue);box-shadow:0 0 0 4px rgba(30,155,255,.25)}
textarea{min-height:110px;resize:vertical}
.note{margin:0;padding:12px 14px;border-radius:10px;font-weight:700}
.note.ok{background:rgba(124,209,0,.15);color:#b6f24a}.note.bad{background:rgba(255,80,60,.14);color:#ff8a7a}
footer{border-top:1px solid var(--line);padding:clamp(44px,6vw,72px) 0 30px;color:var(--mut);font-size:15px;background:linear-gradient(180deg,var(--bg),#030406)}
footer .cols{display:grid;grid-template-columns:minmax(0,1.5fr) minmax(0,1fr) minmax(0,1fr);gap:clamp(28px,4vw,60px)}
footer h4{margin:0 0 16px;font-family:'Exo 2','Arial Black',sans-serif;font-style:italic;font-weight:900;font-size:18px;color:var(--tx)}
footer a{color:var(--mut);text-decoration:none}
.flogo{width:180px;margin-bottom:18px}
.ftag{max-width:40ch;margin:0 0 22px}
.fsoc{display:flex;gap:12px}
.fsoc a{display:inline-flex;align-items:center;justify-content:center;width:44px;height:44px;border-radius:50%;border:1px solid var(--line);background:rgba(255,255,255,.03);color:#fff;transition:background .25s,border-color .25s,transform .25s}
.fsoc a:hover{background:var(--blue);border-color:var(--blue);transform:translateY(-3px)}
.fsoc .ic{width:20px;height:20px}
footer nav{display:grid;gap:11px;justify-items:start}
.frow,footer nav a,.ftop{display:inline-flex;align-items:center;gap:10px;transition:color .2s}
.frow{align-items:flex-start;color:var(--tx);margin-bottom:14px}
.frow .ic,footer nav a .ic,.ftop .ic{width:18px;height:18px;flex:none;color:var(--blue);transition:transform .25s}
.frow .ic{margin-top:3px}
.frow:hover,footer nav a:hover,.ftop:hover{color:#fff}
footer nav a:hover .ic{transform:translateX(-2px)}
.ftop{color:var(--tx)}
.ftop .ic{width:16px;height:16px}
.fbottom{margin-top:clamp(34px,5vw,56px);padding-top:22px;border-top:1px solid var(--line);display:flex;justify-content:space-between;align-items:center;gap:14px;flex-wrap:wrap;font-size:14px}
.cue{position:absolute;left:50%;bottom:26px;transform:translateX(-50%);z-index:2;display:inline-flex;flex-direction:column;align-items:center;gap:6px;font:700 11px 'Manrope',sans-serif;letter-spacing:.22em;text-transform:uppercase;color:var(--mut);text-decoration:none}
.cue .ic{width:22px;height:22px;animation:bob 1.9s ease-in-out infinite}
.cue:hover{color:#fff}
@keyframes bob{50%{transform:translateY(7px)}}
.totop{position:fixed;right:22px;bottom:22px;z-index:55;width:50px;height:50px;border-radius:50%;border:1px solid var(--line);background:rgba(13,16,23,.92);backdrop-filter:blur(8px);color:#fff;cursor:pointer;display:grid;place-items:center;opacity:0;transform:translateY(16px) scale(.9);pointer-events:none;transition:opacity .3s,transform .3s,background .25s,border-color .25s}
.totop.show{opacity:1;transform:none;pointer-events:auto}
.totop:hover{background:var(--blue);border-color:var(--blue)}
.totop .ic{width:22px;height:22px}

@media(max-width:900px){
.services,.steps,.contact .cols,.house,footer .cols{grid-template-columns:minmax(0,1fr)}
.reviews{grid-template-columns:minmax(0,1fr)}
.band{width:120%;right:-40%}
.cue{display:none}
}
@media(max-width:560px){
.wrap{padding:0 18px}
.logo{width:106px}
header.top.scrolled .logo{width:96px}
header .btn{padding:9px 16px;font-size:14px}
.hero{padding-top:100px}
.hero h1{font-size:clamp(46px,14vw,70px);max-width:none}
.btns .btn{flex:1 1 100%}
.band.a{top:60%}.band.b{top:68%}.band.c{top:76%}
.sw{grid-template-columns:repeat(4,1fr)}
.gallery{gap:12px}
.shot{border-radius:12px}
}
@media(max-width:400px){
.logo{width:92px}
header.top.scrolled .logo{width:84px}
}
@media(prefers-reduced-motion:reduce){.band{animation:none}.rv{opacity:1;transform:none;transition:none}.cue .ic{animation:none}.progress{transition:none}}
</style>
</head>
<body>
<div class="progress" aria-hidden="true"></div>
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
<symbol id="i-phone" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 4.2 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></symbol>
<symbol id="i-mail" viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></symbol>
<symbol id="i-house" viewBox="0 0 24 24"><path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/><path d="M3 10a2 2 0 0 1 .7-1.5l7-6a2 2 0 0 1 2.6 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></symbol>
<symbol id="i-building" viewBox="0 0 24 24"><rect x="4" y="2" width="16" height="20" rx="2"/><path d="M9 22v-4h6v4M8 6h.01M12 6h.01M16 6h.01M8 10h.01M12 10h.01M16 10h.01M8 14h.01M12 14h.01M16 14h.01"/></symbol>
<symbol id="i-office" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></symbol>
<symbol id="i-check" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="m8.5 12.5 2.5 2.5 4.5-5.5"/></symbol>
<symbol id="i-arrow" viewBox="0 0 24 24"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></symbol>
<symbol id="i-arrow-up" viewBox="0 0 24 24"><path d="M12 19V5"/><path d="m5 12 7-7 7 7"/></symbol>
<symbol id="i-chevron" viewBox="0 0 24 24"><path d="m6 9 6 6 6-6"/></symbol>
<symbol id="i-pin" viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></symbol>
<symbol id="i-map" viewBox="0 0 24 24"><path d="M14.106 5.553a2 2 0 0 0 1.788 0l3.659-1.83A1 1 0 0 1 21 4.619v12.764a1 1 0 0 1-.553.894l-4.553 2.277a2 2 0 0 1-1.788 0l-4.212-2.106a2 2 0 0 0-1.788 0l-3.659 1.83A1 1 0 0 1 3 19.381V6.618a1 1 0 0 1 .553-.894l4.553-2.277a2 2 0 0 1 1.788 0z"/><path d="M15 5.764v15"/><path d="M9 3.236v15"/></symbol>
<symbol id="i-roller" viewBox="0 0 24 24"><rect x="2" y="2" width="16" height="6" rx="2"/><path d="M10 16v-2a2 2 0 0 1 2-2h8a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect x="8" y="16" width="4" height="6" rx="1"/></symbol>
<symbol id="i-palette" viewBox="0 0 24 24"><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.9 0 1.6-.7 1.6-1.7 0-.4-.2-.8-.4-1.1-.3-.3-.4-.7-.4-1.1a1.6 1.6 0 0 1 1.7-1.7h2c3 0 5.5-2.5 5.5-5.5C21.9 6 17.5 2 12 2z"/><circle cx="13.5" cy="6.5" r=".6"/><circle cx="17.5" cy="10.5" r=".6"/><circle cx="8.5" cy="7.5" r=".6"/><circle cx="6.5" cy="12.5" r=".6"/></symbol>
<symbol id="i-door" viewBox="0 0 24 24"><path d="M18 20V6a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v14"/><path d="M2 20h20"/><path d="M14 12v.01"/></symbol>
<symbol id="i-chat" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></symbol>
<symbol id="i-receipt" viewBox="0 0 24 24"><path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1z"/><path d="M14 8H8"/><path d="M16 12H8"/><path d="M13 16H8"/></symbol>
<symbol id="i-tag" viewBox="0 0 24 24"><path d="M12.6 2.6A2 2 0 0 0 11.2 2H4a2 2 0 0 0-2 2v7.2a2 2 0 0 0 .6 1.4l8.7 8.7a2.4 2.4 0 0 0 3.4 0l6.6-6.6a2.4 2.4 0 0 0 0-3.4z"/><circle cx="7.5" cy="7.5" r=".6"/></symbol>
<symbol id="i-sparkle" viewBox="0 0 24 24"><path d="m12 3-1.9 5.8a2 2 0 0 1-1.3 1.3L3 12l5.8 1.9a2 2 0 0 1 1.3 1.3L12 21l1.9-5.8a2 2 0 0 1 1.3-1.3L21 12l-5.8-1.9a2 2 0 0 1-1.3-1.3z"/></symbol>
<symbol id="i-clock" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></symbol>
<symbol id="i-user" viewBox="0 0 24 24"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></symbol>
<symbol id="i-facebook" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></symbol>
<symbol id="i-star" viewBox="0 0 24 24"><path d="m12 2.6 2.95 5.98 6.6.96-4.78 4.66 1.13 6.57L12 17.67l-5.9 3.1 1.13-6.57L2.45 9.54l6.6-.96z"/></symbol>
<symbol id="i-zoom" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7.5"/><path d="m21 21-4.3-4.3"/><path d="M11 8.5v5"/><path d="M8.5 11h5"/></symbol>
<symbol id="i-x" viewBox="0 0 24 24"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></symbol>
</svg>

<header class="top">
  <div class="wrap">
    <a class="logo" href="#top" aria-label="TyCal Painters home"><img src="images/logo-trim.png" alt="TyCal Painters, elevating homes" width="845" height="371"></a>
    <nav class="links" aria-label="Main"><a href="#services"><svg class="ic"><use href="#i-roller"/></svg>Services</a><a href="#process"><svg class="ic"><use href="#i-chat"/></svg>Free quote</a><a href="#work"><svg class="ic"><use href="#i-zoom"/></svg>Our work</a><a href="#reviews"><svg class="ic"><use href="#i-star"/></svg>Reviews</a><a href="#colour"><svg class="ic"><use href="#i-palette"/></svg>Try a colour</a><a href="#areas"><svg class="ic"><use href="#i-map"/></svg>Areas</a><a href="#contact"><svg class="ic"><use href="#i-mail"/></svg>Contact</a></nav>
    <div class="headend">
      <a class="btn go" href="tel:+447354869786"><svg class="ic"><use href="#i-phone"/></svg>Call us</a>
      <button class="burger" id="burger" type="button" aria-label="Open menu" aria-expanded="false" aria-controls="menu"><span></span><span></span><span></span></button>
    </div>
  </div>
</header>

<div class="menu" id="menu" aria-hidden="true">
  <div class="wrap">
    <nav aria-label="Mobile">
      <a href="#services"><svg class="ic"><use href="#i-roller"/></svg>Services</a>
      <a href="#process"><svg class="ic"><use href="#i-chat"/></svg>Free quote</a>
      <a href="#work"><svg class="ic"><use href="#i-zoom"/></svg>Our work</a>
      <a href="#reviews"><svg class="ic"><use href="#i-star"/></svg>Reviews</a>
      <a href="#colour"><svg class="ic"><use href="#i-palette"/></svg>Try a colour</a>
      <a href="#areas"><svg class="ic"><use href="#i-map"/></svg>Areas</a>
      <a href="#contact"><svg class="ic"><use href="#i-mail"/></svg>Contact</a>
    </nav>
    <a class="btn go" href="tel:+447354869786"><svg class="ic"><use href="#i-phone"/></svg>07354 869786</a>
  </div>
</div>

<main id="top">
<div class="hero">
  <div class="bands" aria-hidden="true"><i class="band a"></i><i class="band b"></i><i class="band c"></i></div>
  <div class="wrap">
    <p class="eyebrow rv in"><svg class="ic"><use href="#i-roller"/></svg>Residential &amp; commercial painters</p>
    <h1 class="chrome">We <em>elevate</em> homes.</h1>
    <p class="lead">Clean work, reliable timekeeping and fair pricing, for homes, offices and buildings across Dudley, Staffordshire and Worcestershire.</p>
    <div class="btns">
      <a class="btn go" href="#contact">Get a free quote <svg class="ic"><use href="#i-arrow"/></svg></a>
      <a class="btn" href="tel:+447354869786"><svg class="ic"><use href="#i-phone"/></svg>07354 869786</a>
    </div>
    <div class="pillars"><span style="--ic:var(--lime)"><svg class="ic"><use href="#i-sparkle"/></svg>Clean work</span><span style="--ic:var(--blue)"><svg class="ic"><use href="#i-clock"/></svg>Reliable</span><span style="--ic:var(--org)"><svg class="ic"><use href="#i-tag"/></svg>Fair pricing</span></div>
  </div>
  <a class="cue" href="#services" aria-label="Scroll to services"><span>Scroll</span><svg class="ic"><use href="#i-chevron"/></svg></a>
</div>

<section id="services">
  <div class="wrap">
    <h2 class="lede chrome rv">Painting for every kind of building.</h2>
    <p class="sub rv">Whether it is your front room or a whole unit, the standard stays the same.</p>
    <div class="services">
      <article class="card rv" style="--c:var(--blue)"><svg class="ic"><use href="#i-house"/></svg><h3>Homes</h3><p>Interior and exterior painting for houses and flats, finished neatly with your space protected.</p></article>
      <article class="card rv" style="--c:var(--lime);--d:.08s"><svg class="ic"><use href="#i-office"/></svg><h3>Offices</h3><p>Fresh, professional workspaces painted with minimal fuss and a tidy finish.</p></article>
      <article class="card rv" style="--c:var(--org);--d:.16s"><svg class="ic"><use href="#i-building"/></svg><h3>Buildings</h3><p>Larger commercial and residential buildings, handled reliably and priced fairly.</p></article>
    </div>
  </div>
</section>

<section id="process">
  <div class="wrap">
    <h2 class="lede chrome rv">A free quote in three steps.</h2>
    <div class="steps">
      <div class="step rv"><svg class="ic step-ic"><use href="#i-chat"/></svg><h3>Message us</h3><p>Call, email or use the form and tell us what needs painting.</p></div>
      <div class="step rv" style="--d:.08s"><svg class="ic step-ic" style="color:var(--lime);background:rgba(124,209,0,.12)"><use href="#i-receipt"/></svg><h3>Get your price</h3><p>A clear, fair quote with no pressure and no surprises.</p></div>
      <div class="step rv" style="--d:.16s"><svg class="ic step-ic" style="color:var(--org);background:rgba(255,138,0,.12)"><use href="#i-roller"/></svg><h3>We get painting</h3><p>Clean, careful work, finished on time and left tidy.</p></div>
    </div>
  </div>
</section>

<section id="work">
  <div class="wrap">
    <p class="eyebrow rv"><svg class="ic"><use href="#i-zoom"/></svg>Recent work</p>
    <h2 class="lede chrome rv">Jobs we&rsquo;ve finished lately.</h2>
    <p class="sub rv">A look at some of the homes, offices and buildings we have painted across Dudley, Staffordshire and Worcestershire. Pick any photo to see it larger.</p>
    <div class="gallery">
      <button class="shot rv" type="button" aria-label="View photo 1 of 8 larger"><img src="images/work/tycal%20image%201.jpg" alt="Interior painting work by TyCal Painters" width="720" height="960" loading="lazy" decoding="async"><svg class="ic zoom" aria-hidden="true"><use href="#i-zoom"/></svg></button>
      <button class="shot rv" type="button" aria-label="View photo 2 of 8 larger"><img src="images/work/tycal-image-2.jpg" alt="Interior painting work by TyCal Painters" width="720" height="960" loading="lazy" decoding="async"><svg class="ic zoom" aria-hidden="true"><use href="#i-zoom"/></svg></button>
      <button class="shot rv" type="button" aria-label="View photo 3 of 8 larger"><img src="images/work/tycal-recent-work-10.jpg" alt="Interior painting work by TyCal Painters" width="960" height="960" loading="lazy" decoding="async"><svg class="ic zoom" aria-hidden="true"><use href="#i-zoom"/></svg></button>
      <button class="shot rv" type="button" aria-label="View photo 4 of 8 larger"><img src="images/work/tycal-recent-work-3.jpg" alt="Interior painting work by TyCal Painters" width="1170" height="1560" loading="lazy" decoding="async"><svg class="ic zoom" aria-hidden="true"><use href="#i-zoom"/></svg></button>
      <button class="shot rv" type="button" aria-label="View photo 5 of 8 larger"><img src="images/work/tycal-recent-work-4.jpg" alt="Interior painting work by TyCal Painters" width="1170" height="1560" loading="lazy" decoding="async"><svg class="ic zoom" aria-hidden="true"><use href="#i-zoom"/></svg></button>
      <button class="shot rv" type="button" aria-label="View photo 6 of 8 larger"><img src="images/work/tycal-recent-work-7.jpg" alt="Interior painting work by TyCal Painters" width="720" height="960" loading="lazy" decoding="async"><svg class="ic zoom" aria-hidden="true"><use href="#i-zoom"/></svg></button>
      <button class="shot rv" type="button" aria-label="View photo 7 of 8 larger"><img src="images/work/tycal-recent-work-8.jpg" alt="Interior painting work by TyCal Painters" width="720" height="960" loading="lazy" decoding="async"><svg class="ic zoom" aria-hidden="true"><use href="#i-zoom"/></svg></button>
      <button class="shot rv" type="button" aria-label="View photo 8 of 8 larger"><img src="images/work/tycal-recent-work-9.jpg" alt="Interior painting work by TyCal Painters" width="720" height="960" loading="lazy" decoding="async"><svg class="ic zoom" aria-hidden="true"><use href="#i-zoom"/></svg></button>
    </div>
  </div>
</section>

<section id="reviews">
  <div class="wrap">
    <p class="eyebrow rv"><svg class="ic"><use href="#i-star"/></svg>Reviews</p>
    <h2 class="lede chrome rv">What customers say.</h2>
    <p class="sub rv">We would rather show you genuine feedback than invented praise. These three slots are ready for real reviews from our Facebook page.</p>

    <!-- =====================================================================
         PLACEHOLDERS - REPLACE BEFORE GOING LIVE.
         Three real customer reviews belong here. Keep the <figure class="review">
         wrapper, the star row and the <blockquote>; paste the customer's own
         words, then their name and town. Delete the <p class="ph"> line once
         the review is genuine.
         Source: https://www.facebook.com/TyCalPainters/reviews
         ===================================================================== -->
    
    <p class="fbrow rv"><a class="btn" href="https://www.facebook.com/TyCalPainters/" rel="noopener"><svg class="ic"><use href="#i-facebook"/></svg>Read reviews on Facebook</a></p>
  </div>
</section>

<section class="tester" id="colour">
  <div class="wrap">
    <h2 class="lede chrome rv">Try a colour on the house.</h2>        <div class="house rv z">
      <svg viewBox="0 0 600 400" role="img" aria-label="Illustration of a house whose colours change when you pick a swatch">
        <rect width="600" height="400" fill="#0a0d14"/>
        <rect y="330" width="600" height="70" fill="#141a24"/>
        <polygon points="80,170 300,50 520,170" fill="#c9d3e0"/>
        <rect x="380" y="60" width="34" height="70" fill="#8794a6"/>
        <rect id="walls" x="110" y="170" width="380" height="170" fill="#E9EEF5"/>
        <rect x="150" y="205" width="90" height="80" fill="#0a1a2b" stroke="#c9d3e0" stroke-width="6"/><path d="M195 205v80M150 245h90" stroke="#c9d3e0" stroke-width="5"/>
        <rect x="360" y="205" width="90" height="80" fill="#0a1a2b" stroke="#c9d3e0" stroke-width="6"/><path d="M405 205v80M360 245h90" stroke="#c9d3e0" stroke-width="5"/>
        <rect id="door" x="264" y="235" width="72" height="105" rx="4" fill="#1E9BFF"/><circle cx="324" cy="292" r="4" fill="#fff"/>
      </svg>
      <div>
        <p class="pick" id="pick" aria-live="polite">Walls: Cloud</p>
        <div class="tg" role="group" aria-label="What to paint"><button type="button" id="tw" aria-pressed="true"><svg class="ic"><use href="#i-roller"/></svg>Walls</button><button type="button" id="td" aria-pressed="false"><svg class="ic"><use href="#i-door"/></svg>Front door</button></div>
        <div class="sw" id="sw" role="group" aria-label="Colours"></div>
        <p class="sub" style="margin:0">Have a shade in mind? Tell us and we will quote to match it.</p>
      </div>
    </div>
  </div>
</section>

<section id="areas">
  <div class="wrap">
    <h2 class="lede chrome rv">Working across the West Midlands.</h2>
    <div class="towns rv"><span><svg class="ic"><use href="#i-pin"/></svg>Dudley</span><span><svg class="ic"><use href="#i-pin"/></svg>Brierley Hill</span><span><svg class="ic"><use href="#i-pin"/></svg>Stourbridge</span><span><svg class="ic"><use href="#i-pin"/></svg>Kidderminster</span><span><svg class="ic"><use href="#i-pin"/></svg>Bewdley</span><span><svg class="ic"><use href="#i-pin"/></svg>Staffordshire</span><span><svg class="ic"><use href="#i-pin"/></svg>Worcestershire</span></div>
  </div>
</section>

<section class="contact" id="contact">
  <div class="wrap cols">
    <div class="rv l">
      <p class="eyebrow"><svg class="ic"><use href="#i-chat"/></svg>Message us for a free quote</p>
      <h2 class="lede chrome">Ready when you are.</h2>
      <a class="big" href="tel:+447354869786"><svg class="ic"><use href="#i-phone"/></svg><span>07354 869786</span></a>
      <a class="big" href="mailto:tycalpainters@gmail.com"><svg class="ic"><use href="#i-mail"/></svg><span>tycalpainters@gmail.com</span></a>
      <p class="sub"><svg class="ic" style="width:18px;height:18px;vertical-align:-.22em;color:var(--blue)"><use href="#i-pin"/></svg> Covering Dudley, Stourbridge, Kidderminster and across Staffordshire &amp; Worcestershire.</p>
    </div>
    <form class="rv r" method="post" action="#contact" style="--d:.1s">
      <?php if ($status === 'ok'): ?><p class="note ok" role="status">Thanks, your request has been sent. We'll be in touch soon.</p>
      <?php elseif ($status === 'missing'): ?><p class="note bad" role="alert">Please add your name and a phone number or email.</p>
      <?php elseif ($status === 'fail'): ?><p class="note bad" role="alert">Sorry, that didn't send. Please call 07354 869786 or email tycalpainters@gmail.com.</p><?php endif; ?>
      <input type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true" style="position:absolute;left:-9999px">
      <label><span class="lab"><svg class="ic"><use href="#i-user"/></svg>Your name</span><input name="n" required autocomplete="name" value="<?= $status === 'missing' ? htmlspecialchars($clean($_POST['n'] ?? '')) : '' ?>"></label>
      <label><span class="lab"><svg class="ic"><use href="#i-phone"/></svg>Phone number</span><input name="p" type="tel" autocomplete="tel"></label>
      <label><span class="lab"><svg class="ic"><use href="#i-mail"/></svg>Email (optional if you add a phone number)</span><input name="e" type="email" autocomplete="email"></label>
      <label><span class="lab"><svg class="ic"><use href="#i-roller"/></svg>Type of job</span><select name="t"><option>Home (residential)</option><option>Office</option><option>Building (commercial)</option><option>Something else</option></select></label>
      <label><span class="lab"><svg class="ic"><use href="#i-chat"/></svg>Details</span><textarea name="m" placeholder="What needs painting, where, and when"></textarea></label>
      <button class="btn go" type="submit">Request free quote <svg class="ic"><use href="#i-arrow"/></svg></button>
    </form>
  </div>
</section>
</main>

<footer>
  <div class="wrap cols">
    <div class="fcol">
      <a class="logo flogo" href="#top" aria-label="TyCal Painters home"><img src="images/logo-trim.png" alt="TyCal Painters, elevating homes" width="845" height="371"></a>
      <p class="ftag">Clean, reliable and fairly priced painting for homes, offices and buildings across Dudley, Staffordshire and Worcestershire.</p>
      <div class="fsoc">
        <a href="https://www.facebook.com/TyCalPainters/" rel="noopener" aria-label="TyCal Painters on Facebook"><svg class="ic"><use href="#i-facebook"/></svg></a>
      </div>
    </div>
    <div class="fcol">
      <h4>Get in touch</h4>
      <a class="frow" href="tel:+447354869786"><svg class="ic"><use href="#i-phone"/></svg><span>07354 869786</span></a>
      <a class="frow" href="mailto:tycalpainters@gmail.com"><svg class="ic"><use href="#i-mail"/></svg><span>tycalpainters@gmail.com</span></a>
      <span class="frow"><svg class="ic"><use href="#i-pin"/></svg><span>Dudley, West Midlands</span></span>
    </div>
    <nav class="fcol" aria-label="Footer">
      <h4>Explore</h4>
      <a href="#services"><svg class="ic"><use href="#i-roller"/></svg>Services</a>
      <a href="#process"><svg class="ic"><use href="#i-chat"/></svg>Free quote</a>
      <a href="#work"><svg class="ic"><use href="#i-zoom"/></svg>Our work</a>
      <a href="#reviews"><svg class="ic"><use href="#i-star"/></svg>Reviews</a>
      <a href="#colour"><svg class="ic"><use href="#i-palette"/></svg>Try a colour</a>
      <a href="#areas"><svg class="ic"><use href="#i-map"/></svg>Areas</a>
      <a href="#contact"><svg class="ic"><use href="#i-mail"/></svg>Contact</a>
    </nav>
  </div>
  <div class="wrap fbottom">
    <span>&copy; <?= date('Y') ?> TyCal Painters. Elevating homes.</span>
    <a class="ftop" href="#top">Back to top <svg class="ic"><use href="#i-chevron"/></svg></a>
  </div>
</footer>

<div class="lb" id="lb" role="dialog" aria-modal="true" aria-label="Photo viewer">
  <button class="close" type="button" aria-label="Close photo viewer"><svg class="ic"><use href="#i-x"/></svg></button>
  <button class="prev" type="button" aria-label="Previous photo"><svg class="ic"><use href="#i-chevron"/></svg></button>
  <button class="next" type="button" aria-label="Next photo"><svg class="ic"><use href="#i-chevron"/></svg></button>
  <figure><img id="lb-img" src="" alt=""><figcaption id="lb-cap"></figcaption></figure>
</div>

<button class="totop" type="button" aria-label="Back to top"><svg class="ic"><use href="#i-arrow-up"/></svg></button>

<script>
const cols=[["Cloud","#E9EEF5"],["Ocean","#1E9BFF"],["Sage","#8CA58F"],["Slate","#4A5566"],["Sunset","#FF8A00"],["Lime","#7CD100"],["Clay","#B5654A"],["Midnight","#101a2e"]];
const sw=document.getElementById('sw'),walls=document.getElementById('walls'),door=document.getElementById('door'),pick=document.getElementById('pick'),tw=document.getElementById('tw'),td=document.getElementById('td');
let target='walls',last={walls:"Cloud",door:"Ocean"};
const setT=t=>{target=t;tw.setAttribute('aria-pressed',t==='walls');td.setAttribute('aria-pressed',t==='door');pick.textContent=(t==='walls'?'Walls: ':'Front door: ')+last[t];};
tw.onclick=()=>setT('walls');td.onclick=()=>setT('door');
cols.forEach(([n,c])=>{const b=document.createElement('button');b.type='button';b.style.setProperty('--c',c);b.setAttribute('aria-label',n);
b.onclick=()=>{(target==='walls'?walls:door).setAttribute('fill',c);last[target]=n;setT(target);};sw.appendChild(b);});
const rvs=[...document.querySelectorAll('.rv')];
if('IntersectionObserver' in window){
  let fired=false;
  const io=new IntersectionObserver(es=>{fired=true;es.forEach(e=>{if(e.isIntersecting)e.target.classList.add('in')});},{rootMargin:'0px 0px -8% 0px',threshold:.05});
  rvs.forEach(el=>io.observe(el));
  setTimeout(()=>{if(!fired)rvs.forEach(el=>el.classList.add('in'));},2500);
}else rvs.forEach(el=>el.classList.add('in'));

/* scroll interactivity: progress bar, compact header, hero parallax, back-to-top */
const reduce=matchMedia('(prefers-reduced-motion: reduce)').matches;
const bar=document.querySelector('.progress'),hdr=document.querySelector('header.top'),
      bands=document.querySelector('.bands'),tt=document.querySelector('.totop');
if(tt)tt.addEventListener('click',()=>window.scrollTo({top:0,behavior:reduce?'auto':'smooth'}));
let queued=0;
function tick(){
  queued=0;
  const y=window.scrollY||document.documentElement.scrollTop||0;
  const max=document.documentElement.scrollHeight-window.innerHeight;
  if(bar)bar.style.transform='scaleX('+(max>0?Math.min(y/max,1):0)+')';
  if(hdr)hdr.classList.toggle('scrolled',y>24);
  if(tt)tt.classList.toggle('show',y>640);
  if(bands&&!reduce&&y<window.innerHeight)bands.style.transform='translate3d(0,'+(y*.16).toFixed(1)+'px,0)';
}
function onScroll(){if(!queued)queued=requestAnimationFrame(tick);}
addEventListener('scroll',onScroll,{passive:true});
addEventListener('resize',onScroll,{passive:true});
tick();

/* recent work lightbox */
const lb=document.getElementById('lb'),lbImg=document.getElementById('lb-img'),lbCap=document.getElementById('lb-cap'),
      shots=[...document.querySelectorAll('.gallery .shot')];
let shotIndex=0,lastFocus=null;
function showShot(i){
  if(!shots.length)return;
  shotIndex=(i+shots.length)%shots.length;
  const s=shots[shotIndex],img=s.querySelector('img');
  lbImg.src=img.currentSrc||img.src;
  lbImg.alt=img.alt;
  lbCap.textContent=(shotIndex+1)+' of '+shots.length;
  lb.classList.add('open');
  document.body.classList.add('locked');
}
function hideShot(){
  lb.classList.remove('open');
  document.body.classList.toggle('locked',menu.classList.contains('open'));
  if(lastFocus)lastFocus.focus();
}
shots.forEach((s,i)=>s.addEventListener('click',()=>{lastFocus=s;showShot(i);}));
if(shots.length){
  lb.querySelector('.close').addEventListener('click',hideShot);
  lb.querySelector('.prev').addEventListener('click',()=>showShot(shotIndex-1));
  lb.querySelector('.next').addEventListener('click',()=>showShot(shotIndex+1));
  lb.addEventListener('click',e=>{if(e.target===lb)hideShot();});
}

/* mobile menu */
const burger=document.getElementById('burger'),menu=document.getElementById('menu');
function setMenu(open){
  burger.setAttribute('aria-expanded',open?'true':'false');
  burger.setAttribute('aria-label',open?'Close menu':'Open menu');
  menu.setAttribute('aria-hidden',open?'false':'true');
  menu.classList.toggle('open',open);
  document.body.classList.toggle('locked',open||lb.classList.contains('open'));
}
burger.addEventListener('click',()=>setMenu(!menu.classList.contains('open')));
menu.querySelectorAll('a').forEach(a=>a.addEventListener('click',()=>setMenu(false)));

/* keyboard: esc closes the top layer, arrows page through photos */
addEventListener('keydown',e=>{
  if(e.key==='Escape'){ if(lb.classList.contains('open'))hideShot(); else setMenu(false); return; }
  if(!lb.classList.contains('open'))return;
  if(e.key==='ArrowLeft')showShot(shotIndex-1);
  else if(e.key==='ArrowRight')showShot(shotIndex+1);
});

/* highlight the nav link for the section in view */
/* each section can own several links (header + mobile menu), so map id -> [links] */
const navLinks=[...document.querySelectorAll('.links a[href^="#"], .menu nav a[href^="#"]')];
const navById=new Map();
navLinks.forEach(a=>{
  const id=a.hash.slice(1);
  if(!navById.has(id))navById.set(id,[]);
  navById.get(id).push(a);
});
if('IntersectionObserver' in window&&navById.size){
  const spy=new IntersectionObserver(es=>{
    es.forEach(e=>{
      if(!e.isIntersecting)return;
      const group=navById.get(e.target.id);
      if(group)navLinks.forEach(l=>l.classList.toggle('active',group.includes(l)));
    });
  },{rootMargin:'-45% 0px -50% 0px',threshold:0});
  document.querySelectorAll('section[id]').forEach(s=>{if(navById.has(s.id))spy.observe(s);});
}
</script>
</body>
</html>