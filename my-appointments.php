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
    <title>Hospital Management System | Appointments</title>
    <link rel="stylesheet" href="./styles/styles.css">
</head>

<body>
    <?php include "./partials/navbar.php"; ?>

    <div class="contact-page-container">
        <h1 style="display: block; margin-bottom: 30px;">All Appointments</h1>

        <div>
            <table>
                <tr>
                    <th>Id</th>
                    <th>Appointment Date</th>
                    <th>Doctor</th>
                    <th>Specialty</th>
                    <th>Reason</th>
                </tr>

                <?php

                $query = "SELECT appointments.*, doctors.name as doctor_name, users.*
                            FROM appointments 
                            INNER JOIN users ON appointments.user_id = users.id
                            INNER JOIN doctors ON appointments.doctor = doctors.id
                            WHERE appointments.user_id = " . $_SESSION['user_id'];

                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {

                ?>

                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td><?= $row['appointment_date']; ?></td>
                            <td><?= $row['doctor_name']; ?></td>
                            <td><?= $row['specialty']; ?></td>
                            <td><?= $row['reason']; ?></td>
                        </tr>

                <?php

                    }
                } else {
                    echo 'No appointments found.';
                }
                mysqli_close($conn);

                ?>
            </table>

        </div>
    </div>

    <?php include "./partials/footer.php"; ?>
</body>
</body>

</html>