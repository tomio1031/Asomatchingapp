<?php
class image_editDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=mysql215.phy.lolipop.lan;dbname=LAA1417803-matching;charset=utf8','LAA1417803','LAA1417803');
    }
    public function image_editDAO($student_id, $fileToUpload) {
        // Check if the student_id exists
        $sql = "SELECT * FROM Users WHERE student_id = :student_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->execute();
    
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // If the student_id does not exist, return an error message
        if (!$user) {
            return array(
                'Edit' => false,
                'Message' => 'Student ID does not exist.',
            );
        }
        
        // Upload file
        $target_dir = "uploads/"; // Set your public directory here
        $target_file = $target_dir . basename($fileToUpload["name"]);
        $image_url = "http://learning-sql.kikirara.jp/" . $target_file; // Change "yourdomain.com" to your actual domain
    
        if (!move_uploaded_file($fileToUpload["tmp_name"], $target_file)) {
            return array(
                'Edit' => false,
                'Message' => 'Failed to upload image.',
            );
        }
    
        // If the student_id exists, update the user information
       // If the student_id exists, update the user information
// If the student_id exists, update the user information
$sql = "UPDATE Users SET profile_image = :profile_image WHERE student_id = :student_id";
$stmt = $this->pdo->prepare($sql);
$stmt->bindValue(':profile_image', $image_url, PDO::PARAM_STR);
$stmt->bindValue(':student_id', $student_id, PDO::PARAM_INT);
$stmt->execute();

if(!$stmt->execute()) {
    print_r($stmt->errorInfo());
    return array(
        'Edit' => false,
        'Message' => 'Failed to update profile.',
    );
}

// Return success message
return array(
    'Edit' => true,
    'Message' => 'Profile updated successfully.',
);

    }
    
}  
?>
