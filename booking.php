<?php
session_start();
include 'db.php'; // DB connection

// ========== GET values (results.php मधून आलेले) ==========
$flight_no = $_GET['flight_no'] ?? '';
$from      = $_GET['from']      ?? '';
$to        = $_GET['to']        ?? '';
$date      = $_GET['date']      ?? '';
$time      = $_GET['time']      ?? '';
$price     = isset($_GET['price']) ? (int)$_GET['price'] : 0;

// ===== flags आणि form चे default values =====
$booking_saved   = false;
$error_message   = '';
$passenger_name  = '';
$email           = '';
$phone           = '';
$passengers      = 1;

// ========== FORM submit (POST) ==========
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // hidden flight values (form मधून परत आलेले)
    $flight_no = $_POST['flight_no']    ?? '';
    $from      = $_POST['from_city']    ?? '';
    $to        = $_POST['to_city']      ?? '';
    $date      = $_POST['travel_date']  ?? '';
    $time      = $_POST['depart_time']  ?? '';
    $price     = isset($_POST['price']) ? (int)$_POST['price'] : 0;

    // विजिबल fields
    $passenger_name = $_POST['passenger_name']  ?? '';
    $email          = $_POST['passenger_email'] ?? '';
    $phone          = $_POST['passenger_phone'] ?? '';
    $passengers     = isset($_POST['passengers']) ? (int)$_POST['passengers'] : 1;

    // passenger login असेल तर
    $passengerId = $_SESSION['passenger_id'] ?? null;

    if ($price < 0)      $price = 0;
    if ($passengers < 1) $passengers = 1;

    // ========== INSERT query ==========
    $sql = "INSERT INTO bookings
            (passenger_id,flight_no, from_city, to_city, travel_date, depart_time,
             passenger_name, passenger_email, passenger_phone, passengers, price)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        $error_message = 'Prepare failed: ' . $conn->error;
    } else {
        // type string: i (passenger_id), ssssssss (8 string), i (passengers), i (price)
        $stmt->bind_param(
            "issssssssii",
            $_SESSION['passenger_id'],
            $flight_no, $from, $to, $date, $time,
            $passenger_name, $email, $phone,
            $passengers, $price
        );

        if ($stmt->execute()) {
            // booking DB मध्ये save झाली
            $booking_saved = true;
        } else {
            $error_message = 'Booking failed: ' . $stmt->error;
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Flight Booking - SkyFly</title>
    <link rel="stylesheet" href="style.css">
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

<?php if ($booking_saved): ?>
    <!-- ========== BOOKING CONFIRMED + PAYMENT OPTIONS ========== -->
    <section class="confirm-section">
        <div class="confirm-card">
            <h2>Booking Confirmed!</h2>
            <p>Thank you, <strong><?php echo htmlspecialchars($passenger_name); ?></strong>.</p>

            <div class="confirm-details">
                <p><strong>Flight:</strong> <?php echo htmlspecialchars($flight_no); ?></p>
                <p><strong>Route:</strong>
                    <?php echo htmlspecialchars($from); ?> →
                    <?php echo htmlspecialchars($to); ?>
                </p>
                <p><strong>Date:</strong> <?php echo htmlspecialchars($date); ?></p>
                <p><strong>Time:</strong> <?php echo htmlspecialchars($time); ?></p>
                <p><strong>Passengers:</strong> <?php echo $passengers; ?></p>
                <p><strong>Total Price:</strong> ₹<?php echo $price; ?></p>
            </div>

            <br>

            <!-- Online payment button -->
            <a href="payment.php?amount=<?php echo urlencode($price); ?>&name=<?php echo urlencode($passenger_name); ?>"
               class="confirm-btn">
                Proceed to Pay Online
            </a>

            <br><br>

            <!-- Cash payment button -->
            <a href="payment_cash.php?amount=<?php echo urlencode($price); ?>&name=<?php echo urlencode($passenger_name); ?>"
               class="confirm-btn">
                Pay Cash at Counter
            </a>

            <br><br>
            <a href="index.html" class="confirm-btn">Back to Home</a>
        </div>
    </section>

<?php elseif ($error_message): ?>
    <!-- ========== ERROR CASE ========== -->
    <section class="confirm-section">
        <div class="confirm-card">
            <h2>Error saving booking!</h2>
            <p><?php echo htmlspecialchars($error_message); ?></p>
            <a href="index.html" class="confirm-btn">Back to Home</a>
        </div>
    </section>

<?php else: ?>
    <!-- ========== NORMAL BOOKING FORM (GET request) ========== -->
    <section class="booking-section">
        <div class="booking-card">
            <h2>Flight Booking</h2>

            <!-- selected flight info -->
            <div class="booking-flight-info">
                <p><b>Flight:</b> <?php echo htmlspecialchars($flight_no); ?></p>
                <p><b>Route:</b> <?php echo htmlspecialchars($from); ?> →
                    <?php echo htmlspecialchars($to); ?></p>
                <p><b>Date:</b> <?php echo htmlspecialchars($date); ?></p>
                <p><b>Time:</b> <?php echo htmlspecialchars($time); ?></p>
                <p><b>Price:</b> ₹<?php echo $price; ?></p>
            </div>

            <!-- BOOKING FORM -->
            <form action="booking.php" method="POST">

                <!-- hidden flight values -->
                <input type="hidden" name="flight_no"    value="<?php echo htmlspecialchars($flight_no); ?>">
                <input type="hidden" name="from_city"    value="<?php echo htmlspecialchars($from); ?>">
                <input type="hidden" name="to_city"      value="<?php echo htmlspecialchars($to); ?>">
                <input type="hidden" name="travel_date"  value="<?php echo htmlspecialchars($date); ?>">
                <input type="hidden" name="depart_time"  value="<?php echo htmlspecialchars($time); ?>">
                <input type="hidden" name="price"        value="<?php echo $price; ?>">

                <label>Passenger Name</label>
                <input type="text" name="passenger_name" required>

                <label>Email</label>
                <input type="email" name="passenger_email" required>

                <label>Phone</label>
                <input type="text" name="passenger_phone" required>

                <label>No. of Passengers</label>
                <input type="number" name="passengers" min="1" value="1" required>

                <button type="submit" class="booking-btn">Confirm Booking</button>
            </form>
        </div>
    </section>
<?php endif; ?>

</body>
</html>