<?php
include './includes/db.inc.php';

if(isset($_GET['specialty'])) {
    $specialty = $_GET['specialty'];
    $query = "SELECT * FROM doctors WHERE specialty = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $specialty);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $doctors = array();
    while($row = $result->fetch_assoc()) {
        $doctors[] = array(
            'id' => $row['id'],
            'name' => $row['name']
        );
    }
    
    echo json_encode($doctors);
}
