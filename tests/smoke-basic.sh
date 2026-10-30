#!/usr/bin/env bash
set -euo pipefail
ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
TMP="$(mktemp -d)"
trap 'rm -rf "$TMP"' EXIT
bash "$ROOT/bin/create-project.sh" --name DemoMvc --target "$TMP" --no-install
test -f "$TMP/DemoMvc/public/index.php"
test -f "$TMP/DemoMvc/src/Controller/HomeController.php"
test -f "$TMP/DemoMvc/.env"
test ! -e "$TMP/DemoMvc/vendor"
php -l "$TMP/DemoMvc/public/index.php"
php -l "$TMP/DemoMvc/src/Controller/AbstractController.php"
php -l "$TMP/DemoMvc/src/Controller/HomeController.php"
php -r 'json_decode(file_get_contents($argv[1]), true, 512, JSON_THROW_ON_ERROR);' "$TMP/DemoMvc/composer.json"
echo 'Basic scaffold : OK'
