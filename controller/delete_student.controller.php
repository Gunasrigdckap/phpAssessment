<?php
header('Content-Type: application/json');

require_once("../model/DB.php");
require_once("../model/student.php");

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true); 
    $id = $data['id']; 

    $dbConnection = new dbConnection();
    $conn = $dbConnection->getConnection();

    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    if ($stmt->execute([$id])) {
        echo json_encode(["message" => "Student was deleted."]);
    } else {
        echo json_encode(["message" => "Unable to delete student."]);
    }
} else {
    echo json_encode(["message" => "Invalid request method."]);
}
?>
