<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");
class sendDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=mysql215.phy.lolipop.lan;dbname=LAA1417803-matching;charset=utf8','LAA1417803','LAA1417803');
    }

    public function send($sender_id, $message, $match_id) {
        // Insert the message
        $sql = "INSERT INTO Chats (sender_id, message, match_id, time) VALUES (:sender_id, :message, :match_id, NOW())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':sender_id', $sender_id, PDO::PARAM_INT);
        $stmt->bindValue(':message', $message, PDO::PARAM_STR);
        $stmt->bindValue(':match_id', $match_id, PDO::PARAM_INT);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return array(
                'Success' => true,
                'Message' => '送信完了'
            );
        }else{
            return array(
                'Success' => false,
                'Message' => '送信失敗'
            );
        }
    }
}
?>
