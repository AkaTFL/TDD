<div class="home">
    <div class="home-hero">
        <h1 class="home-title">💰 WallI</h1>
        <p class="intro">Gérez facilement l'argent de poche de vos adolescents avec une interface moderne et intuitive.</p>
    </div>
    
    <?php if (isset($_SESSION['logged_in_parent'])): ?>
        <div class="home-actions">
            <a href="?action=dashboard" class="btn btn-primary btn-large">Accéder à mon tableau de bord</a>
        </div>
    <?php else: ?>
        <div class="home-actions">
            <a href="?action=login" class="btn btn-primary btn-large">Se connecter ou créer un compte</a>
        </div>
    <?php endif; ?>
</div>

