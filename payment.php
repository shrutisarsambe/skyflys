<?php
// GET मधून amount आणि name घेऊ (booking.php ने पाठवलेले)
$amount = isset($_GET['amount']) ? (int) $_GET['amount'] : 0;
$name   = isset($_GET['name']) ? $_GET['name'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Payment - SkyFly</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>

<header class="navbar">
  <div class="logo">
    <div class="logo-icon">✈</div>
    <div class="logo-text">SkyFly <span>Airlines</span></div>
  </div>

  <nav class="nav-links">
    <a href="index.html" class="active">Home</a>
    <a href="login.html">Passenger Login</a>
    <a href="admin.html">Admin</a>
  </nav>
</header>

<section class="confirm-section">
  <div class="confirm-card">
    <h2>Payment</h2>

    <div class="confirm-details">
      <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
      <p><strong>Amount to Pay:</strong> ₹<?php echo $amount; ?></p>
    </div>

    <!-- CARD PAYMENT FORM -->
    <form action="confirm.php" method="GET">
      <!-- ही values confirm.php ला जातील -->
      <input type="hidden" name="name" value="<?php echo htmlspecialchars($name); ?>">
      <input type="hidden" name="price" value="<?php echo $amount; ?>">

      <label>Card Holder Name</label>
      <input type="text" name="card_name" placeholder="Name on card" required>

      <label>Card Number</label>
      <input type="text" name="card_number" maxlength="19" placeholder="XXXX-XXXX-XXXX-XXXX" required>

      <label>Expiry Date</label>
      <input type="month" name="expiry" required>

      <label>CVV</label>
      <input type="password" name="cvv" maxlength="4" required>

      <button type="submit" class="confirm-btn">Pay Now</button>
    </form>
  </div>
</section>

</body>
</html>