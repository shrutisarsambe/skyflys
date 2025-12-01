<?php
$amount = isset($_GET['amount']) ? (int) $_GET['amount'] : 0;
$name   = isset($_GET['name']) ? $_GET['name'] : '';
$cashId = "CASH" . rand(100000, 999999);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Cash Payment - SkyFly</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <section class="confirm-section">
    <div class="confirm-card">
      <h2>Cash Payment Confirmed!</h2>
      <p>Thank you, <strong><?php echo htmlspecialchars($name); ?></strong>.</p>

      <div class="confirm-details">
        <p><strong>Amount to Pay at Counter:</strong> ₹<?php echo $amount; ?></p>
        <p><strong>Cash Transaction ID:</strong> <?php echo $cashId; ?></p>
        <p><strong>Status:</strong> Pending – Pay at Airport Counter</p>
      </div>

      <a href="index.html" class="confirm-btn">Back to Home</a>
    </div>
  </section>
</body>
</html>