<?php
// Vérifier que le parent est connecté
if (!isset($_SESSION['logged_in_parent'])) {
    $_SESSION['error'] = "Vous devez être connecté pour accéder à cette page.";
    header('Location: index.php?action=login');
    exit;
}

$parentId = $_SESSION['logged_in_parent'];
$parentData = $_SESSION['parents'][$parentId];
$teenagers = $parentData['teenagers'] ?? [];
?>

<div class="dashboard">
    <div class="dashboard-header">
        <div class="dashboard-title">
            <h2>Tableau de bord</h2>
            <p class="dashboard-subtitle"><?= htmlspecialchars($parentData['name']) ?></p>
        </div>
        <a href="actions/logout.php" class="btn btn-secondary">Déconnexion</a>
    </div>

    <div class="dashboard-stats">
        <div class="stat-card">
            <div class="stat-icon">
                <svg width="56" height="56" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 7C16 8.66 14.66 10 13 10C11.34 10 10 8.66 10 7C10 5.34 11.34 4 13 4C14.66 4 16 5.34 16 7ZM13 12C15.67 12 21 13.33 21 16V18H5V16C5 13.33 10.33 12 13 12Z" fill="#000000"/>
                    <path d="M8 7C8 8.66 6.66 10 5 10C3.34 10 2 8.66 2 7C2 5.34 3.34 4 5 4C6.66 4 8 5.34 8 7ZM5 12C7.67 12 13 13.33 13 16V18H-3V16C-3 13.33 2.33 12 5 12Z" fill="#000000"/>
                    <path d="M22 7C22 8.66 20.66 10 19 10C17.34 10 16 8.66 16 7C16 5.34 17.34 4 19 4C20.66 4 22 5.34 22 7ZM19 12C21.67 12 27 13.33 27 16V18H11V16C11 13.33 16.33 12 19 12Z" fill="#000000"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="stat-number"><?= count($teenagers) ?></span>
                <span class="stat-label">Adolescent(s)</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <svg width="56" height="56" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.07 11L6.5 9H4.5L7.5 2H9.5L6.5 9H8.5L9.07 11H7.07ZM14.07 11L13.5 9H11.5L14.5 2H16.5L13.5 9H15.5L16.07 11H14.07ZM7.5 13L8.07 15H10.07L9.5 13H7.5ZM14.5 13L15.07 15H17.07L16.5 13H14.5ZM4 17H20V19H4V17Z" fill="#000000"/>
                </svg>
            </div>
            <div class="stat-content">
                <span class="stat-number">
                    <?php
                    $totalBalance = 0;
                    foreach ($teenagers as $teenagerData) {
                        $totalBalance += $teenagerData['balance'];
                    }
                    echo number_format($totalBalance, 2);
                    ?>
                </span>
                <span class="stat-label">Total des soldes (€)</span>
            </div>
        </div>
    </div>

    <div class="dashboard-actions">
        <a href="?action=create_teenager" class="btn btn-primary btn-large">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 8px;">
                <path d="M19 13H13V19H11V13H5V11H11V5H13V11H19V13Z" fill="#ffffff"/>
            </svg>
            Créer un nouveau compte adolescent
        </a>
    </div>

    <?php if (!empty($teenagers)): ?>
        <div class="teenagers-dashboard">
            <h3>Mes adolescents</h3>
            <div class="teenagers-grid">
                <?php foreach ($teenagers as $teenagerName => $teenagerData): ?>
                    <div class="teenager-dashboard-card">
                        <div class="teenager-card-header">
                            <h4><?= htmlspecialchars($teenagerName) ?></h4>
                            <span class="teenager-age"><?= htmlspecialchars($teenagerData['age']) ?> ans</span>
                        </div>
                        <div class="teenager-card-balance">
                            <span class="balance-label">Solde</span>
                            <span class="balance-amount"><?= number_format($teenagerData['balance'], 2) ?> €</span>
                        </div>
                        <?php if (!empty($teenagerData['weeklyAllowance'])): 
                            $dayNames = [
                                'Monday' => 'Lundi',
                                'Tuesday' => 'Mardi',
                                'Wednesday' => 'Mercredi',
                                'Thursday' => 'Jeudi',
                                'Friday' => 'Vendredi',
                                'Saturday' => 'Samedi',
                                'Sunday' => 'Dimanche'
                            ];
                        ?>
                            <div class="teenager-card-allowance">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: inline-block; vertical-align: middle; margin-right: 6px;">
                                    <path d="M19 4H5C3.89 4 3 4.9 3 6V20C3 21.1 3.89 22 5 22H19C20.1 22 21 21.1 21 20V6C21 4.9 20.1 4 19 4ZM19 20H5V9H19V20ZM7 11H9V13H7V11ZM11 11H13V13H11V11ZM15 11H17V13H15V11Z" fill="#ffffff"/>
                                </svg>
                                <?= number_format($teenagerData['weeklyAllowance'], 2) ?> € / semaine
                                <small>(<?= $dayNames[$teenagerData['allowanceDay']] ?? $teenagerData['allowanceDay'] ?>)</small>
                            </div>
                        <?php endif; ?>
                        <a href="?action=manage&parent_id=<?= urlencode($parentId) ?>&teenager=<?= urlencode($teenagerName) ?>" class="btn btn-primary btn-small">
                            Gérer le compte
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <p>Vous n'avez pas encore créé d'adolescent.</p>
            <a href="?action=create_teenager" class="btn btn-primary">Créer votre premier adolescent</a>
        </div>
    <?php endif; ?>
</div>

