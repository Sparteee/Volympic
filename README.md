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

Volympic a choisi les bénévoles !

**Et tout ça en moins de 30h !**

## Objectifs

L'objectif principal de Volympic est de faciliter la gestion et la communication des bénévoles impliqués dans les Jeux Olympiques de Paris 2024. Cette application révolutionnaire offre aux bénévoles la possibilité de sélectionner les tâches qui correspondent à leurs intérêts et compétences, simplifiant ainsi le processus d'inscription.

Dès qu'un bénévole s'engage pour une tâche spécifique, il est automatiquement intégré dans une conversation avec les autres bénévoles affectés à la même mission. Cette fonctionnalité favorise la collaboration et permet aux bénévoles de coordonner leurs efforts de manière efficace et harmonieuse.

En outre, Volympic offre à ses utilisateurs un accès privilégié à une carte interactive qui répertorie les restaurants affiliés à proximité de leur lieu de mission. Cette fonctionnalité pratique garantit aux bénévoles un accès facile à des options de restauration de qualité, optimisant ainsi leur expérience globale pendant les Jeux Olympiques.

Grâce à Volympic, l'expérience des bénévoles aux Jeux Olympiques de Paris 2024 est non seulement simplifiée, mais aussi enrichie par des outils de communication et des services pratiques, contribuant ainsi au succès global de l'événement.


## Technologies utilisés : 
   - Symfony
   - Twig
   - SCSS/SASS
   - Docker
   - [Mercure](https://symfony.com/components/Mercure)
   - [LeafletJS](https://leafletjs.com/)

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

## Auteurs

 - [Johan MORGA](https://github.com/JohanMorga) - Développement
 - [Sean REYBOZ](https://github.com/SeanReyboz/) - Développement
 - [Raphaël VICTOR](https://github.com/Sparteee) - Développement
 - Arthur JARRIAU - Développement - Chef de projet
 - Bastien Joly - Développement
 - Margot BODIER - Design - Communication
 - [Valentin TOUZINAUD](https://github.com/ValentinTouzinaud) - Design - Communication
 - William Camilleri - Design - Communication
