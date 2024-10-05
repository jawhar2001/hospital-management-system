<?php
session_start(); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Management System</title>
    <link rel="stylesheet" href="./styles/styles.css">
</head>

<body>
    <?php include "./partials/navbar.php"; ?>
    <?php include "./partials/hero.php"; ?>

    <section>
        <div class="services-container">
            <div>
                <div>
                    <h3>24/7 Hotline</h3>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Obcaecati, tempo</p>
                </div>
            </div>
            <div>
                <div>
                    <h3>Counselling</h3>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Obcaecati, tempo</p>
                </div>
            </div>
            <div>
                <div>
                    <h3>Refund</h3>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Obcaecati, tempo</p>
                </div>
            </div>
        </div>
    </section>

    <?php include "./partials/footer.php"; ?>
</body>

</html>