Team Menber:

Hugo Martins
Charles GROSSIN
Baptiste Bonnichon-Jaques


# Test Unitaire TDD 

## Projet MyWeeklyAllowance

Vous allez concevoir un module de gestion d’argent de poche pour adolescents, selon la méthode TDD (Test Driven Development).
Votre mission : commencer par les tests unitaires, puis développer le code étape par étape jusqu’à ce que tous les tests passent.



## Contexte du projet : MyWeeklyAllowance
L’application MyWeeklyAllowance permet aux parents de gérer un “porte-monnaie virtuel” pour leurs ados.
Chaque adolescent a un compte d’argent de poche, et chaque parent peut :
- créer un compte pour un ado,
- déposer de l’argent,
- enregistrer des dépenses,
- fixer une allocation hebdomadaire automatique.



## Organisation
- Phase 1 – Rédaction des tests unitaires (RED)
- Phase 2 – Implémentation du code (BLUE)
- Phase 3 – Refactoring (GREEN)
- Phase 4 – Vérification de la couverture

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

L'interface web permet de tester toutes les fonctionnalités de l'application :

1. **Créer un compte parent**
   - Cliquez sur "Créer un compte parent"
   - Entrez le nom et un ID unique pour le parent
   - Validez

2. **Créer un compte adolescent**
   - Cliquez sur "Créer un compte adolescent"
   - Sélectionnez le parent
   - Entrez le nom, l'âge et un solde initial (optionnel)
   - Validez

3. **Gérer un compte adolescent**
   - Allez dans "Liste des comptes"
   - Cliquez sur "Gérer" pour un adolescent
   - Vous pouvez :
     - Déposer de l'argent
     - Retirer de l'argent
     - Définir une allocation hebdomadaire
     - Consulter l'historique des dépenses

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
└── README.md               # Ce fichier
```

### Notes importantes

- Les données sont stockées en session PHP (elles seront perdues à la fermeture du navigateur)
- Pour un environnement de production, il faudrait utiliser une base de données
- L'interface web utilise les mêmes classes que les tests unitaires
- Le port par défaut est 8080, vous pouvez le modifier dans `docker-compose.yml` si nécessaire

