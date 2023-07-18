<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");
class friendDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=mysql215.phy.lolipop.lan;dbname=LAA1417803-matching;charset=utf8','LAA1417803','LAA1417803');
    }

    public function friend($id) {
        // Update the status to 'matched' in the Matches table
        $sql = "UPDATE Matches SET status = 'matched' WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    
        if($stmt->rowCount() > 0) {
            return array(
                'Update' => true,
                'Message' => 'マッチングを解除しました'
            );
        } else {
            return array(
                'Update' => false,
                'Message' => 'No match found with this ID.'
            );
        }
    }
    
}
?>
