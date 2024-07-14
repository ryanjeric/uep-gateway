<?php
session_start();
unset($_SESSION['id2']);
header('location:index.php');
?>