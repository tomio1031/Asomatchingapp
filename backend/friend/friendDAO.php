<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class friendDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=mysql215.phy.lolipop.lan;dbname=LAA1417803-matching;charset=utf8','LAA1417803','LAA1417803');
    }

    public function friend($student_id) {
       
    }
}
?>
