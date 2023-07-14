<?php
header("Access-Control-Allow-Origin: *");
class image_editDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=mysql215.phy.lolipop.lan;dbname=LAA1417803-matching;charset=utf8','LAA1417803','LAA1417803');
    }
    
    public function image_editDAO($student_id, $fileToUpload) {
        // Check if the fileToUpload is not set or not uploaded
        if (!isset($fileToUpload) || !is_uploaded_file($fileToUpload["tmp_name"])) {
            return array(
                'Edit' => false,
                'Message' => '画像ファイルがありません。',
            );
        }
        
        // Upload file
        $target_dir = "uploads/"; // Set your public directory here
        $target_file = $target_dir . basename($fileToUpload["name"]);
        $image_url = "http://learning-sql.kikirara.jp/" . $target_file; // Change "yourdomain.com" to your actual domain
    
        if (!move_uploaded_file($fileToUpload["tmp_name"], $target_file)) {
            return array(
                'Edit' => false,
                'Message' => '画像のアップロードに失敗しました。',
            );
        }
    
        // Update the user information
        $sql = "UPDATE Users SET profile_image = :profile_image WHERE student_id = :student_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':profile_image', $image_url, PDO::PARAM_STR);
        $stmt->bindValue(':student_id', $student_id, PDO::PARAM_INT);

        if(!$stmt->execute()) {
            print_r($stmt->errorInfo());
            return array(
                'Edit' => false,
                'Message' => 'プロフィールの更新に失敗しました。',
            );
        }

        // Return success message
        return array(
            'Edit' => true,
            'Message' => '編集成功',
        );
    }
}  
?>
