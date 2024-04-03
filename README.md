# Volympic - Hackathon Symfony - LP MIAW

## Contexte
Le **thème** de cette année 2024 est : **les jeux olympiques !**

![JO Paris 2024](images/LogoJOParis2024.svg)

L'équipe devait déveloper une application utile pour au moins une de ces catégories :
- les athlètes 
- les organisateurs
- les visiteurs
- les fédérations
- une épreuve
- ...

**Et tout ça en moins de 30h !**

## Installation
- Pré-requis :
   - Avoir Docker
   - WSL si vous êtes sur Windows

```shell
git clone git@github.com:Sparteee/Volympic.git volympic

cd volympic
make build
make up
# permet d'ajouter les dépendances php et node pour le sass
# équivalent à composer install et npm install
make install
make bash
# vous êtes directement dans le bon dossier
bin/console doctrine:database:create
bin/console doctrine:migrations:migrate
exit
# permet de créer les fichiers nécessaires au front
make dev
```
## Utilisation de Sass

Sass est déjà installé dans ce projet à l'aide de [Webpack Encore](https://symfony.com/doc/6.4/frontend/encore/index.html).

Pour utiliser Sass, il suffit de faire la commande suivante pour compiler les assets :

```shell
# lance la compilation et attend les modifications (à faire dans un terminal à part)
make watch
```

Le fichier assets/styles/app.scss sert de point d'entrée. Les autres fichiers sont à placer dans le même dossier.

## Composant additionnel présent dans le compose.yaml

### Mercure

Ce composant permet d'envoyer des messages asynchrones à travers un hub pour gérer par exemple un chat, des alertes...

http://localhost:3000

## Auteurs

 - [Johan MORGA](https://github.com/JohanMorga) - Développement
 - [Sean REYBOZ](https://github.com/SeanReyboz/) - Développement
 - [Raphaël VICTOR](https://github.com/Sparteee) - Développement
 - Arthur JARRIAU - Développement
 - Bastien Joly - Développement
 - Margot BODIER - Design - Communication
 - [Valentin TOUZINAUD](https://github.com/ValentinTouzinaud) - Design - Communication
 - William Camilleri - Design - Communication
