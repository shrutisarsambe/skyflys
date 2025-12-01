<?php
// DB connection
include 'db.php';

$from = $_GET['from_city'] ?? '';
$to   = $_GET['to_city'] ?? '';
$date = $_GET['travel_date'] ?? '';

$from = trim($from);
$to   = trim($to);
$date = trim($date);

// prepared statement वापरु
$sql = "SELECT * FROM flights
        WHERE LOWER(from_city) = LOWER(?)
          AND LOWER(to_city)   = LOWER(?)
          AND travel_date      = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('sss', $from, $to, $date);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Available Flights - SkyFly</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>

<!-- NAVBAR -->
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

<section class="results-section">
  <div class="results-card">
    <h2>Available Flights</h2>

    <p>
      From <strong><?php echo htmlspecialchars($from); ?></strong>
      to <strong><?php echo htmlspecialchars($to); ?></strong>
      on <strong><?php echo htmlspecialchars($date); ?></strong>
    </p>

    <?php if ($result && $result->num_rows > 0): ?>
      <table class="results-table">
        <thead>
          <tr>
            <th>Flight</th>
            <th>From</th>
            <th>To</th>
            <th>Date</th>
            <th>Time</th>
            <th>Price (₹)</th>
            <th>Book</th>
          </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['flight_no']); ?></td>
            <td><?php echo htmlspecialchars($row['from_city']); ?></td>
            <td><?php echo htmlspecialchars($row['to_city']); ?></td>
            <td><?php echo htmlspecialchars($row['travel_date']); ?></td>
            <td><?php echo htmlspecialchars($row['depart_time']); ?></td>
            <td><?php echo htmlspecialchars($row['price']); ?></td>
            <td>
              <a class="btn-book"
                 href="booking.php
                    ?flight_no=<?php echo urlencode($row['flight_no']); ?>
                    &from=<?php echo urlencode($row['from_city']); ?>
                    &to=<?php echo urlencode($row['to_city']); ?>
                    &date=<?php echo urlencode($row['travel_date']); ?>
                    &time=<?php echo urlencode($row['depart_time']); ?>
                    &price=<?php echo urlencode($row['price']); ?>">
                Book
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p><strong>No flights found for this route/date.</strong></p>
    <?php endif; ?>

    <br>
    <a href="index.html" class="btn-primary">Back to Home</a>
  </div>
</section>

</body>
</html>