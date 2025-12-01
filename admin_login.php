<?php
// admin_login.php

session_start();          // ⬅ सर्वात वर ठेवायचं
include 'db.php';        // DB connection ($conn)

// फॉर्म submit झाला असेल तेव्हाच process कर
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // form मधली values घ्या
    $email    = $_POST['email']    ?? '';
    $password = $_POST['password'] ?? '';

    // basic सुरक्षितता (optional पण ठेवलं तर बरं)
    $email    = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // फक्त admin role असलेला user शोध
    $sql    = "SELECT * FROM users WHERE email = '$email' AND role = 'admin' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) === 1) {

        $row = mysqli_fetch_assoc($result);

        // 👉 इथे आपण साधा plain-text पासवर्ड compare करतोय
        // जर hashing वापरला असशील तर password_verify() वापर.
        if ($row['password'] === $password) {

            // ✅ LOGIN SUCCESS – session flag सेट कर
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_email']     = $row['email'];

            // Admin ला bookings page वर पाठव
            echo "<script>
                    alert('Admin Login Successful!');
                    window.location.href = 'admin_bookings.php';
                  </script>";
            exit;

        } else {
            // ❌ चुकीचा password
            echo "<script>
                    alert('Wrong Admin Password!');
                    window.location.href = 'admin.html';
                  </script>";
            exit;
        }

    } else {
        // ❌ असा admin userच नाही
        echo "<script>
                alert('Admin not found!');
                window.location.href = 'admin.html';
              </script>";
        exit;
    }

} else {
    // direct admin_login.php उघडला तर परत form कडे पाठव
    header('Location: admin.html');
    exit;
}
?>