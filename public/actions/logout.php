<?php
session_start();
unset($_SESSION['logged_in_parent']);
$_SESSION['message'] = "Vous avez été déconnecté avec succès.";
header('Location: ../index.php?action=login');
exit;

