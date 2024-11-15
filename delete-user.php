<?php
include './includes/db.inc.php';

if (isset($_GET['id'])) {
    $id = $_GET['id']; // Assign the 'id' parameter to $id

    $query = "DELETE FROM users WHERE id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $id);

    if ($stmt->execute()) {
        echo "User deleted successfully";
    } else {
        echo "Error deleting user: " . $stmt->error;
    }

    $stmt->close(); // Close the statement
    $conn->close(); // Close the database connection
}
?>
