#!/usr/bin/env bash
# MonKitLégal API v1 — les 4 endpoints en curl (clé de démo publique).
set -euo pipefail

API="https://conformite.prigent.tech/api/v1"
KEY="deadbeefdeadbeefdeadbeefdeadbeef"   # clé de démo — remplacez par la vôtre

echo "== 1. Infos commande =="
curl -s -H "Authorization: Bearer $KEY" "$API/me" | python3 -m json.tool

echo "== 2. Liste des documents du kit =="
curl -s -H "Authorization: Bearer $KEY" "$API/documents" | python3 -m json.tool

echo "== 3. Mentions légales en JSON (données structurées + HTML) =="
curl -s -H "Authorization: Bearer $KEY" "$API/documents/mentions-legales" \
  | python3 -c 'import json,sys; d=json.load(sys.stdin)["data"]; print("titre :", d["title"]); print("éditeur:", d["data"]["editor"]["name"]); print("html :", len(d["html"]), "caractères")'

echo "== 4. Politique de confidentialité en Markdown =="
curl -s -H "X-API-Key: $KEY" "$API/documents/confidentialite.md" | head -20

echo "Bonus — page hébergée (sans clé) : https://conformite.prigent.tech/api/client-$KEY/"
