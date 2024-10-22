<?php
session_start();
unset($_SESSION['cur_login']);
header('location: ../../giangvien/account/login.php');
exit();
?>

