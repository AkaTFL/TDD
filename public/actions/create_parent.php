<?php
session_start();
require_once __DIR__ . '/../../src/Parents.php';
require_once __DIR__ . '/../../src/Account.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $parentName = $_POST['parent_name'] ?? '';
    $parentId = $_POST['parent_id'] ?? '';
    
    if (empty($parentName) || empty($parentId)) {
        $_SESSION['error'] = "Tous les champs sont requis.";
        header('Location: ../index.php?action=create_parent');
        exit;
    }
    
    if (isset($_SESSION['parents'][$parentId])) {
        $_SESSION['error'] = "Un parent avec cet ID existe déjà.";
        header('Location: ../index.php?action=create_parent');
        exit;
    }
    
    // Créer un compte pour le parent
    $parents = new Parents();
    
    // Stocker dans la session
    $_SESSION['parents'][$parentId] = [
        'name' => $parentName,
        'object' => serialize($parents),
        'teenagers' => []
    ];
    
    $_SESSION['message'] = "Compte parent créé avec succès !";
    header('Location: ../index.php?action=list');
    exit;
}

header('Location: ../index.php');
exit;

