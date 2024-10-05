<?php
session_start();

include './includes/db.inc.php';

if (!isset($_SESSION['email'])) {
    header("Location: signin.php");
    exit();
}

$error = "";

// Check if form is submitted
if(isset($_POST['reason']) && isset($_POST['doctor']) && isset($_POST['date']) && isset($_POST['speciality'])) {
    $reason = $_POST['reason'];  
    $doctor = $_POST['doctor'];  
    $date = $_POST['date'];  
    $speciality = $_POST['speciality'];  

    // Validate form fields
    if(!empty($reason) && !empty($doctor) && !empty($date) && !empty($speciality)) {
        
        // Prepare the SQL query to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO appointments (reason, doctor, date, speciality) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $reason, $doctor, $date, $speciality);

        // Execute the query
        if($stmt->execute()) {
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
    <title>Hospital Management System | Nake appointments</title>
    <link rel="stylesheet" href="./styles/styles.css">
</head>

<body>
    <?php include "./partials/navbar.php"; ?>

    <div class="contact-page-container">
        <h1 style="display: block; margin-bottom: 30px;">Make appointments</h1>

        <div>
           <form action="make-appointment.php" method="POST" class="appointment-form">
           <div>
                <label for="appointment">Pick the Appointment date</label>
                <input type="date" name="date" class="input-field">
            </div>

            <div>
                <label for="speciality">Spaeciality</label>
                <select name="speciality" id="speciality">
                    <option value="dentist">Dentist</option>
                    <option value="neurologist">Neurologist</option>
                    <option value="cardiologiest">Cardiologiest</option>
                    <option value="dermatologist">Dermatologist</option>
                    <option value="eyes surgeon">Eyes surgeon</option>
                </select>
            </div>

            <div>
                <label for="doctor">Doctor</label>
                <select name="doctor" id="doctor" class="input-field">
                    <option value="nazik">Nazik</option>
                    <option value="jawhar">jawhar</option>
                    <option value="rifkan">rifkan</option>
                    <option value="rizan">rizan</option>
                </select>
            </div>

            <div>
                <label for="reason">Reason</label>
                <textarea name="reason" id="reason" placeholder="Enter the reason ...."></textarea>
            </div>

            <span><?php echo $error; ?></span>

            <button>Make an Appointment</button>
           </form>
            
        </div>
    </div>

    <?php include "./partials/footer.php"; ?>
</body>

</html>