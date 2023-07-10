<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class loginDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=mysql215.phy.lolipop.lan;dbname=LAA1417803-matching;charset=utf8','LAA1417803','LAA1417803');
    }

    public function login($student_id, $password) {
        // Check if the student_id exists
        $sql = "SELECT * FROM Users WHERE student_id = :student_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // If the student_id does not exist, return an error message
        if (!$user) {
            return array(
                'Login' => false,
                'Message' => 'Student ID does not exist.',
            );
        }
        
        // If the password does not match, return an error message
        if ($user['password'] !== $password) {
            return array(
                'Login' => false,
                'Message' => 'Invalid password.',
            );
        }

        // If the student_id exists and password matches, return success
        return array(
            'Login' => true,
            'Message' => 'Logged in successfully.',
        );
    }
}
?>
