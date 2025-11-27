<div class="form-container">
    <h2>Créer un compte parent</h2>
    <form method="POST" action="actions/create_parent.php" class="form">
        <div class="form-group">
            <label for="parent_name">Nom du parent :</label>
            <input type="text" id="parent_name" name="parent_name" required placeholder="Ex: Jean Dupont">
        </div>
        
        <div class="form-group">
            <label for="parent_id">ID du parent (unique) :</label>
            <input type="text" id="parent_id" name="parent_id" required placeholder="Ex: parent_001">
            <small>Cet ID sera utilisé pour identifier ce parent</small>
        </div>
        
        <button type="submit" class="btn btn-primary">Créer le compte parent</button>
        <a href="?action=home" class="btn btn-secondary">Annuler</a>
    </form>
</div>

