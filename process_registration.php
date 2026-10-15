<?php
require_once "db.php";

function showResult($title, $message, $success = false) {
    $heading = htmlspecialchars($title, ENT_QUOTES, "UTF-8");
    $details = htmlspecialchars($message, ENT_QUOTES, "UTF-8");
    $class = $success ? "success" : "error";
    $symbol = $success ? "✓" : "!";

    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . $heading . '</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <main class="result-page">
            <div class="result-card ' . $class . '">
                <div class="result-icon">' . $symbol . '</div>
                <p class="overline">NOVAJOIN REGISTRATION</p>
                <h1>' . $heading . '</h1>
                <p>' . $details . '</p>
                <a class="back-link" href="register.php">← Back to registration</a>
            </div>
        </main>
    </body>
    </html>';
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: register.php");
    exit;
}

$username = trim($_POST["username"] ?? "");
$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";

if (
    strlen($username) < 3 ||
    strlen($username) > 100 ||
    !preg_match('/\A[A-Za-z0-9_.-]+\z/', $username)
) {
    showResult(
        "Invalid username",
        "Use 3 to 100 letters, numbers, dots, underscores or hyphens."
    );
    exit;
}

if (
    strlen($email) > 150 ||
    !filter_var($email, FILTER_VALIDATE_EMAIL)
) {
    showResult("Invalid email", "Please enter a valid email address.");
    exit;
}

if (strlen($password) < 8 || strlen($password) > 72) {
    showResult(
        "Invalid password",
        "Use a password between 8 and 72 characters."
    );
    exit;
}

$check = mysqli_prepare(
    $conn,
    "SELECT id FROM users WHERE username = ? OR email = ?"
);

if (!$check) {
    showResult("Request failed", "Unable to check account details.");
    exit;
}

mysqli_stmt_bind_param($check, "ss", $username, $email);
mysqli_stmt_execute($check);
mysqli_stmt_store_result($check);

if (mysqli_stmt_num_rows($check) > 0) {
    mysqli_stmt_close($check);
    showResult(
        "Account already exists",
        "This username or email is already registered. Try another one."
    );
    exit;
}

mysqli_stmt_close($check);

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

if ($hashedPassword === false) {
    showResult("Registration failed", "Unable to secure the password.");
    exit;
}

$stmt = mysqli_prepare(
    $conn,
    "INSERT INTO users (username, email, password) VALUES (?, ?, ?)"
);

if (!$stmt) {
    showResult("Registration failed", "Unable to prepare the database request.");
    exit;
}

mysqli_stmt_bind_param(
    $stmt,
    "sss",
    $username,
    $email,
    $hashedPassword
);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    showResult(
        "Registration successful!",
        "Your account has been created and your password was stored as a hash.",
        true
    );
} else {
    $errorCode = mysqli_stmt_errno($stmt);
    mysqli_stmt_close($stmt);

    if ($errorCode === 1062) {
        showResult(
            "Account already exists",
            "This username or email is already registered."
        );
    } else {
        error_log("Registration database error: " . $errorCode);
        showResult("Registration failed", "Please try again later.");
    }
}
?>
