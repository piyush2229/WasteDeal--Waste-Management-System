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

    // Retrieve user input (waste type)
    $wasteType = $_POST["waste_type"];

    // Sanitize the input to prevent harmful characters (e.g., from regex or SQL injection)
    // We allow alphanumeric characters, spaces, and common punctuation (e.g., hyphens, commas, etc.)
    $wasteType = preg_replace('/[^a-zA-Z0-9\s\-\,\.\']/', '', $wasteType);

    // Prepare the regex pattern for the search (escaping any special regex characters in the user input)
    $pattern = $mysqli->real_escape_string($wasteType);

    // Use REGEXP in the SQL query to search the type_of_waste column
    $sql = "SELECT quantity, state, price, city, type_of_waste FROM user WHERE type_of_waste REGEXP ?";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $pattern);
    $stmt->execute();
    $result = $stmt->get_result();

    // Store results in an array
    $results = [];
    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }

    // Calculate the total quantity of the same waste
    $totalQuantity = array_sum(array_column($results, 'quantity'));

    // Close the database connection
    $stmt->close();
    $mysqli->close();

    // Include the HTML file with the results
    include('search-results.html');

    // Add the "Go to Home" button
    echo '<a href="index.html" class="go-to-home-button">Go to Home</a>';
} else {
    // Handle invalid request
    echo "Invalid request!";
}
?>
