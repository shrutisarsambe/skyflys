<?php
session_start();
include 'db.php'; // DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // form मधून values
    $email    = $_POST['email']    ?? '';
    $password = $_POST['password'] ?? '';

    // basic safety – prepared statement
    $sql = "SELECT id, name, email, password 
            FROM users 
            WHERE email = ? AND role = 'passenger'
            LIMIT 1";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Query prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // user सापडला का?
    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // इथे मी plain text तुलना ठेवली आहे
        // (जर तू password hash वापरत असशील तर password_verify() वापर)
        if ($row['password'] === $password) {

            // session values set करा – my_bookings.php ला हे लागतात
            $_SESSION['passenger_logged_in'] = true;
            $_SESSION['passenger_id']        = $row['id'];     // users table चा id
            $_SESSION['passenger_email']     = $row['email'];
            $_SESSION['passenger_name']      = $row['name'] ?? '';

            // login यशस्वी – my_bookings.php वर जा
            echo "<script>
                    alert('Login Successful!');
                    window.location.href = 'my_bookings.php';
                  </script>";
            exit;

        } else {
            // wrong password
            echo "<script>
                    alert('Wrong Password!');
                    window.location.href = 'login.html';
                  </script>";
            exit;
        }

    } else {
        // userच सापडला नाही
        echo "<script>
                alert('Passenger not found!');
                window.location.href = 'login.html';
              </script>";
        exit;
    }
}
?>