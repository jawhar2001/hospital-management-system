<?php
include "./includes/db.inc.php";

session_start();

if (isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$error_message = "";

if (isset($_POST["email"]) && isset($_POST['password'])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $error_message = "";

        $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $_SESSION['email'] = $row['email'];                
                $_SESSION['username'] = $row['username'];                
                $_SESSION['firstName'] = $row['firstName'];                
                $_SESSION['lastName'] = $row['lastName'];                
                $_SESSION['role'] = $row['role'];                

                header("Location: index.php");
            }
        } else {
            $error_message = 'Invalid credentials.';
        }
        mysqli_close($conn);
    } else {
        $error_message = 'Invalid credentials.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hope well Hospital | Sign in</title>
    <link rel="stylesheet" href="./styles/auth.css">
</head>

<body>
    <form action="signin.php" method="post">
        <div class="signin-container">
            <h2>Sign in</h2>
            <input type="text" name="email" class="input-field" placeholder="Email">
            <input type="password" name="password" class="input-field" placeholder="Password">

            <span class="error_message"><?php echo $error_message; ?></span>

            <button class="auth-btn">Sign in</button>

            <a href="signup.php">Create an account</a>
        </div>
    </form>
</body>

</html>