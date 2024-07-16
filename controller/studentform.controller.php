<?php
require_once("../model/DB.php");
require_once("../model/student.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new StudentController();
    $data = json_decode(file_get_contents("php://input"), true);
    $controller->saveStudent($data);
}

class StudentController {
    private $db;

    public function __construct() {
        $dbConnection = new dbConnection();
        $this->db = $dbConnection->getConnection();
    }

    public function saveStudent($data) {
        $student = new Student($this->db);
        $student->id = $data['id'];
        $student->name = $data['name'];
        $student->age = $data['age'];
        $student->email = $data['email'];
        $student->password = $data['password'];

        if ($student->exists()) {
            if ($student->update()) {
                echo json_encode(["message" => "Student was updated."]);
            } else {
                echo json_encode(["message" => "Unable to update student."]);
            }
        } else {
            if ($student->create()) {
                echo json_encode(["message" => "Student was created."]);
            } else {
                echo json_encode(["message" => "Unable to create student."]);
            }
        }
    }
}
?>
