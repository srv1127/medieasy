<?php
// Configuration
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'agriculture_products01';

// Create connection
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

// Check connection
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: '. mysqli_connect_error());
}

// Check if form is submitted
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate form data
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = 'Please fill all fields!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email address!';
    } elseif ($password!= $confirm_password) {
        $error = 'Passwords do not match!';
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert into database
        $query = "INSERT INTO `signup` (`sno`, `username`, `email`, `password`) VALUES (NULL, '$username', '$email', '$password')";
        $stmt = $con->prepare($query);

        $stmt->execute();

        // Redirect to login page
        header('Location: login.php');
        exit;
    }
}
?>

<!-- HTML form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>signup - medieasy </title>
    
</head>
<body>
    <h1> Medieasy - signup</h1>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username"><br><br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email"><br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password"><br><br>
    <label for="confirm_password">Confirm Password:</label>
    <input type="password" id="confirm_password" name="confirm_password"><br><br>
    <input type="submit" name="submit" value="Sign up">
    <?php if (isset($error)) { echo '<p style="color: red;">'. $error. '</p>'; }?>
</form> 
</body>
</html>

