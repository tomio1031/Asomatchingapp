<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");

class matchDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=mysql215.phy.lolipop.lan;dbname=LAA1417803-matching;charset=utf8','LAA1417803','LAA1417803');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // Set the PDO error mode to exception
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
    
        // Check if there's an existing 'matching' status
        $sql = "SELECT * FROM Matches WHERE (user_id = :student_id OR matched_id = :student_id) AND status = 'matching'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->execute();
    
        $existingMatching = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($existingMatching) {
            return array(
                'Match' => false,
                'Message' => 'Student ID ' . $student_id . ' はすでにマッチングしています。'
            );
        }
    
        // If there's no existing 'matching' status, find students with the same hobby who have never matched with the student
        $sql = "SELECT student_id FROM Users WHERE hobby_id = :hobby_id AND student_id != :student_id AND student_id NOT IN (SELECT user_id FROM Matches WHERE matched_id = :student_id) AND student_id NOT IN (SELECT matched_id FROM Matches WHERE user_id = :student_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':hobby_id', $hobby_id, PDO::PARAM_INT);
        $stmt->bindValue(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->execute();
    
        $possibleMatches = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        if (empty($possibleMatches)) {
            return array(
                'Match' => false,
                'Message' => '相手がいないようです。趣味を変更しましょう。',
                'Debug' => "Hobby ID: $hobby_id, Possible Matches: " . json_encode($possibleMatches)  // Debug message
            );
        }
    
        // Pick a random student from the matches
        $randomMatch = $possibleMatches[array_rand($possibleMatches)];
        // Add the match to the Matches table
        $sql = "INSERT INTO Matches (user_id, matched_id, status) VALUES (:student_id, :matched_id, 'matching')";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->bindValue(':matched_id', $randomMatch['student_id'], PDO::PARAM_INT);
        $stmt->execute();
        
        // Get the ID of the inserted match
        $matchId = $this->pdo->lastInsertId();
        
        return array(
            'Match' => true,
            'Message' => 'マッチング成功',
            'Matched Student' => $randomMatch['student_id'],
            'Match_id' => $matchId
        );
        
    }
    
}
?>
