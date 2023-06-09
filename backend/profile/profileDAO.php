<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ProfileDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=mysql215.phy.lolipop.lan;dbname=LAA1417803-matching;charset=utf8','LAA1417803','LAA1417803');
    }

    public function getProfile($student_id) {
        // Check if the student_id exists
        $sql = "SELECT name, age, hobby_id, introduction, profile_image FROM Users WHERE student_id = :student_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // If the student_id does not exist, return an error message
        if (!$user) {
            return array(
                'Profile' => false,
                'Message' => 'Student ID does not exist.',
            );
        }

        // If the student_id exists, return user profile
        return array(
            'Profile' => true,
            'Message' => 'Profile retrieved successfully.',
            'Data' => $user
        );
    }
}
?>
