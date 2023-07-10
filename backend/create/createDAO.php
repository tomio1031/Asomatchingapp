<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class createDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=mysql215.phy.lolipop.lan;dbname=LAA1417803-matching;charset=utf8','LAA1417803','LAA1417803');

    }

    public function create($student_id, $name, $age, $gender, $password, $hobby_id) {
           // Check if the student_id is null
    if ($password === null) {
        return array(
            'Create' => false,
            'Message' => 'password cannot be null.',
        );
    }
         // Check if the student_id is null
    if ($student_id === null) {
        return array(
            'Create' => false,
            'Message' => 'Student ID cannot be null.',
        );
    }
           // Check if the student_id has 7 digits
           if (strlen((string)$student_id) !== 7) {
            return array(
                'Create' => false,
                'Message' => 'Student ID must be exactly 7 digits.',
            );
        }
        // Check if the student_id already exists
        $sql = "SELECT * FROM Users WHERE student_id = :student_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // If the student_id already exists, return an error message
        if ($user) {
            return array(
                'Create' => false, 
                'Message' => 'Student ID is already taken.',
            );
        }

        // If the student_id does not exist, insert new user profile
        $sql = "INSERT INTO Users (student_id, name, age, gender, password, hobby_id) VALUES (:student_id, :name, :age, :gender, :password, :hobby_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':age', $age, PDO::PARAM_INT);
        $stmt->bindValue(':gender', $gender);
        $stmt->bindValue(':password', $password);
        $stmt->bindValue(':hobby_id', $hobby_id);
        $stmt->execute();

        // return array('Create' => true, 'Message' => 'Profile created successfully.');
         return array(
            'Create' => true, 
            'Message' => 'Profile created successfully.',
            'Data' => array(
                'student_id' => $student_id,
                'name' => $name,
                'age' => $age,
                'gender' => $gender,
                'password' => $password,
                'hobby_id' => $hobby_id,
            )
        );
    }
}
?>
