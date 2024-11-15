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
    <title>Hospital Management System | Doctors</title>
    <link rel="stylesheet" href="./styles/styles.css">
</head>

<body>
    <?php include "./partials/navbar.php"; ?>

    <div class="contact-page-container">
        <h1 style="display: block; margin-bottom: 30px;">All Doctors</h1>

        <div>
            <table>
                <tr>
                    <th>Id</th>
                    <th>Doctor</th>
                    <th>Specialty</th>
                </tr>

                <?php

                $query = "SELECT * FROM doctors";

                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {

                ?>

                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td><?= $row['name']; ?></td>
                            <td><?= $row['specialty']; ?></td>
                        </tr>

                <?php

                    }
                } else {
                    echo 'No doctors found.';
                }
                mysqli_close($conn);

                ?>
            </table>

        </div>
    </div>

    <?php include "./partials/footer.php"; ?>
</body>

</html>