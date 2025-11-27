<?php
session_start();
require_once __DIR__ . '/../../src/Parents.php';
require_once __DIR__ . '/../../src/Account.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $parentId = $_POST['parent_id'] ?? '';
    
    if (empty($parentId)) {
        $_SESSION['error'] = "L'ID du parent est requis.";
        header('Location: ../index.php?action=login');
        exit;
    }
    
    // Vérifier si le parent existe
    if (!isset($_SESSION['parents'][$parentId])) {
        $_SESSION['error'] = "Aucun compte parent trouvé avec cet ID.";
        header('Location: ../index.php?action=login');
        exit;
    }
    
    // Connecter le parent
    $_SESSION['logged_in_parent'] = $parentId;
    $_SESSION['message'] = "Connexion réussie ! Bienvenue " . $_SESSION['parents'][$parentId]['name'] . ".";
    header('Location: ../index.php?action=dashboard');
    exit;
}

header('Location: ../index.php?action=login');
exit;

