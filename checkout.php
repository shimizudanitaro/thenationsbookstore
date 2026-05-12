<?php include_once 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Checkout — The Nation's Bookstore</title>
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
    body { background: var(--bg); color: var(--ink); font-family: var(--font-body); font-size: 15px; line-height: 1.6; min-height: 100vh; }
    
    /* NAV (Matching your current design) */
    nav { position: sticky; top: 0; z-index: 100; height: var(--nav-h); background: var(--surface); border-bottom: 1px solid var(--border); display: flex; align-items: center; padding: 0 2rem; gap: 1.5rem; box-shadow: 0 2px 12px var(--shadow); }
    .nav-logo { font-family: var(--font-display); font-size: 1.5rem; font-weight: 700; color: var(--ink); margin-right: auto; }
    .nav-logo span { color: var(--accent); }
    .nav-links a { padding: .4rem .85rem; border-radius: 6px; font-size: .875rem; font-weight: 500; color: var(--ink-muted); text-decoration: none; }

    /* LAYOUT */
    .checkout-container { max-width: 1100px; margin: 4rem auto; padding: 0 2rem; display: grid; grid-template-columns: 1.5fr 1fr; gap: 3rem; }
    
    /* FORM STYLES */
    .checkout-card { background: var(--surface); padding: 2.5rem; border-radius: 16px; border: 1px solid var(--border); box-shadow: 0 4px 32px var(--shadow); }
    .checkout-card h1 { font-family: var(--font-display); font-size: 1.8rem; margin-bottom: 1.5rem; }
    .form-group { margin-bottom: 1.25rem; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    label { display: block; font-size: .85rem; font-weight: 600; margin-bottom: .5rem; color: var(--ink-muted); }
    input, textarea { width: 100%; padding: .75rem; border: 1px solid var(--border); border-radius: 8px; font-family: var(--font-body); font-size: .95rem; outline: none; transition: border-color .15s; }
    input:focus, textarea:focus { border-color: var(--accent); }
    
    /* ORDER SUMMARY */
    .summary-card { background: var(--surface); padding: 2rem; border-radius: 16px; border: 1px solid var(--border); height: fit-content; position: sticky; top: 100px; }
    .summary-card h2 { font-family: var(--font-display); font-size: 1.4rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border); padding-bottom: 1rem; }
    .summary-item { display: flex; justify-content: space-between; margin-bottom: .75rem; font-size: .9rem; }
    .summary-total { display: flex; justify-content: space-between; margin-top: 1.5rem; padding-top: 1rem; border-top: 2px solid var(--border); font-family: var(--font-display); font-size: 1.25rem; font-weight: 700; }
    
    .btn-submit { width: 100%; background: var(--accent); color: #fff; border: none; border-radius: 9px; padding: 1rem; font-size: 1rem; font-weight: 600; margin-top: 2rem; cursor: pointer; transition: opacity .15s; }
    .btn-submit:hover { opacity: 0.9; }

    @media (max-width: 850px) { .checkout-container { grid-template-columns: 1fr; } .summary-card { position: static; } }
  </style>
</head>
<body>

<nav>
  <div class="nav-logo">The Nation's<span> Bookstore</span></div>
  <div class="nav-links"><a href="index.php">Return to Catalog</a></div>
</nav>

<main class="checkout-container">
  <section class="checkout-form">
    <div class="checkout-card">
      <h1>Shipping Information</h1>
      <form id="checkout-form">
        <div class="form-row">
          <div class="form-group">
            <label for="first-name">First Name</label>
            <input type="text" id="first-name" name="first_name" required placeholder="John">
          </div>
          <div class="form-group">
            <label for="last-name">Last Name</label>
            <input type="text" id="last-name" name="last_name" required placeholder="Doe">
          </div>
           <div class="form-group">
            <label for="email-address">Email Address</label>
            <input type="email" id="email-address" name="email" required placeholder="john.doe@example.com">
          </div>
        </div>
        
        <div class="form-group">
          <label for="contact">Contact Number</label>
          <input type="tel" id="contact" name="contact" required placeholder="09XX-XXX-XXXX">
        </div>
        
        <div class="form-group">
          <label for="address">Full Address</label>
          <textarea id="address" name="address" rows="4" required placeholder="Street, Barangay, City, Province, Zip Code"></textarea>
        </div>

        <button type="submit" class="btn-submit">Complete Purchase</button>
      </form>
    </div>
  </section>

  <aside class="summary-card">
    <h2>Order Summary</h2>
    <div id="checkout-items-list">
        </div>
    
    <div class="summary-item" style="margin-top: 2rem;">
      <span>Subtotal</span>
      <span id="summary-subtotal">PHP 0.00</span>
    </div>
    <div class="summary-item">
      <span>Shipping</span>
      <span style="color: var(--accent); font-weight: 600;">FREE</span>
    </div>
    <div class="summary-total">
      <span>Total</span>
      <span id="summary-total">PHP 0.00</span>
    </div>
  </aside>
</main>

<script>
// This function runs when the page loads to show the items
function loadSummary() {
    const storedData = localStorage.getItem('bookstore_cart');
    const cart = storedData ? JSON.parse(storedData) : [];
    const container = document.getElementById('checkout-items-list');
    let total = 0;

    if (cart.length === 0) {
        container.innerHTML = '<p>Your cart is empty.</p>';
        return;
    }

    container.innerHTML = cart.map(item => {
        const itemTotal = item.book.price * item.qty;
        total += itemTotal;
        return `
            <div class="summary-item">
                <span>${item.book.title} (x${item.qty})</span>
                <span>PHP ${itemTotal.toLocaleString()}</span>
            </div>`;
    }).join('');

    document.getElementById('summary-total').textContent = 'PHP ' + total.toLocaleString();
}

// THIS IS THE STEP 3 CODE: Handles the "Complete Purchase" button
document.getElementById('checkout-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Create the data to send to the server
    const formData = new FormData(this);
    // Grab the cart from storage so the email knows what was bought
    formData.append('cart_data', localStorage.getItem('bookstore_cart')); 

    // Send the data to your new PHP processor
    fetch('process_order.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'success') {
            alert('Order Complete! Check your email for the receipt.');
            localStorage.removeItem('bookstore_cart'); // Clear the cart after success
            window.location.href = 'home.php'; // Redirect back to home
        } else {
            alert('Error processing order: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('There was a problem connecting to the server.');
    });
});

// Initialize the summary display
loadSummary();
</script>

</body>
</html>