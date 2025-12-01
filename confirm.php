<?php
// नाव आणि रक्कम GET मधून घेउया
$name  = isset($_GET['name']) ? $_GET['name'] : 'Customer';
$price = isset($_GET['price']) ? (int)$_GET['price'] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Payment Confirmation - SkyFly</title>
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
    <h2>Payment Successful!</h2>
    <p>Thank you, <strong><?php echo htmlspecialchars($name); ?></strong>.</p>

    <div class="confirm-details">
      <p><strong>Amount Paid:</strong> ₹<?php echo $price; ?></p>
      <p><strong>Status:</strong> Payment completed.</p>
    </div>

    <a href="index.html" class="confirm-btn">Back to Home</a>
  </div>
</section>

</body>
</html>