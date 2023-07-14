<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");
class Profile_editDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=mysql215.phy.lolipop.lan;dbname=LAA1417803-matching;charset=utf8','LAA1417803','LAA1417803');
    }

    public function getProfile_edit($student_id, $name, $age, $hobby_id, $introduction) {
        // Check if the student_id exists
        $sql = "SELECT * FROM Users WHERE student_id = :student_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // If the student_id does not exist, return an error message
        if (!$user) {
            return array(
                'Edit' => false,
                'Message' => 'Student ID does not exist.',
            );
        }
        
        // If the student_id exists, update the user information
        $sql = "UPDATE Users SET name = :name, age = :age, hobby_id = :hobby_id, introduction = :introduction WHERE student_id = :student_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':age', $age, PDO::PARAM_INT);
        $stmt->bindValue(':hobby_id', $hobby_id, PDO::PARAM_INT);
        $stmt->bindValue(':introduction', $introduction, PDO::PARAM_STR);
        $stmt->execute();

        // Return success message
        return array(
            'Edit' => true,
            'Message' => 'プロフィールの編集が完了した',
        );
    }
}
?>
