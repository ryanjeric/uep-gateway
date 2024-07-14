<?php
session_start();
unset($_SESSION['super_id']);
header('location:index.php');
?>