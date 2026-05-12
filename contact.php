<?php include_once 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>About — The Nation's Bookstore</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
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
      --radius:       10px;
      --font-display: 'Playfair Display', Georgia, serif;
      --font-body:    'DM Sans', sans-serif;
      --nav-h:        64px;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    body { background: var(--bg); color: var(--ink); font-family: var(--font-body); font-size: 15px; line-height: 1.6; min-height: 100vh; }
    a { color: inherit; text-decoration: none; }
    img { display: block; max-width: 100%; }
    button { cursor: pointer; font-family: var(--font-body); }

    /* NAV */
    nav { position: sticky; top: 0; z-index: 100; height: var(--nav-h); background: var(--surface); border-bottom: 1px solid var(--border); display: flex; align-items: center; padding: 0 2rem; gap: 1.5rem; box-shadow: 0 2px 12px var(--shadow); }
    .nav-logo { font-family: var(--font-display); font-size: 1.5rem; font-weight: 700; letter-spacing: -.5px; color: var(--ink); margin-right: auto; }
    .nav-logo span { color: var(--accent); }
    .nav-links { display: flex; gap: .25rem; }
    .nav-links a { padding: .4rem .85rem; border-radius: 6px; font-size: .875rem; font-weight: 500; color: var(--ink-muted); transition: background .15s, color .15s; }
    .nav-links a:hover, .nav-links a.active { background: var(--accent-light); color: var(--accent); }
    .nav-actions { display: flex; gap: .5rem; align-items: center; }
    .btn-icon { background: none; border: none; width: 38px; height: 38px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--ink-muted); font-size: 1.1rem; transition: background .15s, color .15s; }
    .btn-icon:hover { background: var(--accent-light); color: var(--accent); }
    .btn-primary { background: var(--accent); color: #fff; border: none; border-radius: 8px; padding: .5rem 1.1rem; font-size: .875rem; font-weight: 500; transition: opacity .15s, transform .1s; }
    .btn-primary:hover { opacity: .88; transform: translateY(-1px); }

    /* ABOUT SECTION */
    .about-wrap {
      max-width: 760px;
      margin: 5rem auto;
      padding: 3rem 3.5rem;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 16px;
      box-shadow: 0 4px 32px var(--shadow);
    }
    .about-label {
      font-size: .75rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .12em;
      color: var(--accent);
      margin-bottom: .75rem;
    }
    .about-wrap h1 {
      font-family: var(--font-display);
      font-size: clamp(1.8rem, 4vw, 2.6rem);
      font-weight: 700;
      line-height: 1.2;
      margin-bottom: 1.75rem;
      color: var(--ink);
    }
    .about-divider {
      width: 48px;
      height: 3px;
      background: var(--accent);
      border-radius: 2px;
      margin-bottom: 1.75rem;
    }
    .about-wrap p {
      font-size: 1.05rem;
      line-height: 1.85;
      color: var(--ink-muted);
      margin-bottom: 1.25rem;
    }
    .about-wrap p:last-child { margin-bottom: 0; }

    /* FOOTER */
    footer { background: var(--ink); color: rgba(255,255,255,.6); padding: 3rem 2rem 2rem; margin-top: 4rem; }
    .footer-grid { max-width: 1280px; margin: 0 auto; display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 2rem; padding-bottom: 2rem; border-bottom: 1px solid rgba(255,255,255,.1); }
    .footer-brand .nav-logo { font-size: 1.3rem; color: #fff; margin-bottom: .6rem; }
    .footer-brand p { font-size: .82rem; line-height: 1.6; }
    .footer-col h4 { color: #fff; font-size: .8rem; text-transform: uppercase; letter-spacing: .1em; margin-bottom: .75rem; }
    .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: .35rem; }
    .footer-col ul li a { font-size: .82rem; transition: color .12s; }
    .footer-col ul li a:hover { color: #f0a899; }
    .footer-bottom { max-width: 1280px; margin: 1.5rem auto 0; font-size: .78rem; text-align: center; }

    @media(max-width:620px) {
      .about-wrap { margin: 2rem 1rem; padding: 2rem 1.5rem; }
      nav { padding: 0 1rem; }
      .nav-links { display: none; }
      .footer-grid { grid-template-columns: 1fr; }
    }
  </style>
  
</head>
<body>

<nav>
  <div class="nav-logo">The Nation's<span> Bookstore</span></div>
  <div class="nav-links">
    <a href="home.php">Home</a>
    <a href="index.php">Catalog</a>
    <a href="newarrivals.php">New Arrivals</a>
    <a href="bestsellers.php">Best Sellers</a>
    <a href="sale.php">Sale</a>
    <a href="about.php" class="active">About</a>
  </div>
  <div class="nav-actions">
    <button class="btn-icon" title="Search">
      <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
    </button>
  </div>
</nav>

<main>
  <div class="about-wrap">
    <div class="about-label">Contact Us</div>
    <h1>Contact Us!</h1>
    <div class="about-divider"></div>
    <p>Reach out to our bibliophile support team at <b>hello@nationsbookstore.com</b> or via our Live Chat from 9 AM – 5 PM EST.</p>
    <p>Whether you have a question about an order, need book recommendations, or just want to chat about your latest read, we're here to help. We aim to respond to all inquiries within 24 hours on business days.</p>
    <p>For urgent matters, please call us at (+63)977-123-4567. We look forward to connecting with you!</p>
  </div>
</main>

<footer>
  <div class="footer-grid">
    <div class="footer-brand">
      <div class="nav-logo">The Nation's<span style="color:#f0a899"> Bookstore</span></div>
      <p>Your trusted online bookstore. Discover, explore, and fall in love with reading — one book at a time.</p>
      <p><i>"Our Stories. Our Heritage. Our Bookstore."</i></p>
    </div>
    <div class="footer-col">
      <h4>Shop</h4>
      <ul>
        <li><a href="newarrivals.php">New Arrivals</a></li>
        <li><a href="bestsellers.php">Best Sellers</a></li>
        <li><a href="sale.php">Sale</a></li>
        
      </ul>
    </div>
    <div class="footer-col">
      <h4>Help</h4>
      <ul>
        <li><a href="#">FAQ</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Company</h4>
      <ul>
        <li><a href="about.php">About Us</a></li>
        <li><a href="contact.php">Contact</a></li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">&copy; 2025 The Nation's Bookstore. All rights reserved.</div>
</footer>

</body>
</html>
