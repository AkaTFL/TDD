<div class="form-container">
    <h2>Connexion / Création de compte parent</h2>
    
    <div class="login-tabs">
        <button class="tab-button active" onclick="showTab('login')">Connexion</button>
        <button class="tab-button" onclick="showTab('register')">Créer un compte</button>
    </div>

    <!-- Formulaire de connexion -->
    <div id="login-tab" class="tab-content active">
        <form method="POST" action="actions/login.php" class="form">
            <div class="form-group">
                <label for="parent_id">ID du parent :</label>
                <input type="text" id="parent_id" name="parent_id" required placeholder="Ex: parent_001">
            </div>
            
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
    </div>

    <!-- Formulaire de création -->
    <div id="register-tab" class="tab-content">
        <form method="POST" action="actions/register.php" class="form">
            <div class="form-group">
                <label for="parent_name">Nom du parent :</label>
                <input type="text" id="parent_name" name="parent_name" required placeholder="Ex: Jean Dupont">
            </div>
            
            <div class="form-group">
                <label for="parent_id">ID du parent (unique) :</label>
                <input type="text" id="parent_id" name="parent_id" required placeholder="Ex: parent_001">
                <small>Cet ID sera utilisé pour vous connecter</small>
            </div>
            
            <button type="submit" class="btn btn-success">Créer le compte</button>
        </form>
    </div>
</div>

<script>
function showTab(tab) {
    // Masquer tous les onglets
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
    });
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active');
    });
    
    // Afficher l'onglet sélectionné
    document.getElementById(tab + '-tab').classList.add('active');
    event.target.classList.add('active');
}
</script>

