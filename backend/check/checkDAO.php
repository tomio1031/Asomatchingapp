<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");
class checkDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=mysql215.phy.lolipop.lan;dbname=LAA1417803-matching;charset=utf8','LAA1417803','LAA1417803');
    }

    public function check($student_id) {
        $stmt = $this->pdo->prepare(
            "SELECT id, IF(user_id = :student_id, matched_id, user_id) AS other_student_id
            FROM Matches
            WHERE (user_id = :student_id OR matched_id = :student_id) 
            AND status = 'matching'"
        );
        
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($result)) {
            return array('check' => false, 'message' => '存在しません');
        }
        
        return $result;
    }
    
    
}
?>
