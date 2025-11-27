<?php
session_start();
require_once __DIR__ . '/../../src/Parents.php';
require_once __DIR__ . '/../../src/Account.php';
require_once __DIR__ . '/../../src/Teenager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $parentId = $_POST['parent_id'] ?? '';
    $loggedInParent = $_SESSION['logged_in_parent'] ?? '';
    $teenagerName = $_POST['teenager_name'] ?? '';
    $amount = floatval($_POST['amount'] ?? 0);
    
    // Vérifier que le parent est connecté et que c'est bien son adolescent
    if (empty($loggedInParent) || $parentId !== $loggedInParent) {
        $_SESSION['error'] = "Vous n'êtes pas autorisé à gérer ce compte.";
        header('Location: ../index.php?action=dashboard');
        exit;
    }
    
    if (empty($parentId) || empty($teenagerName) || $amount <= 0) {
        $_SESSION['error'] = "Montant invalide.";
        header('Location: ../index.php?action=manage&parent_id=' . urlencode($parentId) . '&teenager=' . urlencode($teenagerName));
        exit;
    }
    
    if (!isset($_SESSION['parents'][$parentId]['teenagers'][$teenagerName])) {
        $_SESSION['error'] = "Adolescent non trouvé.";
        header('Location: ../index.php?action=dashboard');
        exit;
    }
    
    try {
        // Récupérer le parent et l'adolescent
        $parents = unserialize($_SESSION['parents'][$parentId]['object']);
        $account = new Account();
        $currentBalance = $_SESSION['parents'][$parentId]['teenagers'][$teenagerName]['balance'];
        $account->deposit($currentBalance);
        
        $teenager = new Teenager($teenagerName, $account, $_SESSION['parents'][$parentId]['teenagers'][$teenagerName]['age']);
        
        // Retirer l'argent
        $newBalance = $parents->withdrawMoney($teenager, $amount);
        
        // Récupérer les dépenses
        $expenses = $account->getExpenses();
        
        // Mettre à jour la session
        $_SESSION['parents'][$parentId]['teenagers'][$teenagerName]['balance'] = $newBalance;
        $_SESSION['parents'][$parentId]['teenagers'][$teenagerName]['expenses'] = $expenses;
        $_SESSION['parents'][$parentId]['object'] = serialize($parents);
        
        $_SESSION['message'] = "Retrait de " . number_format($amount, 2) . " € effectué avec succès !";
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }
    
    header('Location: ../index.php?action=manage&parent_id=' . urlencode($parentId) . '&teenager=' . urlencode($teenagerName));
    exit;
}

header('Location: ../index.php');
exit;

