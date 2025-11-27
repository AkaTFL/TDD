Team Menber:

Hugo Martins
Charles GROSSIN
Baptiste Bonnichon-Jaques


# Test Unitaire TDD 

## Projet WallI

Vous allez concevoir un module de gestion d’argent de poche pour adolescents, selon la méthode TDD (Test Driven Development).
Votre mission : commencer par les tests unitaires, puis développer le code étape par étape jusqu’à ce que tous les tests passent.



## Contexte du projet : WallI
L'application WallI permet aux parents de gérer un "porte-monnaie virtuel" pour leurs ados.
Chaque adolescent a un compte d’argent de poche, et chaque parent peut :
- créer un compte pour un ado,
- déposer de l’argent,
- enregistrer des dépenses,
- fixer une allocation hebdomadaire automatique.



## Organisation TDD

Le projet suit la méthodologie TDD (Test Driven Development) :

- ✅ **Phase 1 – Rédaction des tests unitaires (RED)** : Complétée
  - Tests unitaires écrits pour toutes les classes principales
  - Tests couvrant les fonctionnalités de base
  
- ✅ **Phase 2 – Implémentation du code (BLUE)** : Complétée
  - Code implémenté pour faire passer tous les tests
  - Classes fonctionnelles : `Parents`, `Teenager`, `Account`, `User`
  
- ✅ **Phase 3 – Refactoring (GREEN)** : Complétée
  - Amélioration de la qualité du code
  - Élimination des duplications (withdrawCash/withdrawMoney)
  - Optimisation de la structure (constructeur Parents)
  - Ajout de documentation PHPDoc complète
  
- ✅ **Phase 4 – Vérification de la couverture** : Complétée
  - Configuration de la couverture de code (phpunit.xml)
  - Génération de rapports de couverture (HTML, texte, Clover)
  - Scripts Composer pour faciliter l'exécution

## Installation et utilisation

### Prérequis
- Docker et Docker Compose installés sur votre machine
- Git (pour cloner le projet)

### Installation avec Docker

