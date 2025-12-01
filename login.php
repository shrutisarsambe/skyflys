<?php
include 'db.php';  // database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email    = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // user शोध (email + password दोन्ही)
    $sql    = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) === 1) {

        echo "<script>
                alert('Login Successful!');
                window.location.href = 'index.html';
              </script>";

    } else {

        echo "<script>
                alert('Invalid Email or Password');
                window.location.href = 'login.html';
              </script>";
    }

} else {
    header('Location: login.html');
    exit;
}
?>