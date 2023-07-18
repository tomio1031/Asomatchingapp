<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");
class historyDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=mysql215.phy.lolipop.lan;dbname=LAA1417803-matching;charset=utf8','LAA1417803','LAA1417803');
    }

    public function history($student_id) {
        $sql = "SELECT id,
                CASE 
                    WHEN user_id = :student_id THEN matched_id
                    WHEN matched_id = :student_id THEN user_id
                END AS matched_id
                FROM Matches 
                WHERE status = 'matched' 
                AND (user_id = :student_id OR matched_id = :student_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->execute();
    
        $matchedRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        if (empty($matchedRows)) {
            return array(
                'Success' => false,
                'Message' => 'トーク履歴がありません。'
            );
        }
    
        return array(
            'Success' => true,
            'Matched' => $matchedRows
        );
    }
    
}

?>
