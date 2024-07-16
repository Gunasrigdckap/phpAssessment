<?php
header('Content-Type: application/json');

require_once("../model/DB.php");
require_once("../model/student.php");

$dbConnection = new dbConnection();
$conn = $dbConnection->getConnection();

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : 'id'; 
$sortOrder = isset($_GET['sortOrder']) ? $_GET['sortOrder'] : 'asc'; 

if (!in_array($sortBy, ['id', 'name', 'age', 'email'])) {
    $sortBy = 'id';
}

if (!in_array($sortOrder, ['asc', 'desc'])) {
    $sortOrder = 'asc'; 
}

if (!empty($searchTerm)) {
    $stmt = $conn->prepare("SELECT id, name, age, email FROM students WHERE name LIKE ? ORDER BY $sortBy $sortOrder");
    $stmt->execute(["%$searchTerm%"]);
} else {
    
    $stmt = $conn->prepare("SELECT id, name, age, email FROM students ORDER BY $sortBy $sortOrder");
    $stmt->execute();
}

$students = array();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $students[] = array(
        'id' => $row['id'],
        'name' => $row['name'],
        'age' => $row['age'],
        'email' => $row['email']
    );
}

echo json_encode($students);
?>
