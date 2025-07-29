#!/bin/bash
# Vérification si PHP n'est pas installé
if  (! command -v php -v &> /dev/null)
then
    echo "php n'est pas installée"
    echo "Veuillez installer PHP avant de lancer ce script"
    exit
else
   
    # Configuration du projet
    echo "1-Saisir le nom de votre projet" 
    read DIRECTORY
    echo "le nom est du projet est : "${DIRECTORY^^}
    echo "2-Saisir le nom de votre base de données"
    read DATABASE
    echo "le nom de la base de données est : "${DATABASE^^}
    echo "3-Saisir le nom de votre utilisateur base de données"
    read USERDB
    echo "le nom de votre utilisateur de base de données est : "${USERDB^^}
    echo "4-Saisir le mot de passe de votre base de données"
    read USERPWD
    echo "le mot de passe de la base de données est : "${USERPWD^^}
    echo "5-Saisir l'hote du serveur (Exemple => localhost)"
    read HOST
    echo "l'hote du serveur de base de données est : "${HOST^^}
    echo "6-Saisir le chemin de votre dossier web (Exemple => c:xampp/htdocs )"
    read ENV
    echo "Le chemin de votre dossier web est : "${ENV^^}
    cd $ENV
    # test si le dossier existe déja
    if [ -d $DIRECTORY ]
    then
        echo "le répertoire existe déja"
    # test sinon on génére le projet
    else
        # Création des répertoires
        mkdir $DIRECTORY
        # Création fichier htaccess
        echo "# Activation du rewrite des URL
        RewriteEngine On
        # base du projet (emplacement à partir de la racine du serveur)
        RewriteBase /$DIRECTORY
        # si ce n'est pas un répertoire
        RewriteCond %{REQUEST_FILENAME} !-d
        # Si ce n'est pas un fichier
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^(.+)$ index.php [QSA,L]">>$DIRECTORY/.htaccess
        # Création du fichier de configuration BDD
        echo "<?php
            const BDD_SERVER = '$HOST';
            const BDD_NAME = '$DATABASE';
            const BDD_LOGIN = '$USERDB';
            const BDD_PASSWORD = '$USERPWD';
            const BASE_URL = '$DIRECTORY';
        ?>">>$DIRECTORY/env.local.php

        # télécharger l'archive
        # Variables
        URL="https://github.com/mithridatem/script_framework_mvc/blob/main/archive.tar.gz"
        FICHIER="archive.tar.gz"

        # Télécharger l'archive dans DEST_DIR
        cd "$DIRECTORY"
        curl -L "$URL" -o "$FICHIER"

        # Extraire au même niveau que l'archive
        tar -xzvf "$FICHIER"

        echo "Archive dézippée avec succés"
        echo "Votre projet a été créé"
        echo "Fin du script"
        cd $DIRECTORY
        # Test si composer est installé
        if  (! command -v composer &> /dev/null)
        then
            # Download de composer
            curl -O https://getcomposer.org/download/latest-stable/composer.phar
            chmod -x composer.phar
            echo "composer installé"
            composer.phar install
        else
            composer install
        fi
        echo "composer install ok"
    fi
fi
