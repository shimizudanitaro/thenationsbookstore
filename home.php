<?php include_once 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>The Nation's Bookstore</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg:           #f7f3ee;
      --surface:      #ffffff;
      --ink:          #1a1410;
      --ink-muted:    #6b5e52;
      --accent:       #c0392b;
      --accent-light: #f9e9e7;
      --border:       #e2d9d0;
      --shadow:       rgba(26,20,16,.10);
      --font-display: 'Playfair Display', Georgia, serif;
      --font-body:    'DM Sans', sans-serif;
      --nav-h:        64px;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html, body { height: 100%; }
    body {
      background: var(--ink);
      color: var(--ink);
      font-family: var(--font-body);
      font-size: 15px;
      line-height: 1.6;
      overflow: hidden;
    }
    a { color: inherit; text-decoration: none; }
    button { cursor: pointer; font-family: var(--font-body); }

    /* NAV */
    nav {
      position: fixed;
      top: 0; left: 0; right: 0;
      z-index: 100;
      height: var(--nav-h);
      background: var(--surface);
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      padding: 0 2rem;
      gap: 1.5rem;
      box-shadow: 0 2px 12px var(--shadow);
      animation: slideDown .6s ease both;
    }
    @keyframes slideDown {
      from { transform: translateY(-100%); opacity: 0; }
      to   { transform: translateY(0);    opacity: 1; }
    }
    .nav-logo {
      font-family: var(--font-display);
      font-size: 1.5rem;
      font-weight: 700;
      letter-spacing: -.5px;
      color: var(--ink);
      margin-right: auto;
    }
    .nav-logo span { color: var(--accent); }
    .nav-logo i { font-size: 1rem; font-weight: 300; color: var(--ink-muted); }
    .nav-links { display: flex; gap: .25rem; }
    .nav-links a {
      padding: .4rem .85rem;
      border-radius: 6px;
      font-size: .875rem;
      font-weight: 500;
      color: var(--ink-muted);
      transition: background .15s, color .15s;
    }
    .nav-links a:hover, .nav-links a.active {
      background: var(--accent-light);
      color: var(--accent);
    }
    .nav-actions { display: flex; gap: .5rem; align-items: center; }
    .btn-icon {
      background: none; border: none;
      width: 38px; height: 38px;
      border-radius: 8px;
      display: flex; align-items: center; justify-content: center;
      color: var(--ink-muted); font-size: 1.1rem;
      transition: background .15s, color .15s;
    }
    .btn-icon:hover { background: var(--accent-light); color: var(--accent); }
    .btn-primary {
      background: var(--accent); color: #fff;
      border: none; border-radius: 8px;
      padding: .5rem 1.1rem;
      font-size: .875rem; font-weight: 500;
      transition: opacity .15s, transform .1s;
    }
    .btn-primary:hover { opacity: .88; transform: translateY(-1px); }

    /* HERO — full viewport */
    .hero {
      height: 100vh;
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      position: relative;
      overflow: hidden;
    }
    /* parallax background layer */
    .hero-bg {
      position: absolute;
      inset: -80px 0;
      background-image: url('images/wallhome.jpg');
      background-size: cover;
      background-position: center top;
      will-change: transform;
      transition: transform 0.05s linear;
    }
    /* dark overlay so text stays readable */
    .hero::before {
      content: '';
      position: absolute; inset: 0;
      background: linear-gradient(
        to bottom,
        rgba(10, 7, 5, 0.60) 0%,
        rgba(26, 14, 10, 0.72) 60%,
        rgba(74, 44, 36, 0.80) 100%
      );
      z-index: 1;
    }
    /* subtle vignette edges */
    .hero::after {
      content: '';
      position: absolute; inset: 0;
      background: radial-gradient(ellipse 90% 80% at 50% 50%, transparent 40%, rgba(0,0,0,0.55) 100%);
      z-index: 1;
      pointer-events: none;
    }
    .hero-content {
      position: relative;
      z-index: 2;
      max-width: 680px;
      margin: 0 auto;
      padding: 0 2rem;
      animation: fadeUp .9s .3s ease both;
    }
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(28px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .hero-eyebrow {
      font-size: .75rem;
      font-weight: 500;
      letter-spacing: .2em;
      text-transform: uppercase;
      color: #f0a899;
      margin-bottom: 1.25rem;
      opacity: .9;
    }
    .hero h1 {
      font-family: var(--font-display);
      font-size: clamp(2.4rem, 6vw, 3.8rem);
      font-weight: 700;
      line-height: 1.12;
      margin-bottom: 1.25rem;
    }
    .hero h1 em {
      color: #f0a899;
      font-style: normal;
    }
    .hero p {
      color: #c8b8b0;
      font-size: 1.05rem;
      max-width: 500px;
      margin: 0 auto 2.25rem;
    }
    .hero-actions {
      display: flex;
      gap: .75rem;
      justify-content: center;
      flex-wrap: wrap;
    }
    .btn-hero {
      background: var(--accent);
      color: #fff;
      border: none;
      border-radius: 8px;
      padding: .75rem 1.75rem;
      font-size: .95rem;
      font-weight: 600;
      letter-spacing: .02em;
      transition: opacity .15s, transform .12s, box-shadow .15s;
      box-shadow: 0 4px 20px rgba(192,57,43,.4);
    }
    .btn-hero:hover {
      opacity: .92;
      transform: translateY(-2px);
      box-shadow: 0 8px 28px rgba(192,57,43,.5);
    }
    .btn-hero-outline {
      background: transparent;
      color: #fff;
      border: 1.5px solid rgba(255,255,255,.35);
      border-radius: 8px;
      padding: .75rem 1.75rem;
      font-size: .95rem;
      font-weight: 500;
      transition: border-color .15s, background .15s;
    }
    .btn-hero-outline:hover {
      border-color: #fff;
      background: rgba(255,255,255,.08);
    }

    /* scroll hint */
    .scroll-hint {
      position: absolute;
      bottom: 2rem;
      left: 50%;
      transform: translateX(-50%);
      z-index: 2;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: .4rem;
      color: rgba(255,255,255,.3);
      font-size: .7rem;
      letter-spacing: .12em;
      text-transform: uppercase;
      animation: fadeUp 1s 1s ease both;
    }
    .scroll-hint svg {
      animation: bounce 1.6s ease-in-out infinite;
    }
    @keyframes bounce {
      0%,100% { transform: translateY(0); }
      50%      { transform: translateY(5px); }
    }

    @media(max-width:560px) {
      nav { padding: 0 1rem; }
      .nav-links { display: none; }
      .nav-logo i { display: none; }
    }
  </style>
</head>
<body>

<nav>
  <div class="nav-logo">The Nation's<span> Bookstore</span> &nbsp;<i>"Our Stories. Our Heritage. Our Bookstore."</i></div>
  <div class="nav-links">
    <a href="home.php" class="active">Home</a>
     <a href="index.php">Catalog</a>
    <a href="newarrivals.php">New Arrivals</a>
    <a href="bestsellers.php">Best Sellers</a>
    <a href="sale.php">Sale</a>
    <a href="about.php">About</a>
  </div>
  
  </div>
</nav>

<section class="hero">
  <div class="hero-bg" id="hero-bg"></div>
  <div class="hero-content">
    <div class="hero-eyebrow">Est. 2024 &nbsp;·&nbsp; Philippines</div>
    <h1>Your Next Favourite Book is <em>One Click Away</em></h1>
    <p>Browse some of your favorite titles — fiction, non-fiction, textbooks, and more. Delivered right to your door.</p>
    <div class="hero-actions">
      <button class="btn-hero" onclick="window.location.href='index.php'">Shop Now</button>
      <button class="btn-hero-outline" onclick="window.location.href='index.php'">Browse Categories</button>
    </div>
  </div>
  <div class="scroll-hint">
    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
  </div>
</section>

<script>
  const heroBg = document.getElementById('hero-bg');
  window.addEventListener('scroll', () => {
    const scrolled = window.scrollY;
    heroBg.style.transform = `translateY(${scrolled * 0.4}px)`;
  }, { passive: true });
</script>
</body>
</html>