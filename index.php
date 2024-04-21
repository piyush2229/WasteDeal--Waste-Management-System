<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION["user_"])) {
    
    // Include the database connection
    $mysqli = require __DIR__ . "/database.php";
    
    // Query to fetch user data
    $sql = "SELECT * FROM user_
            WHERE id = {$_SESSION["user"]}";
            
    $result = $mysqli->query($sql);
    
    // Fetch user data
    $user = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    
    <h1>Home</h1>
    
    <?php if (isset($user)): ?>
        
        <p>Welcome <?= htmlspecialchars($user["name"]) ?> to our website.</p>
        <p>Here you can:</p>
        <ul>
            <li><a href="registerwaste.html">Register your waste</a></li>
            <li><a href="search.php">Search for waste</a></li>
        </ul>
        <p><a href="logout.php">Log out</a></p>
        
    <?php else: ?>
        
        <p><a href="login.php">Log in</a> or <a href="signup.html">sign up</a></p>
        
    <?php endif; ?>
    
</body>
</html>