1. **Cloner le projet** (si ce n'est pas déjà fait)
   ```bash
   git clone <url-du-repo>
   cd TDD
   ```

2. **Construire et lancer les conteneurs Docker**
   ```bash
   docker-compose up -d --build
   ```

3. **Accéder à l'interface web**
   Ouvrez votre navigateur et allez à : `http://localhost:8080`

4. **Arrêter les conteneurs** (quand vous avez terminé)
   ```bash
   docker-compose down
   ```

### Utilisation de l'interface web

L'interface web permet de tester toutes les fonctionnalités de l'application avec un système d'authentification :

#### 1. **Créer un compte parent et se connecter**

À votre première visite, vous serez redirigé vers la page de connexion :

- **Créer un compte** :
  - Cliquez sur l'onglet "Créer un compte"
  - Entrez votre nom (ex: Jean Dupont)
  - Choisissez un ID unique (ex: parent_001)
  - Cliquez sur "Créer le compte"
  - Vous serez automatiquement connecté et redirigé vers votre tableau de bord

- **Se connecter** (si vous avez déjà un compte) :
  - Entrez votre ID parent dans l'onglet "Connexion"
  - Cliquez sur "Se connecter"

#### 2. **Tableau de bord**

Une fois connecté, vous accédez à votre tableau de bord qui affiche :
- Le nombre d'adolescents que vous gérez
- Le total des soldes de tous vos adolescents
- La liste de tous vos adolescents avec leurs soldes actuels

#### 3. **Créer un compte adolescent**

- Cliquez sur "Créer un adolescent" dans le menu ou sur le bouton du tableau de bord
- Entrez le nom de l'adolescent
- Entrez l'âge (entre 10 et 18 ans)
- Optionnellement, définissez un solde initial
- Cliquez sur "Créer le compte adolescent"

#### 4. **Gérer un compte adolescent**

- Depuis le tableau de bord, cliquez sur "Gérer le compte" pour un adolescent
- Vous pouvez alors :
  - **Déposer de l'argent** : Ajouter de l'argent au compte
  - **Retirer de l'argent** : Enregistrer une dépense et retirer de l'argent
  - **Définir une allocation hebdomadaire** : Configurer un montant et un jour de la semaine pour l'allocation automatique
  - **Consulter l'historique des dépenses** : Voir toutes les dépenses enregistrées avec leurs dates

#### 5. **Déconnexion**

- Cliquez sur "Déconnexion" dans le menu pour vous déconnecter
- Vous serez redirigé vers la page de connexion

### Exécution des tests unitaires

Pour lancer les tests unitaires PHPUnit :

```bash
# Depuis l'intérieur du conteneur Docker
docker-compose exec web vendor/bin/phpunit tests/

# Ou depuis votre machine (si PHP est installé localement)
vendor/bin/phpunit tests/
```

Pour lancer un fichier de test spécifique :

```bash
vendor/bin/phpunit tests/TeenagerTest.php
vendor/bin/phpunit tests/ParentsTest.php
vendor/bin/phpunit tests/AccountTest.php
```

### Génération du rapport de couverture de code

Pour générer un rapport de couverture de code, vous devez d'abord avoir l'extension Xdebug ou PCOV installée :

**Avec Composer :**
```bash
composer test:coverage
```

**Avec PHPUnit directement :**
```bash
# Génération du rapport HTML (recommandé)
vendor/bin/phpunit --coverage-html coverage/html

# Génération du rapport texte (affiché dans la console)
vendor/bin/phpunit --coverage-text

# Génération de tous les rapports (HTML, texte et Clover XML)
# La configuration dans phpunit.xml génère automatiquement tous les rapports
vendor/bin/phpunit
```

**Depuis Docker :**
```bash
docker-compose exec web vendor/bin/phpunit --coverage-html coverage/html
```

**Consulter le rapport :**
- Ouvrez `coverage/html/index.html` dans votre navigateur pour voir le rapport HTML interactif
- Le rapport texte est disponible dans `coverage/coverage.txt`
- Le rapport Clover (XML) est disponible dans `coverage/clover.xml` pour intégration CI/CD

**Note importante :** Pour générer la couverture de code, vous devez avoir **Xdebug** ou **PCOV** installé.

**Vérifier si un driver est disponible :**
```bash
php -m | findstr -i "xdebug\|pcov"
```

**Si aucun driver n'est disponible :**

**Sur Windows (avec XAMPP/WAMP) :**
1. Téléchargez Xdebug depuis https://xdebug.org/download
2. Placez le fichier `php_xdebug.dll` dans le dossier `ext` de PHP
3. Ajoutez dans `php.ini` :
   ```ini
   [Xdebug]
   zend_extension=xdebug
   ```

**Avec Docker :**
```bash
# Pour Xdebug
docker-compose exec web pecl install xdebug
docker-compose exec web docker-php-ext-enable xdebug

# Ou pour PCOV (plus rapide, recommandé)
docker-compose exec web pecl install pcov
docker-compose exec web docker-php-ext-enable pcov
```

**Alternative :** Si vous ne pouvez pas installer Xdebug/PCOV, vous pouvez toujours exécuter les tests sans couverture :
```bash
vendor/bin/phpunit tests/ --no-coverage
```

### Design de l'interface

L'interface web utilise un design moderne inspiré des banques en ligne :
- **Thème** : Noir et blanc avec dégradés de gris
- **Style** : Flat design avec des icônes SVG
- **Responsive** : Interface adaptative pour mobile et desktop
- **Animations** : Transitions fluides et notifications automatiques
- **UX** : Navigation intuitive avec système d'onglets pour la connexion

### Structure du projet

```
TDD/
├── src/                    # Code source des classes
│   ├── Parents.php
│   ├── Teenager.php
│   ├── Account.php
│   └── User.php
├── tests/                  # Tests unitaires
│   ├── ParentsTest.php
│   ├── TeenagerTest.php
│   └── AccountTest.php
├── public/                 # Interface web
│   ├── index.php
│   ├── views/              # Vues de l'interface
│   ├── actions/            # Actions PHP (formulaires)
│   └── assets/
│       └── css/
│           └── style.css
├── Dockerfile              # Configuration Docker
├── docker-compose.yml      # Configuration Docker Compose
├── composer.json           # Dépendances PHP
├── phpunit.xml             # Configuration PHPUnit et couverture
├── coverage/                # Rapports de couverture de code (généré)
│   ├── html/               # Rapport HTML interactif
│   ├── coverage.txt        # Rapport texte
│   └── clover.xml          # Rapport Clover (XML)
└── README.md               # Ce fichier
```

### Notes importantes

- **Authentification** : L'application utilise un système de session PHP pour l'authentification. Vous devez être connecté pour accéder au tableau de bord et gérer les comptes.
- **Stockage des données** : Les données sont stockées en session PHP (elles seront perdues à la fermeture du navigateur ou après déconnexion)
- **Sécurité** : Pour un environnement de production, il faudrait utiliser une base de données et un système d'authentification plus robuste (mots de passe hashés, etc.)
- **Architecture** : L'interface web utilise les mêmes classes que les tests unitaires (`Parents`, `Teenager`, `Account`)
- **Port** : Le port par défaut est 8080, vous pouvez le modifier dans `docker-compose.yml` si nécessaire
- **Notifications** : Les messages de succès et d'erreur s'affichent automatiquement et disparaissent après 5 secondes

