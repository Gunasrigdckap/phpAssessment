<?php
header('Content-Type: application/json');

require_once("../model/DB.php");
require_once("../model/student.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $dbConnection = new dbConnection();
    $conn = $dbConnection->getConnection();

    $stmt = $conn->prepare("SELECT id, name, age, email FROM students WHERE id = ?");
    $stmt->execute([$id]);

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo json_encode($row);
    } else {
        echo json_encode(["message" => "Student not found."]);
    }
} else {
    echo json_encode(["message" => "No ID"]);
}
?>

