<?php
include './includes/db.inc.php';

session_start();

$error_message = "";

if (
    isset($_POST['email']) &&
    isset($_POST['username']) &&
    isset($_POST['firstName']) &&
    isset($_POST['lastName']) &&
    isset($_POST['password']) &&
    isset($_POST['confirmPassword'])
) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $confirmPassword = $_POST['confirmPassword'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];

    if (
        !empty($username) &&
        !empty($password) &&
        !empty($email) &&
        !empty($confirmPassword) &&
        !empty($firstName) &&
        !empty($lastName)
    ) {

        if ($password === $confirmPassword) {
            // do the operation
            $query = "INSERT INTO users (firstName, lastName, email, password, username) 
                            VALUES('$firstName', '$lastName', '$email', '$password', '$username')";

            if (mysqli_query($conn, $query)) {
                echo "New record created successfully";
                header("Location: signin.php");
            } else {
                echo "Error: " . $query . "<br>" . mysqli_error($conn);
                $error_message = "Something went wrong, try again later.";
            }

            mysqli_close($conn);
        } else {
            $error_message = 'Passwords do not match.';
        }
    } else {
        $error_message = "All the fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jawhar Hospital | Sign Up</title>
    <link rel="stylesheet" href="./styles/auth.css">
</head>

<body>
    <form action="signup.php" method="post">
        <div class="signin-container">
            <h2>Sign Up</h2>
            <input name="email" type="text" class="input-field" placeholder="Email">
            <input name="username" type="text" class="input-field" placeholder="Username">
            <input name="firstName" type="text" class="input-field" placeholder="First Name">
            <input name="lastName" type="text" class="input-field" placeholder="Last Name">
            <input name="password" type="password" class="input-field" placeholder="Password">
            <input name="confirmPassword" type="password" class="input-field" placeholder="Confirm Password">

            <span class="error_message"><?= $error_message; ?></span>

            <button class="auth-btn">Sign in</button>

            <a href="signin.php">Already have an account</a>
            
        </div>
    </form>
</body>

</html>