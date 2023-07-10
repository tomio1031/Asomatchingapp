<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'loginDAO.php';
require_once 'createDAO.php';
// require_once 'imageDAO.php';

$message = 'No API exists';

if (isset($_POST['login'])) {
    $loginDao = new LoginDAO();
    $message = $loginDao->login($_POST['student_id'], $_POST['password']);
}
if (isset($_POST['create'])) {
    $createDao = new createDAO();
    $message = $createDao->create($_POST['student_id'], $_POST['name'], $_POST['age'], $_POST['gender'], $_POST['password'], $_POST['hobby_id']);
}
// if (isset($_POST['image'])) {
//     $imageDao = new ImageDAO();
//     $message = $imageDao->processImage($_FILES['imageFile'], $_POST['id']); // idを渡して画像を特定のユーザに関連付ける
// }
echo json_encode($message);
?>