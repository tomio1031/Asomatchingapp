<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");
class createDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=mysql215.phy.lolipop.lan;dbname=LAA1417803-matching;charset=utf8','LAA1417803','LAA1417803');
    }

    public function create($student_id, $name, $age, $gender, $password, $hobby_id) {
          // Check if student_id is null
        if ($student_id === null || $student_id === '') {
            return array(
                'Create' => false,
                'Message' => '学籍番号入力して',
            );
        }
        // Check if student_id has 7 digits
        if (strlen((string)$student_id) !== 7) {
            return array(
                'Create' => false,
                'Message' => '学籍番号は7文字だよ',
            );
        }

        // Check if student_id already exists
        $sql = "SELECT * FROM Users WHERE student_id = :student_id";
    $stmt = $this->pdo->prepare($sql);
    // BINDING STUDENT ID AS STRING HERE
    $stmt->bindValue(':student_id', $student_id, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
        // If the student_id already exists, return an error message
        if ($user) {
            return array(
                'Create' => false, 
                'Message' => '学籍番号がすでに存在しているよ',
            );
        }
        // Check if name is null
        if ($name === null|| $name === '') {
            return array(
                'Create' => false,
                'Message' => '名前がNullだよ',
            );
        }
        // Check if age is null or not within the range 18-60
        if ($age === null || $age < 18 || $age > 60) {
            return array(
                'Create' => false,
                'Message' => '正しい年齢を入力して',
            );
        }
        // Check if gender is null
        if ($gender === null|| $gender === '') {
            return array(
                'Create' => false,
                'Message' => '性別を選択して',
            );
        }
       // Check if password is null
       if ($password === null || $password === '') {
        return array(
            'Create' => false,
            'Message' => 'パスワード入力して',
        );
    }
        // Check if hobby_id is null
        if ($hobby_id === null|| $hobby_id === '') {
            return array(
                'Create' => false,
                'Message' => '趣味を選択してね',
            );
        }
        // If all checks pass, insert new user profile
        $sql = "INSERT INTO Users (student_id, name, age, gender, password, hobby_id) VALUES (:student_id, :name, :age, :gender, :password, :hobby_id)";
        $stmt = $this->pdo->prepare($sql);
        // BINDING STUDENT ID AS STRING HERE
        $stmt->bindValue(':student_id', $student_id, PDO::PARAM_STR);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':age', $age, PDO::PARAM_INT);
        $stmt->bindValue(':gender', $gender);
        $stmt->bindValue(':password', $password);
        $stmt->bindValue(':hobby_id', $hobby_id);
        $stmt->execute();

        return array(
            'Create' => true, 
            'Message' => '会員登録成功',
            'Data' => array(
                'student_id' => $student_id,
                'name' => $name,
                'age' => $age,
                'gender' => $gender,
                'password' => $password,
                'hobby_id' => $hobby_id,
            )
        );
    }
}
?>
