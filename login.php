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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <style>
        body {
            background-color: #f4f7fc;
            font-family: 'Arial', sans-serif;
        }
        .container {
            max-width: 400px;
            margin-top: 5rem;
            background: #fff;
            border-radius: 10px;
            padding: 3rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1.5rem;
        }
        .form-floating input {
            border-radius: 10px;
            border: 1px solid #ccc;
            padding: 0.75rem;
            color: #333; /* Make input text black */
        }
        .form-floating label {
            font-weight: 500;
            color: #333; /* Make label text black */
        }
        .form-floating input::placeholder {
            color: #333; /* Make placeholder text black */
        }
        button {
            background-color: #007bff;
            border: none;
            padding: 1rem;
            width: 100%;
            font-size: 1rem;
            border-radius: 10px;
            color: #fff;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .go-to-home-button {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 1.2rem;
            color: #007bff;
        }
        .go-to-home-button:hover {
            color: #0056b3;
        }
        .login-message {
            text-align: center;
            font-size: 0.9rem;
            color: #dc3545;
        }
        .text-center a {
            color: #007bff;
        }
        .text-center a:hover {
            text-decoration: underline;
        }
        .form-check-label {
            font-weight: 400;
        }
        .form-check-input {
            margin-left: 0.25rem;
        }
        .logo {
            display: block;
            margin: 0 auto 1.5rem;
            width: 80px;
            height: 80px;
        }
    </style>
</head>
<body>
    <a href="index.html" class="go-to-home-button">Go to Home</a>

    <div class="container">
        <form method="post">
            <img class="logo" src="icon2.png" alt="Logo">
            <h1 class="text-center">Log in Here!</h1>
            
            <!-- Email input -->
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="floatingInput" name="email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" placeholder="name@example.com" required>
                <label for="floatingInput">Email Address</label>
            </div>
            
            <!-- Password input -->
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
                <label for="floatingPassword">Password</label>
            </div>

            <!-- Remember me checkbox -->
            <div class="form-check text-start mb-4">
                <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Remember me
                </label>
            </div>

            <!-- Submit button -->
            <button class="btn btn-primary" type="submit">Sign in</button>

            <!-- Sign up link -->
            <p class="text-center mt-3">New to our website? <a href="signup.html">Sign Up</a></p>

            <!-- Error message -->
            <?php if ($is_invalid): ?>
                <p class="login-message">Invalid login credentials, please try again.</p>
            <?php endif; ?>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
