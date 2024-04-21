<?php
$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Include the database connection file
    require __DIR__ . "/database.php";

    // Prepare a SQL statement using a parameterized query to prevent SQL injection
    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $_POST["email"]);

    // Execute the prepared statement
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the user data
    $user = $result->fetch_assoc();

    // Check if a user with the provided email exists
    if ($user && password_verify($_POST["password"], $user["password_hash"])) {
        // Start a session and store the user ID
        session_start();
        session_regenerate_id();
        $_SESSION["user_id"] = $user["id"];

        // Redirect to the desired page after successful login
        header("Location: registerwaste.html");
        exit;
    } else {
        $is_invalid = true;
    }

    // Close the prepared statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
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
    <div class="container">
        <form method="post">
            <!-- Replace this section with the provided HTML -->
            <img class="mb-4" src="icon2.png" alt="" width="72" height="57">
            <h1 class="h3 mb-3 fw-normal">Log in Here!</h1>
        
            <div class="form-floating">
                <label for="floatingInput">Email address</label>
                <input type="email" class="form-control" id="floatingInput" name="email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" placeholder="name@example.com">
            </div>
            <div class="form-floating">
                <label for="floatingPassword">Password</label>
                <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
            </div>
        
            <div class="form-check text-start my-3">
                <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Remember me
                </label>
            </div>
            <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>

            <p>New to our website?<a href="signup.html">Sign Up</a></p>
            <!-- End of provided HTML section -->

            <?php if ($is_invalid): ?>
                <em>Invalid login</em>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
