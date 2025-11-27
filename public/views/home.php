<div class="home">
    <div style="text-align: center; margin-bottom: 3rem;">
        <h1 style="font-size: 3rem; font-weight: 800; margin-bottom: 1rem; background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
            💰 MyWeeklyAllowance
        </h1>
        <p class="intro">Gérez facilement l'argent de poche de vos adolescents avec une interface moderne et intuitive.</p>
    </div>
    
    <?php if (isset($_SESSION['logged_in_parent'])): ?>
        <div style="text-align: center; margin: 2rem 0;">
            <a href="?action=dashboard" class="btn btn-primary btn-large">Accéder à mon tableau de bord</a>
        </div>
    <?php else: ?>
        <div style="text-align: center; margin: 2rem 0;">
            <a href="?action=login" class="btn btn-primary btn-large">Se connecter ou créer un compte</a>
        </div>
    <?php endif; ?>
</div>

