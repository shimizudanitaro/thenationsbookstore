<?php include_once 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>The Nation's Bookstore — Online Bookstore</title>
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
    nav { position: sticky; top: 0; z-index: 100; height: var(--nav-h); background: var(--surface); border-bottom: 1px solid var(--border); display: flex; align-items: center; padding: 0 2rem; gap: 1.5rem; box-shadow: 0 2px 12px var(--shadow); }
    .nav-logo { font-family: var(--font-display); font-size: 1.5rem; font-weight: 700; letter-spacing: -.5px; color: var(--ink); margin-right: auto; }
    .nav-logo span { color: var(--accent); }
    .nav-links { display: flex; gap: .25rem; }
    .nav-links a { padding: .4rem .85rem; border-radius: 6px; font-size: .875rem; font-weight: 500; color: var(--ink-muted); transition: background .15s, color .15s; }
    .nav-links a:hover, .nav-links a.active { background: var(--accent-light); color: var(--accent); }
    .nav-actions { display: flex; gap: .5rem; align-items: center; }
    .btn-icon { background: none; border: none; width: 38px; height: 38px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--ink-muted); font-size: 1.1rem; transition: background .15s, color .15s; position: relative; }
    .btn-icon:hover { background: var(--accent-light); color: var(--accent); }
    .cart-badge { position: absolute; top: 2px; right: 2px; background: var(--accent); color: #fff; font-size: .6rem; font-weight: 700; width: 16px; height: 16px; border-radius: 50%; display: none; align-items: center; justify-content: center; }
    .btn-primary { background: var(--accent); color: #fff; border: none; border-radius: 8px; padding: .5rem 1.1rem; font-size: .875rem; font-weight: 500; transition: opacity .15s, transform .1s; }
    .btn-primary:hover { opacity: .88; transform: translateY(-1px); }
    .hero { color: #fff; padding: 5rem 2rem 4rem; text-align: center; position: relative; overflow: hidden; }
    .hero-bg { position: absolute; inset: -80px 0; background-image: url('images/wallhome.jpg'); background-size: cover; background-position: center; will-change: transform; }
    .hero::before { content: ''; position: absolute; inset: 0; z-index: 1; background: linear-gradient(to bottom, rgba(10,7,5,0.62) 0%, rgba(26,14,10,0.75) 60%, rgba(74,44,36,0.82) 100%); }
    .hero::after { content: ''; position: absolute; inset: 0; z-index: 1; background: radial-gradient(ellipse 90% 80% at 50% 50%, transparent 40%, rgba(0,0,0,0.5) 100%); pointer-events: none; }
    .hero-content { position: relative; z-index: 2; max-width: 640px; margin: 0 auto; }
    .hero h1 { font-family: var(--font-display); font-size: clamp(2.2rem, 5vw, 3.4rem); font-weight: 700; line-height: 1.15; margin-bottom: 1rem; }
    .hero h1 em { color: #f0a899; font-style: normal; }
    .hero p { color: #c8b8b0; font-size: 1.05rem; margin-bottom: 2rem; }
    .hero-actions { display: flex; gap: .75rem; justify-content: center; flex-wrap: wrap; }
    .btn-hero-outline { background: transparent; color: #fff; border: 1.5px solid rgba(255,255,255,.35); border-radius: 8px; padding: .65rem 1.4rem; font-size: .9rem; font-weight: 500; transition: border-color .15s, background .15s; }
    .btn-hero-outline:hover { border-color: #fff; background: rgba(255,255,255,.08); }
    .toolbar { background: var(--surface); border-bottom: 1px solid var(--border); padding: .85rem 2rem; display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
    .search-wrap { flex: 1; min-width: 200px; position: relative; }
    .search-wrap svg { position: absolute; left: .75rem; top: 50%; transform: translateY(-50%); color: var(--ink-muted); pointer-events: none; }
    .search-wrap input { width: 100%; padding: .55rem .75rem .55rem 2.25rem; border: 1px solid var(--border); border-radius: 8px; background: var(--bg); font-family: var(--font-body); font-size: .875rem; color: var(--ink); outline: none; transition: border-color .15s; }
    .search-wrap input:focus { border-color: var(--accent); }
    .filter-select { padding: .55rem .85rem; border: 1px solid var(--border); border-radius: 8px; background: var(--bg); font-family: var(--font-body); font-size: .875rem; color: var(--ink); outline: none; cursor: pointer; transition: border-color .15s; }
    .filter-select:focus { border-color: var(--accent); }
    .results-count { font-size: .8rem; color: var(--ink-muted); margin-left: auto; white-space: nowrap; }
    .main-wrap { max-width: 1280px; margin: 0 auto; padding: 2rem; display: flex; gap: 2rem; }
    .sidebar { width: 220px; flex-shrink: 0; }
    .sidebar-section { margin-bottom: 1.75rem; }
    .sidebar-section h3 { font-family: var(--font-display); font-size: .875rem; font-weight: 600; text-transform: uppercase; letter-spacing: .08em; color: var(--ink-muted); margin-bottom: .6rem; }
    .category-list { display: flex; flex-direction: column; gap: .1rem; }
    .category-btn { background: none; border: none; text-align: left; padding: .4rem .65rem; border-radius: 6px; font-size: .875rem; color: var(--ink-muted); transition: background .12s, color .12s; display: flex; justify-content: space-between; align-items: center; }
    .category-btn:hover, .category-btn.active { background: var(--accent-light); color: var(--accent); }
    .category-btn .cat-count { font-size: .75rem; opacity: .7; }
    .price-inputs { display: flex; gap: .4rem; align-items: center; }
    .price-inputs input { width: 80px; padding: .4rem .5rem; border: 1px solid var(--border); border-radius: 6px; background: var(--bg); font-family: var(--font-body); font-size: .8rem; color: var(--ink); outline: none; }
    .price-inputs span { font-size: .8rem; color: var(--ink-muted); }
    .price-apply { margin-top: .5rem; width: 100%; padding: .4rem; border: 1.5px solid var(--accent); background: none; color: var(--accent); border-radius: 6px; font-size: .8rem; font-weight: 500; transition: background .12s, color .12s; }
    .price-apply:hover { background: var(--accent); color: #fff; }
    .catalog { flex: 1; }
    .section-title { font-family: var(--font-display); font-size: 1.5rem; font-weight: 600; margin-bottom: 1.25rem; }
    .book-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(185px, 1fr)); gap: 1.25rem; }
    .book-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; transition: box-shadow .2s, transform .2s; display: flex; flex-direction: column; }
    .book-card:hover { box-shadow: 0 8px 28px var(--shadow); transform: translateY(-3px); }
    .book-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    /* Start at 1.2x zoom so there is 'room' to zoom out */
    transform: scale(1.0); 
    transition: transform 0.5s cubic-bezier(0.25, 1, 0.5, 1);
}

/* 3. Hover state: Image zooms OUT to 1.0 (full view) */
.book-card:hover .book-cover img {
    transform: scale(0.5);
}
    .cover-placeholder { width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: .4rem; font-family: var(--font-display); font-size: .75rem; font-weight: 600; text-align: center; padding: .75rem; color: #fff; }
    .cover-placeholder .cover-icon { font-size: 2rem; opacity: .6; }
    .badge-new { position: absolute; top: .6rem; left: .6rem; background: var(--accent); color: #fff; font-size: .65rem; font-weight: 700; padding: .15rem .45rem; border-radius: 4px; text-transform: uppercase; letter-spacing: .06em; }
    .book-info { padding: .85rem; flex: 1; display: flex; flex-direction: column; gap: .2rem; }
    .book-title { font-family: var(--font-display); font-size: .95rem; font-weight: 600; line-height: 1.25; }
    .book-author { font-size: .78rem; color: var(--ink-muted); }
    .book-genre { font-size: .7rem; font-weight: 500; color: var(--accent); text-transform: uppercase; letter-spacing: .06em; margin-top: .1rem; }
    .book-price { font-size: 1.1rem; font-weight: 700; color: var(--ink); margin-top: auto; padding-top: .5rem; }
    .book-price .original { font-size: .8rem; color: var(--ink-muted); text-decoration: line-through; font-weight: 400; margin-left: .3rem; }
    .book-card-actions { padding: .65rem .85rem; border-top: 1px solid var(--border); display: flex; gap: .5rem; }
    .btn-cart { flex: 1; background: var(--ink); color: #fff; border: none; border-radius: 7px; padding: .45rem .5rem; font-size: .8rem; font-weight: 500; transition: background .15s; }
    .btn-cart:hover { background: var(--accent); }
    .btn-wish { background: none; border: 1.5px solid var(--border); border-radius: 7px; padding: .4rem .55rem; color: var(--ink-muted); font-size: .9rem; transition: border-color .12s, color .12s; }
    .btn-wish:hover { border-color: var(--accent); color: var(--accent); }
    .cart-overlay { display: none; position: fixed; inset: 0; z-index: 200; background: rgba(26,20,16,.4); }
    .cart-overlay.open { display: block; }
    .cart-drawer { position: fixed; top: 0; right: -420px; bottom: 0; z-index: 201; width: 400px; max-width: 95vw; background: var(--surface); box-shadow: -4px 0 30px var(--shadow); display: flex; flex-direction: column; transition: right .3s ease; }
    .cart-drawer.open { right: 0; }
    .cart-drawer-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; }
    .cart-drawer-header h2 { font-family: var(--font-display); font-size: 1.25rem; }
    .btn-close { background: none; border: none; font-size: 1.3rem; color: var(--ink-muted); width: 34px; height: 34px; border-radius: 6px; display: flex; align-items: center; justify-content: center; transition: background .12s; }
    .btn-close:hover { background: var(--bg); }
    .cart-items { flex: 1; overflow-y: auto; padding: 1rem 1.5rem; }
    .cart-empty { text-align: center; color: var(--ink-muted); padding: 3rem 0; font-size: .9rem; }
    .cart-item { display: flex; gap: 1rem; align-items: flex-start; padding: .85rem 0; border-bottom: 1px solid var(--border); }
    .cart-item-cover { width: 52px; height: 70px; border-radius: 5px; flex-shrink: 0; overflow: hidden; background: var(--bg); display: flex; align-items: center; justify-content: center; font-size: 1.4rem; }
    .cart-item-info { flex: 1; }
    .cart-item-title { font-family: var(--font-display); font-size: .9rem; font-weight: 600; }
    .cart-item-author { font-size: .75rem; color: var(--ink-muted); margin-bottom: .4rem; }
    .cart-item-qty { display: flex; align-items: center; gap: .4rem; }
    .qty-btn { background: var(--bg); border: 1px solid var(--border); border-radius: 5px; width: 26px; height: 26px; display: flex; align-items: center; justify-content: center; font-size: .9rem; font-weight: 500; color: var(--ink); transition: background .12s; }
    .qty-btn:hover { background: var(--accent-light); color: var(--accent); }
    .qty-val { font-size: .85rem; font-weight: 500; min-width: 20px; text-align: center; }
    .cart-item-price { font-weight: 700; font-size: .95rem; }
    .cart-item-remove { background: none; border: none; color: var(--ink-muted); font-size: .8rem; padding: .15rem .3rem; border-radius: 4px; transition: color .1s; }
    .cart-item-remove:hover { color: var(--accent); }
    .cart-footer { padding: 1.25rem 1.5rem; border-top: 1px solid var(--border); }
    .cart-subtotal { display: flex; justify-content: space-between; font-size: .9rem; margin-bottom: .35rem; }
    .cart-subtotal.total { font-family: var(--font-display); font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem; }
    .btn-checkout { width: 100%; background: var(--accent); color: #fff; border: none; border-radius: 9px; padding: .85rem; font-size: .95rem; font-weight: 600; letter-spacing: .02em; transition: opacity .15s, transform .1s; }
    .btn-checkout:hover { opacity: .88; transform: translateY(-1px); }
    footer { background: var(--ink); color: rgba(255,255,255,.6); padding: 3rem 2rem 2rem; margin-top: 4rem; }
    .footer-grid { max-width: 1280px; margin: 0 auto; display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 2rem; padding-bottom: 2rem; border-bottom: 1px solid rgba(255,255,255,.1); }
    .footer-brand .nav-logo { font-size: 1.3rem; color: #fff; margin-bottom: .6rem; }
    .footer-brand p { font-size: .82rem; line-height: 1.6; }
    .footer-col h4 { color: #fff; font-size: .8rem; text-transform: uppercase; letter-spacing: .1em; margin-bottom: .75rem; }
    .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: .35rem; }
    .footer-col ul li a { font-size: .82rem; transition: color .12s; }
    .footer-col ul li a:hover { color: #f0a899; }
    .footer-bottom { max-width: 1280px; margin: 1.5rem auto 0; font-size: .78rem; text-align: center; }
    .skeleton-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(185px, 1fr)); gap: 1.25rem; margin-bottom: 1.5rem; }
    .skeleton-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; animation: shimmer 1.4s ease-in-out infinite; }
    .skeleton-cover { height: 200px; background: var(--border); }
    .skeleton-body { padding: .85rem; }
    .skeleton-line { height: 12px; border-radius: 4px; background: var(--border); margin-bottom: .6rem; }
    .skeleton-line.short { width: 60%; }
    @keyframes shimmer { 0%,100%{opacity:1} 50%{opacity:.55} }
    .toast-container { position: fixed; bottom: 1.5rem; right: 1.5rem; z-index: 300; display: flex; flex-direction: column; gap: .5rem; }
    .toast { background: var(--ink); color: #fff; padding: .7rem 1.1rem; border-radius: 8px; font-size: .85rem; box-shadow: 0 4px 16px rgba(0,0,0,.25); animation: toastIn .25s ease, toastOut .3s ease 2.5s forwards; }
    @keyframes toastIn  { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:none} }
    @keyframes toastOut { from{opacity:1} to{opacity:0;transform:translateY(6px)} }
    @media(max-width:820px){.sidebar{display:none}.footer-grid{grid-template-columns:1fr 1fr}}
    @media(max-width:560px){nav{padding:0 1rem}.nav-links{display:none}.hero{padding:3rem 1rem 2.5rem}.main-wrap{padding:1rem}.footer-grid{grid-template-columns:1fr}}
  </style>
</head>
<body>

<nav>
  <div class="nav-logo">The Nation's<span> Bookstore</span> | <i>"Our Stories. Our Heritage. Our Bookstore."</i></div>
  <div class="nav-links">
    <a href="home.php">Home</a>
    <a href="index.php">Catalog</a>
    <a href="newarrivals.php">New Arrivals</a>
    <a href="sale.php">Sale</a>
    <a href="about.php" class="active">About</a>
  </div>
  <div class="nav-actions">
    <button class="btn-icon" title="Search" onclick="document.querySelector('.search-wrap input').focus()">
      <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
    </button>
    <button class="btn-icon" title="Cart" onclick="openCart()" id="cart-btn">
      <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
      <span class="cart-badge" id="cart-badge">0</span>
    </button>
  </div>
</nav>

<section class="hero">
  <div class="hero-bg" id="hero-bg"></div>
  <div class="hero-content">
    <h1>Your Next Favourite Book is <em>One Click Away</em></h1>
    <p>Browse to some of your favorite titles — fiction, non-fiction, textbooks, and more. Delivered right to your door.</p>
    <div class="hero-actions">
      <button class="btn-primary" onclick="document.querySelector('.main-wrap').scrollIntoView({behavior:'smooth'})">Shop Now</button>
      <button class="btn-hero-outline">Browse Categories</button>
    </div>
  </div>
</section>

<div class="toolbar">
  <div class="search-wrap">
    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
    <input type="text" id="search-input" placeholder="Search by title, author, ISBN…" oninput="filterBooks()">
  </div>
  <select class="filter-select" id="genre-select" onchange="filterBooks()">
    <option value="">All Genres</option>
    <option value="Fiction">Fiction</option>
    <option value="Non-Fiction">Non-Fiction</option>
    <option value="Science">Science</option>
    <option value="History">History</option>
    <option value="Fantasy">Fantasy</option>
    <option value="Mystery">Mystery</option>
    <option value="Romance">Romance</option>
    <option value="Biography">Biography</option>
    <option value="Self-Help">Self-Help</option>
    <option value="Technology">Technology</option>
  </select>
  <select class="filter-select" id="sort-select" onchange="filterBooks()">
    <option value="default">Sort: Default</option>
    <option value="price-asc">Price: Low to High</option>
    <option value="price-desc">Price: High to Low</option>
    <option value="title-asc">Title: A-Z</option>
    <option value="title-desc">Title: Z-A</option>
  </select>
  <span class="results-count" id="results-count"></span>
</div>

<div class="main-wrap">
  <aside class="sidebar">
    <div class="sidebar-section">
      <h3>Category</h3>
      <div class="category-list" id="category-list"></div>
    </div>
    <div class="sidebar-section">
      <h3>Price Range (PHP)</h3>
      <div class="price-inputs">
        <input type="number" id="price-min" placeholder="Min" min="0">
        <span>-</span>
        <input type="number" id="price-max" placeholder="Max" min="0">
      </div>
      <button class="price-apply" onclick="filterBooks()">Apply</button>
    </div>
  </aside>
  <main class="catalog">
    <h2 class="section-title">All Books</h2>
    <div class="skeleton-grid" id="skeleton-loader">
      <div class="skeleton-card"><div class="skeleton-cover"></div><div class="skeleton-body"><div class="skeleton-line"></div><div class="skeleton-line short"></div><div class="skeleton-line short"></div></div></div>
      <div class="skeleton-card"><div class="skeleton-cover"></div><div class="skeleton-body"><div class="skeleton-line"></div><div class="skeleton-line short"></div><div class="skeleton-line short"></div></div></div>
      <div class="skeleton-card"><div class="skeleton-cover"></div><div class="skeleton-body"><div class="skeleton-line"></div><div class="skeleton-line short"></div><div class="skeleton-line short"></div></div></div>
      <div class="skeleton-card"><div class="skeleton-cover"></div><div class="skeleton-body"><div class="skeleton-line"></div><div class="skeleton-line short"></div><div class="skeleton-line short"></div></div></div>
      <div class="skeleton-card"><div class="skeleton-cover"></div><div class="skeleton-body"><div class="skeleton-line"></div><div class="skeleton-line short"></div><div class="skeleton-line short"></div></div></div>
      <div class="skeleton-card"><div class="skeleton-cover"></div><div class="skeleton-body"><div class="skeleton-line"></div><div class="skeleton-line short"></div><div class="skeleton-line short"></div></div></div>
    </div>
    <div class="book-grid" id="book-grid"></div>
  </main>
</div>

<div class="cart-overlay" id="cart-overlay" onclick="closeCart()"></div>
<div class="cart-drawer" id="cart-drawer">
  <div class="cart-drawer-header">
    <h2>Your Cart</h2>
    <button class="btn-close" onclick="closeCart()">X</button>
  </div>
  <div class="cart-items" id="cart-items">
    <div class="cart-empty">Your cart is empty.</div>
  </div>
  <div class="cart-footer">
    <div class="cart-subtotal"><span>Subtotal</span><span id="cart-subtotal">PHP 0.00</span></div>
    <div class="cart-subtotal"><span>Shipping</span><span>Free</span></div>
    <div class="cart-subtotal total"><span>Total</span><span id="cart-total">PHP 0.00</span></div>
    <button class="btn-checkout" onclick="window.location.href='checkout.php'">Proceed to Checkout</button>
  </div>
</div>

<div class="toast-container" id="toast-container"></div>

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

<?php
  $result = mysqli_query($conn, "SELECT * FROM books WHERE is_bestseller = 1 ORDER BY id DESC");
  $books = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $books[] = [
      'id'            => (int)$row['id'],
      'title'         => $row['title'],
      'author'        => $row['author'],
      'genre'         => $row['genre'],
      'price'         => (float)$row['price'],
      'originalPrice' => $row['original_price'] ? (float)$row['original_price'] : null,
      'coverColor'    => $row['cover_color'],
      'cover'         => $row['image'], // MUST match the database column name exactly
      'isNew'         => (bool)$row['is_new'],
    ];
  }
?>
<script>
const allBooks = <?php echo json_encode($books); ?>;
// This checks if there is already a cart saved in the browser
let cart = JSON.parse(localStorage.getItem('bookstore_cart')) || [];

// Call updateCartUI once on page load to show existing items
window.addEventListener('DOMContentLoaded', updateCartUI);

function init() {
  document.getElementById('skeleton-loader').style.display = 'none';
  buildCategoryList();
  renderBooks(allBooks);
}

function buildCategoryList() {
  const genres = ['All', ...new Set(allBooks.map(b => b.genre))].sort();
  const container = document.getElementById('category-list');
  container.innerHTML = '';
  genres.forEach(g => {
    const count = g === 'All' ? allBooks.length : allBooks.filter(b => b.genre === g).length;
    const btn = document.createElement('button');
    btn.className = 'category-btn' + (g === 'All' ? ' active' : '');
    btn.innerHTML = g + '<span class="cat-count">' + count + '</span>';
    btn.addEventListener('click', () => {
      document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      document.getElementById('genre-select').value = g === 'All' ? '' : g;
      filterBooks();
    });
    container.appendChild(btn);
  });
}

function filterBooks() {
  const query = document.getElementById('search-input').value.toLowerCase();
  const genre = document.getElementById('genre-select').value;
  const sort  = document.getElementById('sort-select').value;
  const minP  = parseFloat(document.getElementById('price-min').value) || 0;
  const maxP  = parseFloat(document.getElementById('price-max').value) || Infinity;

  let filtered = allBooks.filter(b => {
    return (b.title.toLowerCase().includes(query) || b.author.toLowerCase().includes(query))
      && (!genre || b.genre === genre)
      && b.price >= minP && b.price <= maxP;
  });

  if (sort === 'price-asc')  filtered.sort((a,b) => a.price - b.price);
  if (sort === 'price-desc') filtered.sort((a,b) => b.price - a.price);
  if (sort === 'title-asc')  filtered.sort((a,b) => a.title.localeCompare(b.title));
  if (sort === 'title-desc') filtered.sort((a,b) => b.title.localeCompare(a.title));

  document.getElementById('results-count').textContent =
    filtered.length + ' result' + (filtered.length !== 1 ? 's' : '');

  renderBooks(filtered);
}

function fmtPrice(n) {
  return 'PHP ' + n.toLocaleString('en-PH', { minimumFractionDigits: 2 });
}

function renderBooks(books) {
  const grid = document.getElementById('book-grid');
  if (!books.length) {
    grid.innerHTML = '<p style="color:var(--ink-muted);grid-column:1/-1;text-align:center;padding:3rem 0">No books found. Try adjusting your filters.</p>';
    return;
  }
  grid.innerHTML = books.map(b => `
    <div class="book-card">
      <div class="book-cover">
        ${b.cover ? `<img src="${b.cover}" alt="${b.title}" loading="lazy">` :
          `<div class="cover-placeholder" style="background:${b.coverColor}">
             <span class="cover-icon">${b.coverEmoji}</span>
             <span>${b.title}</span>
           </div>`}
        ${b.isNew ? '<span class="badge-new">New</span>' : ''}
      </div>
      <div class="book-info">
        <div class="book-genre">${b.genre}</div>
        <div class="book-title">${b.title}</div>
        <div class="book-author">${b.author}</div>
        <div class="book-price">${fmtPrice(b.price)}${b.originalPrice ? `<span class="original">${fmtPrice(b.originalPrice)}</span>` : ''}</div>
      </div>
      <div class="book-card-actions">
        <button class="btn-cart" onclick="addToCart(${b.id})">Add to Cart</button>
        <button class="btn-wish" title="Wishlist">&#9825;</button>
      </div>
    </div>
  `).join('');
}

function addToCart(id) {
  const book = allBooks.find(b => b.id === id);
  if (!book) return;
  const ex = cart.find(c => c.book.id === id);
  if (ex) ex.qty++; else cart.push({ book, qty: 1 });
  updateCartUI();
  showToast('"' + book.title + '" added to cart');
}

function removeFromCart(id) {
  cart = cart.filter(c => c.book.id !== id);
  updateCartUI();
}

function changeQty(id, delta) {
  const item = cart.find(c => c.book.id === id);
  if (!item) return;
  item.qty += delta;
  if (item.qty <= 0) removeFromCart(id); else updateCartUI();
}

function updateCartUI() {
  const total = cart.reduce((s,c) => s + c.book.price * c.qty, 0);
  const count = cart.reduce((s,c) => s + c.qty, 0);
  localStorage.setItem('bookstore_cart', JSON.stringify(cart));
  const badge = document.getElementById('cart-badge');
  badge.textContent = count;
  badge.style.display = count > 0 ? 'flex' : 'none';
  document.getElementById('cart-subtotal').textContent = fmtPrice(total);
  document.getElementById('cart-total').textContent    = fmtPrice(total);
  const container = document.getElementById('cart-items');
  if (!cart.length) { container.innerHTML = '<div class="cart-empty">Your cart is empty.</div>'; return; }
  container.innerHTML = cart.map(({book, qty}) => `
    <div class="cart-item">
      <div class="cart-item-cover" style="background:${book.coverColor||'var(--bg)'}">
        ${book.cover ? `<img src="${book.cover}" alt="" style="width:100%;height:100%;object-fit:cover">` : book.coverEmoji}
      </div>
      <div class="cart-item-info">
        <div class="cart-item-title">${book.title}</div>
        <div class="cart-item-author">${book.author}</div>
        <div class="cart-item-qty">
          <button class="qty-btn" onclick="changeQty(${book.id},-1)">-</button>
          <span class="qty-val">${qty}</span>
          <button class="qty-btn" onclick="changeQty(${book.id},+1)">+</button>
          <span style="margin-left:auto" class="cart-item-price">${fmtPrice(book.price*qty)}</span>
        </div>
      </div>
      <button class="cart-item-remove" onclick="removeFromCart(${book.id})">X</button>
    </div>
  `).join('');
}

function openCart()  { document.getElementById('cart-overlay').classList.add('open'); document.getElementById('cart-drawer').classList.add('open'); }
function closeCart() { document.getElementById('cart-overlay').classList.remove('open'); document.getElementById('cart-drawer').classList.remove('open'); }

function showToast(msg) {
  const tc = document.getElementById('toast-container');
  const t = document.createElement('div');
  t.className = 'toast'; t.textContent = msg;
  tc.appendChild(t);
  setTimeout(() => t.remove(), 2900);
}

init();

const heroBg = document.getElementById('hero-bg');
window.addEventListener('scroll', () => {
  heroBg.style.transform = `translateY(${window.scrollY * 0.4}px)`;
}, { passive: true });
</script>
</body>
</html>