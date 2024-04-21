<?php
// Database connection
$host = "localhost"; // Replace with your database host
$dbname = "wastedisposal"; // Replace with your database name
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password

$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

// Retrieve user input
$wasteType = $_POST["wasteType"];
$email = $_POST["email"];
$city = $_POST["city"];
$state = $_POST["state"];
$mobileNo = $_POST["mobileNo"];

// Insert user data into the database
$sql = "INSERT INTO user (wasteType, email, city, state, mobileNo) VALUES (?, ?, ?, ?, ?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ssssi", $wasteType, $email, $city, $state, $mobileNo);

if ($stmt->execute()) {
    $message = "Your waste disposal request has been received. We will reach out to you as soon as possible!";
} else {
    $message = "Error: Unable to process your request. Please try again later.";
}

// Close the database connection
$stmt->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Waste Disposal Confirmation</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="process-disposal.css"> <!-- You can link your CSS file here -->
    <style>
        /* Add custom CSS for the "Go to Home" button */
        .go-to-home-button {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
</head>
<body>
    <a href="index.html" class="go-to-home-button">Go to Home</a>
    <header>
        <h1>Waste Disposal Confirmation</h1>
        <p><?php echo $message; ?></p>
    </header>
    
    <main style="margin-bottom: 31%;">
        <a href="contact.html" class="contact-button">Contact Us</a>
    </main>
    
    <footer>
        <p>&copy; 2023 WasteDeal</p>
    </footer>
</body>
</html>
