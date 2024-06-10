# SF5 Project CI/CD #

## 📝 Description    
Application Symfony 5.4 Labo pour le projet CI/CD :
L'objectif étant de mettre en place un pipeline CI/CD avec Gitlab CI/CD, SonarCloud, Sentry et Heroku.
Toute la stack Docker nécessaire pour faire fonctionner l'application est déjà prête et présente dans l'application.

##  📑Prérequis pour ce projet [Tous ces outils proposent des formules gratuites]
- Docker Desktop (wSL2 pour Windows | Docker natif pour Linux et MacOS)
- GitLab account
- SonarCloud account
- Sentry account
- Heroku account

##  📑Présentation des outils

### Docker Desktop (wSL2 pour Windows | Docker natif pour Linux et MacOS)
- 👉 Moteur permettant de créer des conteneurs Docker pour isoler des applications et leurs dépendances.

- ![img_3.png](img_3.png)

### GitLab account
- 👉 Plateforme de gestion de dépôts Git, permettant de gérer des projets, des pipelines CI/CD, des issues, des merge requests, etc.

- ![img_4.png](img_4.png)

### SonarCloud account
- 👉 Outil d'analyse de code source qui permet de détecter les bugs, les vulnérabilités et les codes en doublon dans le code source.

-![img_5.png](img_5.png)

### Sentry account
- 👉 Outil de surveillance des erreurs qui permet de surveiller et de corriger les erreurs dans les applications en temps réel.

-![img_6.png](img_6.png)

#### Heroku account
- 👉 Plateforme cloud qui permet de déployer, de gérer et de mettre à l'échelle des applications.

- ![img_7.png](img_7.png)

## 📦 Installation
Faire un fork de ce dépôt
- 👉 Le Fork va permettre de travailler sur une copie du projet original, sans modifier le projet original.

- ![img.png](img.png)
- ![img_1.png](img_1.png)

Puis cloner le dépôt en local sur votre machine (en partant du lien `clone with HTTPS` depuis la branche ```master```.
- 👉 Le clone va permettre de récupérer le projet sur votre machine locale et surtout d'initialiser le dépôt Git local.

- ![img_2.png](img_2.png)
- 👉 Dans votre terminal, exécuter la commande suivante :

```bash
git clone https://gitlab.com/symfony-cast1/sf5-p3.git
```

Une fois le projet cloné, se placer à la racine du projet, ouvrir un terminal puis lancer la commande suivante :
```bash
docker-compose --env-file .env.docker up -d --build
```

Une fois les machines Dockers démarrées, entrer dans le container PHP pour disposer de la console PHP :
```bash
./run_sf5_php
```

Une fois dans le container PHP, installer l'application en local avec composer:
```bash
composer install
```

Toujours dans ce même conteneur PHP : Dupliquer le fichier `.env.local.dist` vers `.env.local`
```bash
cp -p .env.local.dist .env.local
```

Toujours dans ce même conteneur PHP : Jouer les migrations pour `peupler` la base de données
```bash
composer compil
```

## ⚙️Configuration des outils TIERS

### Configuration de GitLab CI/CD
### Configuration de Sentry
### Configuration de SonarCloud
### Configuration de Heroku


## 📑  ️Testing [DEV]

### 1) Création de la BDD de test :

```bash
php bin/console doctrine:database:drop --env=test --if-exists --force
php bin/console doctrine:database:create --env=test

```

### 2) Lancer les tests manuellement dans un terminal :

```bash
php bin/phpunit --testdox
```

### 3) Compiler le theme graphique (optionel)
Si vous voulez modifier les thème CSS, il faudra compiler les style Tailwind avec Webpack.\
Pour cela, installez les vendors javascript :
```bash
yarn install
```


