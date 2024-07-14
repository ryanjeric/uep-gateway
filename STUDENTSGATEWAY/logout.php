<?php
session_start();
unset($_SESSION['id3']);
header('location:index.php');
?>