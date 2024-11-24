<?php
// Configuration
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'agriculture_products01';

// Connect to database
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Login form submission
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to retrieve user data
    $query = "SELECT * FROM `login` WHERE 1";
    $result = $conn->query($query);

    // Check if user exists
    if ($result->num_rows > 0) {
        // User exists, log them in
        $user_data = $result->fetch_assoc();
        session_start();
        $_SESSION['username'] = $user_data['username'];
        $_SESSION['user_id'] = $user_data['id'];
        header('Location: welcome.html');
        exit;
    } else {
        // User does not exist, display error message
        $error = 'Invalid username or password';
    }
}

// Close database connection
$conn->close();
?>

<!-- HTML login form -->
<html>
<head>
    <title>Login Page</title>
</head>
<body>
    <h1>MedieasyLogin</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username"><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" name="submit" value="Login">
    </form>
    <?php if (isset($error)) { echo '<p style="color:red;">' . $error . '</p>'; } ?>
</body>
</html>