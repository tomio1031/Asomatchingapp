<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'loginDAO.php';
require_once 'createDAO.php';
require_once 'profileDAO.php';
require_once 'profile_editDAO.php';
require_once 'imageDAO.php';
require_once 'matchDAO.php';

$message = 'No API exists';

if (isset($_POST['login'])) {
    $loginDao = new LoginDAO();
    $message = $loginDao->login($_POST['student_id'], $_POST['password']);
}
if (isset($_POST['create'])) {
    $createDao = new createDAO();
    $message = $createDao->create($_POST['student_id'], $_POST['name'], $_POST['age'], $_POST['gender'], $_POST['password'], $_POST['hobby_id']);
}
if (isset($_POST['profile'])) {
    $profileDao = new ProfileDAO();
    $message = $profileDao->getProfile($_POST['student_id']);
}
if (isset($_POST['profile_edit'])) {
    $profile_editDao = new Profile_editDAO();
    $message = $profile_editDao->getProfile_edit($_POST['student_id'],$_POST['name'],$_POST['age'],$_POST['hobby_id'],$_POST['introduction']);
}

if (isset($_POST['image_edit'])) {
    $image_editDao = new image_editDAO();
    $message = $image_editDao->image_editDAO($_POST['student_id'], $_FILES['fileToUpload']);
}
if (isset($_POST['match'])) {
    $matchDao = new matchDAO();
    $message = $matchDao->matching($_POST['student_id']);
}
echo json_encode($message);
?>