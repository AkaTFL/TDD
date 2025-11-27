<?php
session_start();
require_once __DIR__ . '/../../src/Parents.php';
require_once __DIR__ . '/../../src/Account.php';
require_once __DIR__ . '/../../src/Teenager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $parentId = $_POST['parent_id'] ?? '';
    $loggedInParent = $_SESSION['logged_in_parent'] ?? '';
    $teenagerName = $_POST['teenager_name'] ?? '';
    $teenagerAge = intval($_POST['teenager_age'] ?? 15);
    $initialBalance = floatval($_POST['initial_balance'] ?? 0);
    
    // Vérifier que le parent est connecté et que c'est bien lui qui crée l'adolescent
    if (empty($loggedInParent) || $parentId !== $loggedInParent) {
        $_SESSION['error'] = "Vous n'êtes pas autorisé à créer un adolescent pour ce compte.";
        header('Location: ../index.php?action=dashboard');
        exit;
    }
    
    if (empty($parentId) || empty($teenagerName)) {
        $_SESSION['error'] = "Tous les champs sont requis.";
        header('Location: ../index.php?action=create_teenager');
        exit;
    }
    
    if (!isset($_SESSION['parents'][$parentId])) {
        $_SESSION['error'] = "Parent non trouvé.";
        header('Location: ../index.php?action=dashboard');
        exit;
    }
    
    // Vérifier si l'adolescent existe déjà
    if (isset($_SESSION['parents'][$parentId]['teenagers'][$teenagerName])) {
        $_SESSION['error'] = "Un adolescent avec ce nom existe déjà pour ce parent.";
        header('Location: ../index.php?action=create_teenager');
        exit;
    }
    
    // Créer le compte et l'adolescent
    $account = new Account();
    if ($initialBalance > 0) {
        $account->deposit($initialBalance);
    }
    
    $teenager = new Teenager($teenagerName, $account, $teenagerAge);
    
    // Récupérer le parent
    $parents = unserialize($_SESSION['parents'][$parentId]['object']);
    $parents->addTeenager($teenagerName, $account);
    
    // Stocker dans la session
    $_SESSION['parents'][$parentId]['teenagers'][$teenagerName] = [
        'age' => $teenagerAge,
        'balance' => $account->getBalance(),
        'expenses' => [],
        'weeklyAllowance' => null,
        'allowanceDay' => null
    ];
    
    $_SESSION['parents'][$parentId]['object'] = serialize($parents);
    
    $_SESSION['message'] = "Compte adolescent créé avec succès !";
    header('Location: ../index.php?action=dashboard');
    exit;
}

header('Location: ../index.php');
exit;

