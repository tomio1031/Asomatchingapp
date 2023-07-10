<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class matchDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=mysql215.phy.lolipop.lan;dbname=LAA1417803-matching;charset=utf8','LAA1417803','LAA1417803');
    }

    public function matching($student_id) {
        // Fetch the hobby_id of the student
        $sql = "SELECT hobby_id FROM Users WHERE student_id = :student_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->execute();
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if(!$result) {
            return array(
                'Match' => false,
                'Message' => 'No student found with this ID.'
            );
        }
    
        $hobby_id = $result['hobby_id'];
    
        // Find other students with the same hobby_id
        $sql = "SELECT student_id FROM Users WHERE hobby_id = :hobby_id AND student_id != :student_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':hobby_id', $hobby_id, PDO::PARAM_INT);
        $stmt->bindValue(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->execute();
    
        $matches = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        if(empty($matches)) {
            return array(
                'Match' => false,
                'Message' => 'No students found with the same hobby. You may want to consider changing your hobby.'
            );
        }
    
        return array(
            'Match' => true,
            'Message' => 'Matched students found.',
            'Matches' => $matches
        );
    }
    
}
?>
