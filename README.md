# Hackathon Symfony

## Contexte

Cet hackathon a pour but de vous faire progresser sur Symfony et ses technologies annexes.

Le **thème** de cette année est : **les jeux olympiques !**

![JO Paris 2024](images/LogoJOParis2024.svg)

Vous développerez une application utile pour au moins une de ces catégories :
- les athlètes 
- les organisateurs
- les visiteurs
- les fédérations
- une épreuve
- ...


Imaginez l'application ultime des JO !

## Prérequis

Pour les WDI, il faut que vous ayez WSL, docker et docker compose installé sur votre machine.

Vous pouvez compter sur les DFS pour vous aider à installer ce qu'il faut.

Vous pouvez utiliser la partie prérequis de cette [documentation](https://gitlab.univ-lr.fr/ntrugeon/docker-symfony-wp-2022/-/blob/main/doc/MACHINEPERSOWINDOWS.md)

Vous pouvez également utiliser les machines virtuelles Ubuntu 20.04 - R.192. Docker y est déjà installé... Par contre, attention, il n'y a pas de sauvegarde ! Pensez à push !

## Projet initial

- J'ai créé une nouvelle stack propre. 
- Un sous groupe par équipe a été créé dans le groupe gitlab [hackathons 2024](https://gitlab.univ-lr.fr/hackathons2024/symfony). Au moins un membre de votre équipe est propriétaire de ce groupe et peut ajouter les autres membres de l'équipe.
- Vous forkerez ce projet dans votre groupe pour travailler.
- Faites en sorte qu'aucune image docker ne tourne avant de faire les make build, make up.

## Installation sur votre poste

```shell
git clone https://gitlab.univ-lr.fr/hackathon2024/symfony/nom_equipe/stack-symfony.git hackahtonsf

cd hackathonsf
make build
make up
# permet d'ajouter les dépendances node pour le sass
make install
make bash
# vous êtes directement dans le bon dossier
composer install
bin/console doctrine:database:create
bin/console doctrine:migrations:migrate
exit
# permet de créer les fichiers nécessaires au front
make dev
```

http://hackathon.localhost:8000

## Utilisation de Sass

Sass est déjà installé dans ce projet à l'aide de [Webpack Encore](https://symfony.com/doc/6.4/frontend/encore/index.html).

Pour utiliser Sass, il suffit de faire les commandes suivantes :

```shell
# lance la compilation et attend les modifications (à faire dans un terminal à part)
make watch
```

Le fichier assets/styles/app.scss sert de point d'entrée. Les autres fichiers sont à placer dans le même dossier.

## Composant additionnel

### Mercure

Ce composant permet d'envoyer des messages asynchrones à travers un hub pour gérer par exemple un chat, des alertes...

http://localhost:3000

## Ce qui est déjà en place

- entité utilisateur
- enregistrement avec vérification d'email
- connexion avec cookie pour rester connecté
- rubrique d'aide dans le footer
- bootstrap mais vous pouvez, ~~devez~~ vous en passer

## Contraintes techniques

Au moins un des composants additionnels suivants devra être utilisé et justifié :
- Messenger
- Workflow
- Mercure
- FileSystem
- Http-Client
- Translation

## Validation de votre projet

Jeudi 15 février à 11h, vous devrez présenter en 180 secondes maximum votre projet au jury.

## Enjoy et soyez créatif !!!