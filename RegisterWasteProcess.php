<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Database connection
    $host = "localhost";
    $dbname = "wastedealsetdata";
    $username = "root";
    $password = "";

    $mysqli = new mysqli($host, $username, $password, $dbname);

    if ($mysqli->connect_errno) {
        die("Connection error: " . $mysqli->connect_error);
    }

    // Retrieve user input
    $industryName = $_POST["industry_name"];
    $typeOfWaste = $_POST["type_of_waste"];
    $email = $_POST["email"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $pincode = $_POST["pincode"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];

    // Insert user data into the database
    $sql = "INSERT INTO user (industry_name, type_of_waste, email, city, state, pincode, quantity, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sssssidd", $industryName, $typeOfWaste, $email, $city, $state, $pincode, $quantity, $price);

    if ($stmt->execute()) {
        // Data inserted successfully
        header("Location: signup-success.html");
        exit;
    } else {
        // Error handling for database insert
        die("Error: " . $stmt->error);
    }

    // Close the database connection
    $stmt->close();
    $mysqli->close();
} else {
    // Handle invalid request
    echo "Invalid request!";
}
?>
