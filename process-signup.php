<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (empty($_POST["name"])) {
    die("Name is required");
}

if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Valid email is required");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if (!preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if (!preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";

if ($mysqli->connect_error) {
    die("Database connection error: " . $mysqli->connect_error);
}

// Check if the email already exists
$checkEmailSql = "SELECT COUNT(*) FROM user WHERE email = ?";
$stmtCheckEmail = $mysqli->prepare($checkEmailSql);
$stmtCheckEmail->bind_param("s", $_POST["email"]);
$stmtCheckEmail->execute();
$stmtCheckEmail->bind_result($emailCount);
$stmtCheckEmail->fetch();
$stmtCheckEmail->close();

if ($emailCount > 0) {
    die("Email already taken");
}

// Insert the new user
$sql = "INSERT INTO user (name, email, password_hash) VALUES (?, ?, ?)";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die("SQL error: " . $stmt->error);
}

$stmt->bind_param("sss", $_POST["name"], $_POST["email"], $password_hash);

if ($stmt->execute()) {
    header("Location: signup-success.html");
    exit;
} else {
    die("Database error: " . $stmt->error);
}
?>
