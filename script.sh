#!/usr/bin/env bash
set -euo pipefail
# Compatibilité avec l'ancienne commande : bash script.sh
ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
exec bash "$ROOT/bin/create-project.sh" "$@"
