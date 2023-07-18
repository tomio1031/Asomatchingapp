<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");
class ProfileDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=mysql215.phy.lolipop.lan;dbname=LAA1417803-matching;charset=utf8','LAA1417803','LAA1417803');
    }

    public function getProfile($student_id) {
        // Check if the student_id exists
        $sql = "SELECT u.name, u.age, u.gender, u.introduction, u.profile_image, h.hobby 
        FROM Users u 
        INNER JOIN Hobbies h ON u.hobby_id = h.id 
        WHERE u.student_id = :student_id";

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
