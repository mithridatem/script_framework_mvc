#!/usr/bin/env bash
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
PROFILE="basic"
NAME=""
TARGET_PARENT="."
INSTALL="yes"

usage() {
  cat <<'USAGE'
Usage: bash bin/create-project.sh [--name NOM] [--target DOSSIER] [--no-install]
Génère un projet MVC Basic (router seulement).
Le mode interactif demande le nom si --name est omis.
USAGE
}

while (($#)); do
  case "$1" in
    --name) NAME="${2:?Nom manquant}"; shift 2 ;;
    --target) TARGET_PARENT="${2:?Chemin manquant}"; shift 2 ;;
    --no-install) INSTALL="no"; shift ;;
    -h|--help) usage; exit 0 ;;
    *) echo "Argument inconnu : $1" >&2; usage >&2; exit 2 ;;
  esac
done

if ! command -v php >/dev/null 2>&1; then
  echo "PHP est requis (8.2+)." >&2; exit 1
fi
if [[ -z "$NAME" ]]; then
  read -r -p "Nom du projet (lettres, chiffres, _ ou -) : " NAME
fi
if [[ ! "$NAME" =~ ^[a-zA-Z][a-zA-Z0-9_-]*$ ]]; then
  echo "Nom de projet invalide : $NAME" >&2; exit 2
fi
if [[ ! -d "$TARGET_PARENT" ]]; then
  echo "Répertoire parent introuvable : $TARGET_PARENT" >&2; exit 2
fi

TARGET_PARENT="$(cd "$TARGET_PARENT" && pwd)"
DEST="$TARGET_PARENT/$NAME"
if [[ -e "$DEST" ]]; then
  echo "Destination déjà existante : $DEST" >&2; exit 2
fi

cp -R "$ROOT/templates/$PROFILE" "$DEST"
# Le nom du projet ne contient aucun caractère spécial pour sed.
sed "s/__PROJECT_NAME__/$NAME/g" "$DEST/composer.json" > "$DEST/composer.tmp"
mv "$DEST/composer.tmp" "$DEST/composer.json"
cp "$DEST/.env.example" "$DEST/.env"
echo "Projet créé : $DEST"

if [[ "$INSTALL" == "yes" ]]; then
  if command -v composer >/dev/null 2>&1; then
    (cd "$DEST" && composer install)
  else
    echo "Composer absent : exécuter 'composer install' dans $DEST" >&2
  fi
fi
echo "Démarrage : cd '$DEST' && php -S 127.0.0.1:8000 -t public"
