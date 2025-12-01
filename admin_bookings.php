<?php
// admin_bookings.php

session_start();

// ✅ फक्त admin logged in असेल तरच हा page दिसू दे
if (empty($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin.html");   // किंवा admin_login.php वापरू शकतेस
    exit();
}

// DB connection
$conn = new mysqli("localhost", "root", "", "skyflydb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// bookings fetch
$sql = "SELECT 
            id,
            flight_no,
            from_city,
            to_city,
            travel_date,
            depart_time,
            passenger_name,
            passenger_email,
            passenger_phone,
            passengers,
            price,
            booked_at
        FROM bookings
        ORDER BY booked_at DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>All Bookings - SkyFly</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>

<header class="navbar">
    <div class="logo">
        <div class="logo-icon">✈</div>
        <div class="logo-text">SkyFly <span>Airlines</span></div>
    </div>

    <nav class="nav-links">
        <a href="index.html">Home</a>
        <a href="admin.html" class="active">Admin Panel</a>
    </nav>
</header>

<section class="booking-section">
    <div class="booking-card">
        <h2>All Flight Bookings</h2>

        <table class="results-table">
            <tr>
                <th>ID</th>
                <th>Flight</th>
                <th>From</th>
                <th>To</th>
                <th>Date</th>
                <th>Time</th>
                <th>Passenger</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Passengers</th>
                <th>Price</th>
                <th>Booked At</th>
            </tr>

            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['flight_no']); ?></td>
                        <td><?php echo htmlspecialchars($row['from_city']); ?></td>
                        <td><?php echo htmlspecialchars($row['to_city']); ?></td>
                        <td><?php echo htmlspecialchars($row['travel_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['depart_time']); ?></td>
                        <td><?php echo htmlspecialchars($row['passenger_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['passenger_email']); ?></td>
                        <td><?php echo htmlspecialchars($row['passenger_phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['passengers']); ?></td>
                        <td>₹<?php echo htmlspecialchars($row['price']); ?></td>
                        <td><?php echo htmlspecialchars($row['booked_at']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="12">No bookings found.</td>
                </tr>
            <?php endif; ?>
        </table>

        <br>
        <a href="admin.html" class="btn-primary">Back to Admin</a>
    </div>
</section>

</body>
</html>
<?php
$conn->close();
?>