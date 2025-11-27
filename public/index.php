<?php
session_start();
require_once __DIR__ . '/../src/Parents.php';
require_once __DIR__ . '/../src/Account.php';
require_once __DIR__ . '/../src/Teenager.php';
require_once __DIR__ . '/../src/User.php';

// Initialiser la session si nécessaire
if (!isset($_SESSION['parents'])) {
    $_SESSION['parents'] = [];
}

// Gérer les actions
$action = $_GET['action'] ?? 'home';
$message = $_SESSION['message'] ?? '';
$error = $_SESSION['error'] ?? '';
unset($_SESSION['message'], $_SESSION['error']);

// Vérifier l'authentification pour les actions protégées
$protectedActions = ['dashboard', 'create_teenager', 'manage', 'deposit', 'withdraw', 'set_allowance'];
if (in_array($action, $protectedActions) && !isset($_SESSION['logged_in_parent'])) {
    $_SESSION['error'] = "Vous devez être connecté pour accéder à cette page.";
    header('Location: index.php?action=login');
    exit;
}

// Valider les paramètres pour l'action 'manage' avant d'envoyer du HTML
if ($action === 'manage') {
    $parentId = $_GET['parent_id'] ?? '';
    $teenagerName = $_GET['teenager'] ?? '';
    $loggedInParent = $_SESSION['logged_in_parent'] ?? '';
    
    if (empty($parentId) || empty($teenagerName) || !isset($_SESSION['parents'][$parentId]['teenagers'][$teenagerName])) {
        $_SESSION['error'] = "Adolescent non trouvé.";
        header('Location: index.php?action=dashboard');
        exit;
    }
    
    // Vérifier que le parent connecté est bien le propriétaire
    if ($parentId !== $loggedInParent) {
        $_SESSION['error'] = "Vous n'avez pas accès à ce compte.";
        header('Location: index.php?action=dashboard');
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyWeeklyAllowance - Gestion d'argent de poche</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <h1>💰 MyWeeklyAllowance</h1>
            <ul class="nav-menu">
                <?php if (isset($_SESSION['logged_in_parent'])): ?>
                    <li><a href="?action=dashboard">Tableau de bord</a></li>
                    <li><a href="?action=create_teenager">Créer un adolescent</a></li>
                    <li><a href="actions/logout.php">Déconnexion</a></li>
                <?php else: ?>
                    <li><a href="?action=login">Connexion</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container">
        <?php if ($message): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php
        switch ($action) {
            case 'login':
                include 'views/login.php';
                break;
            case 'dashboard':
                include 'views/dashboard.php';
                break;
            case 'create_teenager':
                include 'views/create_teenager.php';
                break;
            case 'manage':
                include 'views/manage.php';
                break;
            case 'deposit':
                include 'actions/deposit.php';
                break;
            case 'withdraw':
                include 'actions/withdraw.php';
                break;
            case 'set_allowance':
                include 'actions/set_allowance.php';
                break;
            default:
                if (isset($_SESSION['logged_in_parent'])) {
                    include 'views/dashboard.php';
                } else {
                    include 'views/login.php';
                }
        }
        ?>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2025 Freeky-Team</p>
        </div>
    </footer>
</body>
</html>

