
<nav class="navbar">
    <div class="nav-container">
        <div class="logo"><span class="logo-span-1">HopeWell</span> <span class="logo-span-2">Hospital</span></div>

        <?php
        if (!isset($_SESSION['email'])) {
        ?>
            <div class="nav-links">
                <a href="index.php">Home</a>
                <a href="contact.php">Contact</a>
                <a href="about.php">About</a>
                <a href="signin.php" class="primary-btn">Sign in</a>
            </div>

        <?php
        } else {
        ?>
            <div class="nav-links">
                <a href="index.php">Home</a>
                <a href="contact.php">Contact</a>
                <a href="about.php">About</a>
                <a href="all-appointments.php">All Appointment</a>
                <a href="my-appointments.php">My Appointment</a>
                <a href="appointments.php">Appointment</a>
                <a href="doctors.php">Doctors</a>
                <a href="users.php">Users</a>
                <a href="signout.php" class="primary-btn">Sign out</a>
            </div>

        <?php
        }
        ?>
    </div>
</nav>