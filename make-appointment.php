<?php
session_start();

include './includes/db.inc.php';

if (!isset($_SESSION['email'])) {
    header("Location: signin.php");
    exit();
}

$error = "";

// Check if form is submitted
if (isset($_POST['reason']) && isset($_POST['doctor']) && isset($_POST['date']) && isset($_POST['specialty'])) {
    $reason = $_POST['reason'];
    $doctor = $_POST['doctor'];
    $date = $_POST['date'];
    $specialty = $_POST['specialty'];

    // Validate form fields
    if (!empty($reason) && !empty($doctor) && !empty($date) && !empty($specialty)) {

        // Prepare the SQL query to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO appointments (reason, doctor, appointment_date, specialty, user_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $reason, $doctor, $date, $specialty, $_SESSION['user_id']);

        // Execute the query
        if ($stmt->execute()) {
            echo "Appointment saved successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();

        // Reset error message
        $error = "";
    } else {
        $error = "All the fields are required.";
        echo $error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Management System | Make appointments</title>
    <link rel="stylesheet" href="./styles/styles.css">
</head>

<body>
    <?php include "./partials/navbar.php"; ?>

    <div class="contact-page-container">
        <h1 style="display: block; margin-bottom: 30px;">Make appointments</h1>

        <div>
            <form action="make-appointment.php" method="POST" class="appointment-form">
                <div class="input-row">
                    <div class="input-group">
                        <label for="appointment">Pick the Appointment date</label>
                        <input type="date" name="date" class="input-field">
                    </div>

                    <div class="input-group">
                        <label for="specialty">Specialty</label>
                        <select name="specialty" id="specialty" onchange="loadDoctors(this.value)">
                            <option value="dentist">Dentist</option>
                            <option value="neurologist">Neurologist</option>
                            <option value="cardiologist">Cardiologist</option>
                            <option value="dermatologist">Dermatologist</option>
                            <option value="eyes surgeon">Eyes surgeon</option>
                        </select>
                    </div>
                </div>

                <div class="input-row">
                    <div class="input-group">
                        <label for="doctor">Doctor</label>
                        <select name="doctor" id="doctor" class="input-field">
                            <option>Select the specialty</option>
                        </select>
                    </div>
                    <div></div>
                </div>

                <div class="input-group">
                    <label for="reason">Reason</label>
                    <textarea style="resize: none; height: 200px;" name="reason" id="reason" placeholder="Enter the reason ...."></textarea>
                </div>

                <span><?php echo $error; ?></span>

                <button class="appointment-btn">Make an Appointment</button>
            </form>

        </div>
    </div>

    <script>
        function loadDoctors(specialty) {
            fetch('get-doctors.php?specialty=' + specialty)
                .then(response => response.json())
                .then(data => {
                    const doctorSelect = document.getElementById('doctor');
                    doctorSelect.innerHTML = '<option value="">Select a doctor</option>';

                    data.forEach(doctor => {
                        const option = document.createElement('option');
                        option.value = doctor.id;
                        option.textContent = doctor.name;
                        doctorSelect.appendChild(option);
                    });
                });
        }
    </script>

    <?php include "./partials/footer.php"; ?>
</body>

</html>