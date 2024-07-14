<?php
session_start();
unset($_SESSION['id4']);
header('location:index.php');
?>