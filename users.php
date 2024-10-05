<?php
session_start(); 

include './includes/db.inc.php';

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Management System | Users</title>
    <link rel="stylesheet" href="./styles/styles.css">
</head>

<body>
    <?php include "./partials/navbar.php"; ?>

    <div class="contact-page-container">
        <h1 style="display: block; margin-bottom: 30px;">Users</h1>

        <div>
            <table>
                <tr>
                    <th>Id</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Role</th>
                </tr>

                <?php

                $query = "SELECT * FROM users";

                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {

                ?>

                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td><?= $row['firstName']; ?></td>
                            <td><?= $row['lastName']; ?></td>
                            <td><?= $row['email']; ?></td>
                            <td><?= $row['username']; ?></td>
                            <td><?= $row['role']; ?></td>
                            <td><button>Delete</button> <button>Update</button></td>
                        </tr>

                <?php

                    }
                } else {
                    echo '0 Rows';
                }
                mysqli_close($conn);

                ?>
            </table>

        </div>
    </div>

    <?php include "./partials/footer.php"; ?>
</body>

</html>