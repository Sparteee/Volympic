# Inclus le fichier .env permettant de définir des préférences générales
include .env
export

# Définit le shell par défaut pour les différents systèmes
SHELL = /bin/sh

# Récupère le numéro d'utilisateur système pour l'utilisateur courant : ex : 1000 pour linux, 501 pour macos
CURRENT_UID := $(shell id -u)
export CURRENT_UID

# Fonctions ayant besoins de paramètres, permet de les gérer, de les formater et de les utiliser
SUPPORTED_COMMANDS := newSF newWP newPHP remove dump rename dumpInsert newClone add
SUPPORTS_MAKE_ARGS := $(findstring $(firstword $(MAKECMDGOALS)), $(SUPPORTED_COMMANDS))
ifneq "$(SUPPORTS_MAKE_ARGS)" ""
  NOM := $(wordlist 2,2,$(MAKECMDGOALS))
  NOM2 := $(wordlist 3,3,$(MAKECMDGOALS))
  $(eval $(NOM):;@:)
  NOM2 := $(subst :,\:,$(NOM2))
  $(eval $(NOM2):;@:)
endif

# Permet de définir la comande de docker-compose avec le bon utilisateur et la bonne version de php
DK := USERID=$(CURRENT_UID) PHPVersion=$(PHP) $(DKC)

# Récupère la date
CURRENT_TIME := $(shell date "+%Y%m%d%H%M")

# .Phony permet de considérer les entrées suivantes comme des commandes et non des fichiers
.PHONY: add rename build preNew postNew newSF newPHP newWP up down cleanAll help removeSF removePHP removeWP check_clean bash dump list updatePhp dumpInsert newClone env restart watch dev build

# Si on tape just make, cela revient à make help
.DEFAULT_GOAL := help

watch: ## Fait un npm run watch dans l'application symfony
	@$(DK) run --rm nodejs run watch

dev: ## Fait un npm run dev dans l'application symfony
	@$(DK) run --rm nodejs run dev

install: ## Fait un composer install puis un npm install dans l'application symfony
	@$(DK) exec php composer install
	@$(DK) run --rm nodejs install

add: ## ajoute un composant node au projet : ex : make add axios <==> npm install axios --save
ifdef NOM
	echo $(NOM)
	@$(DK) run --rm nodejs install $(NOM) --save
endif


build: ## Construit les conteneurs comme docker-compose build
	@$(DK) build

restart: down up ## Redémarre les serveurs (down puis up)

up: ## Démarre les serveurs
	@$(DK) up -d

down: ## Arrête les serveurs
	@$(DK) down

cleanAll: check_clean ## Donne les commandes pour tout supprimer
	@echo "Attention, action irréversible !!!"
	@echo "Faites make down puis lancer la commande suivante éventuellement avec sudo"
	@echo "docker system prune --volumes -a"

# utilisation de mysqldump pour générer le code sql dans le conteneur db
dump: ## Sauvegarde la base associée au projet : make dump hackathon
ifdef NOM
	@make up
	@$(DK) exec db mysqldump -p$(MYSQL_PASSWORD) $(NOM) > $(NOM)-$(CURRENT_TIME).sql
	@echo "Sauvegarde de la BD du projet $(NOM) réalisée dans le fichier $(NOM)-$(CURRENT_TIME).sql"
else 
	@echo "il faut ajouter le nom du projet à la commande"
endif

dumpInsert: ## Sauvegarde que les données la base associée au projet : make dumpInsert hackathon
ifdef NOM
	@make up
	@$(DK) exec db mysqldump --no-create-info --complete-insert --skip-lock-tables --single-transaction -p$(MYSQL_PASSWORD) $(NOM) > $(NOM)-$(CURRENT_TIME)Insert.sql
	@echo "Sauvegarde de la BD du projet $(NOM) réalisée dans le fichier $(NOM)-$(CURRENT_TIME)Insert.sql"
else 
	@echo "il faut ajouter le nom du projet à la commande"
endif

bash: ## Entre en bash dans le conteneur php
	@$(DK) exec php bash

updatePhp: ## Mets à jour composer et le binaire symfony dans le conteneur php
	@make down
	@$(DK) build --no-cache php
	@make up

# permet d'avoir la confirmation de l'utilisateur
check_clean:
	@( read -p "Êtes vous sûr ? Vous allez tout supprimer [o/N]: " sure && case "$$sure" in [oO]) true;; *) false;; esac )

help: ## Affiche cette aide
	@grep --no-filename -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
