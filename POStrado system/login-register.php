<?php
include 'config.php';
session_start();

// ---------------- REGISTER ----------------
if (isset($_POST['register'])) {

    $email = trim($_POST['Email']);
    $password = $_POST['Password'];
    $confirmPassword = $_POST['Confirm-Password'];

    // Check if all fields are filled
    if (empty($email) || empty($password) || empty($confirmPassword)) {
        $_SESSION['register_error'] = "Please fill in all fields.";
        $_SESSION['active_form'] = "register";
        header("Location: index.php");
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['register_error'] = "Please enter a valid email address.";
        $_SESSION['active_form'] = "register";
        header("Location: index.php");
        exit;
    }

    // Check if passwords match
    if ($password !== $confirmPassword) {
        $_SESSION['register_error'] = "Passwords do not match.";
        $_SESSION['active_form'] = "register";
        header("Location: index.php");
        exit;
    }

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

     
    if ($result->num_rows > 0) {
        $_SESSION['register_error'] = "Email already exists.";
        $_SESSION['active_form'] = "register";
        $check->close();
        header("Location: index.php");
        exit;
    }

    $check->close();

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $hashedPassword);

    if ($stmt->execute()) {
        $stmt->close();

        $_SESSION['login_error'] = "Registration successful! You can now log in.";
        $_SESSION['active_form'] = "login";

        header("Location: index.php");
        exit;
    } else {
        $_SESSION['register_error'] = "Registration failed.";
        $_SESSION['active_form'] = "register";

        $stmt->close();

        header("Location: index.php");
        exit;
    }
}


// ---------------- LOGIN ----------------
if (isset($_POST['login'])) {

    $email = trim($_POST['Email']);
    $password = $_POST['Password'];

    // Check empty fields
    if (empty($email) || empty($password)) {
        $_SESSION['login_error'] = "Please enter your email and password.";
        $_SESSION['active_form'] = "login";
        header("Location: index.php");
        exit;
    }

    // Find user
    $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {

            // Save user session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $row['email'];

            $stmt->close();

            header("Location: dashboard.php");
            exit;

        } else {

            $_SESSION['login_error'] = "Incorrect password.";
            $_SESSION['active_form'] = "login";

            $stmt->close();

            header("Location: index.php");
            exit;
        }

    } else {

        $_SESSION['login_error'] = "No account found with that email.";
        $_SESSION['active_form'] = "login";

        $stmt->close();

        header("Location: index.php");
        exit;
    }
}

$conn->close();
?>