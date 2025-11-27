<?php
// Le parent connecté est automatiquement utilisé
$parentId = $_SESSION['logged_in_parent'] ?? '';
$parentData = $_SESSION['parents'][$parentId] ?? null;
?>

<div class="form-container">
    <h2>Créer un compte adolescent</h2>
    <p class="form-subtitle">Ce compte sera lié à votre compte parent : <strong><?= htmlspecialchars($parentData['name'] ?? '') ?></strong></p>
    
    <form method="POST" action="actions/create_teenager.php" class="form">
        <input type="hidden" name="parent_id" value="<?= htmlspecialchars($parentId) ?>">
        
        <div class="form-group">
            <label for="teenager_name">Nom de l'adolescent :</label>
            <input type="text" id="teenager_name" name="teenager_name" required placeholder="Ex: Marie Dupont">
        </div>
        
        <div class="form-group">
            <label for="teenager_age">Âge :</label>
            <input type="number" id="teenager_age" name="teenager_age" required min="10" max="18" value="15">
        </div>
        
        <div class="form-group">
            <label for="initial_balance">Solde initial (optionnel) :</label>
            <input type="number" id="initial_balance" name="initial_balance" min="0" step="0.01" value="0">
        </div>
        
        <button type="submit" class="btn btn-primary">Créer le compte adolescent</button>
        <a href="?action=dashboard" class="btn btn-secondary">Annuler</a>
    </form>
</div>

