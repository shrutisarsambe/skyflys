<?php
session_start();
include 'db.php'; // DB connection

// जर passenger लॉगिन नसेल तर परत login page वर
if (!isset($_SESSION['passenger_email'])) {
    header('Location: login.html');
    exit;
}

$email = $_SESSION['passenger_email'];

// फक्त अस्तित्वात असलेले columns वापरले आहेत
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
        WHERE passenger_email = ?
        ORDER BY booked_at DESC";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Query prepare failed: " . $conn->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Bookings - SkyFly</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="navbar">
    <div class="logo">
        <div class="logo-icon">✈</div>
        <div class="logo-text">SkyFly <span>Airlines</span></div>
    </div>

    <nav class="nav-links">
        <a href="index.html">Home</a>
        <a href="login.html" class="active">Passenger Login</a>
        <a href="admin.html">Admin</a>
    </nav>
</header>

<section class="booking-section">
    <div class="booking-card">
        <h2>Your Bookings</h2>

        <?php if ($result && $result->num_rows > 0): ?>
            <table class="results-table">
                <thead>
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
                        <th>Price (₹)</th>
                        <th>Booked At</th>
                    </tr>
                </thead>
                <tbody>
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
                            <td><?php echo htmlspecialchars($row['price']); ?></td>
                            <td><?php echo htmlspecialchars($row['booked_at']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p><strong>No bookings found for this account.</strong></p>
        <?php endif; ?>

        <br>
        <a href="index.html" class="btn-primary">Back to Home</a>
    </div>
</section>

</body>
</html>