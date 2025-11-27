<?php
session_start();
require_once __DIR__ . '/../../src/Parents.php';
require_once __DIR__ . '/../../src/Account.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $parentName = $_POST['parent_name'] ?? '';
    $parentId = $_POST['parent_id'] ?? '';
    
    if (empty($parentName) || empty($parentId)) {
        $_SESSION['error'] = "Tous les champs sont requis.";
        header('Location: ../index.php?action=login');
        exit;
    }
    
    if (isset($_SESSION['parents'][$parentId])) {
        $_SESSION['error'] = "Un parent avec cet ID existe déjà.";
        header('Location: ../index.php?action=login');
        exit;
    }
    
    // Créer un compte pour le parent
    $account = new Account();
    $parents = new Parents($account);
    
    // Stocker dans la session
    $_SESSION['parents'][$parentId] = [
        'name' => $parentName,
        'object' => serialize($parents),
        'teenagers' => []
    ];
    
    // Connecter automatiquement le parent
    $_SESSION['logged_in_parent'] = $parentId;
    
    $_SESSION['message'] = "Compte créé avec succès ! Bienvenue " . $parentName . ".";
    header('Location: ../index.php?action=dashboard');
    exit;
}

header('Location: ../index.php?action=login');
exit;

