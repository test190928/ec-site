<?php

require 'admin.php';
require '../pdo_connect.php';
$error = '';
if (@$_POST['submit']) {
    $code = $_POST['code'];
    if (move_uploaded_file($_FILES['pic']['tmp_name'], "../img/$code.png")) {
        header('Location: index.php');
        exit();
    } else {
        $error .= 'ファイルを選択してください。<br>';
    }
} else {
    $code = $_GET['code'];
}
require 't_upload.php';
?>