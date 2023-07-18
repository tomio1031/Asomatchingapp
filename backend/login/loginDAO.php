<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");
class loginDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=mysql215.phy.lolipop.lan;dbname=LAA1417803-matching;charset=utf8','LAA1417803','LAA1417803');
    }

    public function login($student_id, $password) {
        if ($student_id === null || $student_id === '') {
            return array(
                'Create' => false,
                'Message' => '学籍番号入力して',
            );
        }
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
                'Message' => '学籍番号が存在しないよ',
            );
        }
        
        // If the password does not match, return an error message
        if ($user['password'] !== $password) {
            return array(
                'Login' => false,
                'Message' => 'パスワードが違いま〜す',
            );
        }

        // If the student_id exists and password matches, return success
        return array(
            'Login' => true,
            'Message' => 'ログイン成功',
        );
    }
}
?>
