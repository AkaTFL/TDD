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
            <div class="stat-icon">👨‍👩‍👧‍👦</div>
            <div class="stat-content">
                <span class="stat-number"><?= count($teenagers) ?></span>
                <span class="stat-label">Adolescent(s)</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">💰</div>
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
            ➕ Créer un nouveau compte adolescent
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
                                📅 <?= number_format($teenagerData['weeklyAllowance'], 2) ?> € / semaine
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

