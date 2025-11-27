<?php
// Les validations sont déjà faites dans index.php
$parentId = $_GET['parent_id'] ?? '';
$teenagerName = $_GET['teenager'] ?? '';
$parentData = $_SESSION['parents'][$parentId];
$teenagerData = $parentData['teenagers'][$teenagerName];
$expenses = $teenagerData['expenses'] ?? [];
?>

<div class="manage-container">
    <h2>Gérer le compte de <?= htmlspecialchars($teenagerName) ?></h2>
    
    <div class="manage-layout">
        <!-- Solde à gauche -->
        <div class="balance-section">
            <div class="balance-card">
                <div class="balance-header">
                    <h3>💰 Solde actuel</h3>
                </div>
                <div class="balance-amount">
                    <span class="balance-value"><?= number_format($teenagerData['balance'], 2) ?></span>
                    <span class="balance-currency">€</span>
                </div>
                <div class="balance-info">
                    <p><strong>Parent:</strong> <?= htmlspecialchars($parentData['name']) ?></p>
                    <p><strong>Âge:</strong> <?= htmlspecialchars($teenagerData['age']) ?> ans</p>
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
                        <div class="allowance-info">
                            <p><strong>📅 Allocation hebdomadaire:</strong></p>
                            <p class="allowance-amount"><?= number_format($teenagerData['weeklyAllowance'], 2) ?> €</p>
                            <p class="allowance-day">Le <?= $dayNames[$teenagerData['allowanceDay']] ?? $teenagerData['allowanceDay'] ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Actions à droite -->
        <div class="actions-section">
            <div class="action-card">
                <h3>💵 Déposer de l'argent</h3>
                <form method="POST" action="actions/deposit.php">
                    <input type="hidden" name="parent_id" value="<?= htmlspecialchars($parentId) ?>">
                    <input type="hidden" name="teenager_name" value="<?= htmlspecialchars($teenagerName) ?>">
                    <div class="form-group">
                        <label>Montant (€):</label>
                        <input type="number" name="amount" step="0.01" min="0.01" required>
                    </div>
                    <button type="submit" class="btn btn-success">Déposer</button>
                </form>
            </div>

            <div class="action-card">
                <h3>💸 Retirer de l'argent</h3>
                <form method="POST" action="actions/withdraw.php">
                    <input type="hidden" name="parent_id" value="<?= htmlspecialchars($parentId) ?>">
                    <input type="hidden" name="teenager_name" value="<?= htmlspecialchars($teenagerName) ?>">
                    <div class="form-group">
                        <label>Montant (€):</label>
                        <input type="number" name="amount" step="0.01" min="0.01" required>
                    </div>
                    <button type="submit" class="btn btn-danger">Retirer</button>
                </form>
            </div>

            <div class="action-card">
                <h3>📅 Allocation hebdomadaire</h3>
                <form method="POST" action="actions/set_allowance.php">
                    <input type="hidden" name="parent_id" value="<?= htmlspecialchars($parentId) ?>">
                    <input type="hidden" name="teenager_name" value="<?= htmlspecialchars($teenagerName) ?>">
                    <div class="form-group">
                        <label>Montant (€):</label>
                        <input type="number" name="amount" step="0.01" min="0" value="<?= htmlspecialchars($teenagerData['weeklyAllowance'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Jour de la semaine:</label>
                        <select name="day" required>
                            <option value="Monday" <?= ($teenagerData['allowanceDay'] ?? '') === 'Monday' ? 'selected' : '' ?>>Lundi</option>
                            <option value="Tuesday" <?= ($teenagerData['allowanceDay'] ?? '') === 'Tuesday' ? 'selected' : '' ?>>Mardi</option>
                            <option value="Wednesday" <?= ($teenagerData['allowanceDay'] ?? '') === 'Wednesday' ? 'selected' : '' ?>>Mercredi</option>
                            <option value="Thursday" <?= ($teenagerData['allowanceDay'] ?? '') === 'Thursday' ? 'selected' : '' ?>>Jeudi</option>
                            <option value="Friday" <?= ($teenagerData['allowanceDay'] ?? '') === 'Friday' ? 'selected' : '' ?>>Vendredi</option>
                            <option value="Saturday" <?= ($teenagerData['allowanceDay'] ?? '') === 'Saturday' ? 'selected' : '' ?>>Samedi</option>
                            <option value="Sunday" <?= ($teenagerData['allowanceDay'] ?? '') === 'Sunday' ? 'selected' : '' ?>>Dimanche</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary"><?= !empty($teenagerData['weeklyAllowance']) ? 'Modifier' : 'Définir' ?></button>
                </form>
            </div>
        </div>
    </div>

    <div class="expenses-section">
        <h3>📊 Historique des dépenses</h3>
        <?php if (empty($expenses)): ?>
            <p class="no-expenses">Aucune dépense enregistrée.</p>
        <?php else: ?>
            <table class="expenses-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Montant</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($expenses as $expense): ?>
                        <tr>
                            <td><?= htmlspecialchars($expense['date']) ?></td>
                            <td><?= number_format($expense['amount'], 2) ?> €</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <div class="back-link">
        <a href="?action=dashboard" class="btn btn-secondary">← Retour au tableau de bord</a>
    </div>
</div>

