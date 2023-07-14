<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");
class readDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=mysql215.phy.lolipop.lan;dbname=LAA1417803-matching;charset=utf8','LAA1417803','LAA1417803');
    }

    public function read($match_id) {
        // Prepare the SQL statement
        $sql = "SELECT sender_id, message, time FROM Chats WHERE match_id = :match_id ORDER BY time ASC";
        $stmt = $this->pdo->prepare($sql);
    
        // Bind the match_id value
        $stmt->bindValue(':match_id', $match_id, PDO::PARAM_INT);
    
        // Execute the SQL statement
        $stmt->execute();
    
        // Fetch all matching messages
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Return the messages
        return $messages;
    }
    
}
?>
