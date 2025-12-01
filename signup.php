<?php
include 'db.php';

if (isset($_POST['signup'])) {

    $name      = $_POST['name'] ?? '';
    $email     = $_POST['email'] ?? '';
    $password  = $_POST['password'] ?? '';
    $cpassword = $_POST['cpassword'] ?? '';

    // रिकामे field आहेत का?
    if ($name == '' || $email == '' || $password == '' || $cpassword == '') {
        echo "<script>alert('Please fill all fields'); window.history.back();</script>";
        exit;
    }

    // password आणि confirm match नाही?
    if ($password !== $cpassword) {
        echo "<script>alert('Password and Confirm Password do not match'); window.history.back();</script>";
        exit;
    }

    // email आधी आहे का?
    $checkSql    = "SELECT id FROM users WHERE email='$email'";
    $checkResult = mysqli_query($conn, $checkSql);

    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        echo "<script>alert('This email is already registered'); window.history.back();</script>";
        exit;
    }

    // इथे आपण साधाच password save करतो (hash नाही – project सोपा ठेवायला)
    $insertSql = "INSERT INTO users (name, email, password, role)
                  VALUES ('$name', '$email', '$password', 'passenger')";

    if (mysqli_query($conn, $insertSql)) {
        echo "<script>alert('Signup successful! Now you can login.'); window.location='login.html';</script>";
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }
} else {
    header('Location: signup.html');
    exit;
}
?>