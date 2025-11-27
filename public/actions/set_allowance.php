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
    $day = $_POST['day'] ?? '';
    
    // Vérifier que le parent est connecté et que c'est bien son adolescent
    if (empty($loggedInParent) || $parentId !== $loggedInParent) {
        $_SESSION['error'] = "Vous n'êtes pas autorisé à gérer ce compte.";
        header('Location: ../index.php?action=dashboard');
        exit;
    }
    
    if (empty($parentId) || empty($teenagerName) || $amount < 0 || empty($day)) {
        $_SESSION['error'] = "Tous les champs sont requis.";
        header('Location: ../index.php?action=manage&parent_id=' . urlencode($parentId) . '&teenager=' . urlencode($teenagerName));
        exit;
    }
    
    if (!isset($_SESSION['parents'][$parentId]['teenagers'][$teenagerName])) {
        $_SESSION['error'] = "Adolescent non trouvé.";
        header('Location: ../index.php?action=dashboard');
        exit;
    }
    
    // Récupérer le parent
    $parents = unserialize($_SESSION['parents'][$parentId]['object']);
    
    // Définir l'allocation hebdomadaire
    $result = $parents->editWeeklyAllowance($teenagerName, $amount, $day);
    
    // Mettre à jour la session
    $_SESSION['parents'][$parentId]['teenagers'][$teenagerName]['weeklyAllowance'] = $amount;
    $_SESSION['parents'][$parentId]['teenagers'][$teenagerName]['allowanceDay'] = $day;
    $_SESSION['parents'][$parentId]['object'] = serialize($parents);
    
    $dayNames = [
        'Monday' => 'Lundi',
        'Tuesday' => 'Mardi',
        'Wednesday' => 'Mercredi',
        'Thursday' => 'Jeudi',
        'Friday' => 'Vendredi',
        'Saturday' => 'Samedi',
        'Sunday' => 'Dimanche'
    ];
    
    $_SESSION['message'] = "Allocation hebdomadaire de " . number_format($amount, 2) . " € définie pour le " . ($dayNames[$day] ?? $day) . " !";
    header('Location: ../index.php?action=manage&parent_id=' . urlencode($parentId) . '&teenager=' . urlencode($teenagerName));
    exit;
}

header('Location: ../index.php');
exit;

