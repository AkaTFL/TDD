<div class="list-container">
    <h2>Liste des comptes</h2>
    
    <?php if (empty($_SESSION['parents'])): ?>
        <div class="alert alert-info">
            Aucun compte parent créé pour le moment.
            <a href="?action=create_parent">Créer le premier parent</a>
        </div>
    <?php else: ?>
        <?php foreach ($_SESSION['parents'] as $parentId => $parentData): ?>
            <div class="parent-card">
                <h3>👨‍👩‍👧‍👦 <?= htmlspecialchars($parentData['name']) ?></h3>
                <p><strong>ID:</strong> <?= htmlspecialchars($parentId) ?></p>
                <p><strong>Nombre d'adolescents:</strong> <?= count($parentData['teenagers']) ?></p>
                
                <?php if (!empty($parentData['teenagers'])): ?>
                    <div class="teenagers-list">
                        <h4>Adolescents :</h4>
                        <?php foreach ($parentData['teenagers'] as $teenagerName => $teenagerData): ?>
                            <div class="teenager-card">
                                <div class="teenager-info">
                                    <strong><?= htmlspecialchars($teenagerName) ?></strong>
                                    <span>Âge: <?= htmlspecialchars($teenagerData['age']) ?> ans</span>
                                    <span class="balance">💰 <?= number_format($teenagerData['balance'], 2) ?> €</span>
                                </div>
                                <div class="teenager-actions">
                                    <a href="?action=manage&parent_id=<?= urlencode($parentId) ?>&teenager=<?= urlencode($teenagerName) ?>" class="btn btn-small btn-primary">Gérer</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="no-teenagers">Aucun adolescent pour ce parent.</p>
                    <a href="?action=create_teenager" class="btn btn-small">Ajouter un adolescent</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

