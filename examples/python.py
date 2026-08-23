#!/usr/bin/env python3
"""MonKitLégal API v1 — exemple Python (bibliothèque standard uniquement).

Télécharge les documents du kit en Markdown dans le dossier courant.
La clé ci-dessous est la clé de démonstration publique (données fictives).
"""

import json
import urllib.request
import urllib.error

API = 'https://conformite.prigent.tech/api/v1'
KEY = 'deadbeefdeadbeefdeadbeefdeadbeef'  # clé de démo


def api_get(path: str) -> dict:
    req = urllib.request.Request(
        API + path,
        headers={'Authorization': f'Bearer {KEY}'},
    )
    with urllib.request.urlopen(req, timeout=30) as res:
        body = json.loads(res.read().decode('utf-8'))
    if not body.get('success'):
        raise RuntimeError(f"{body.get('error')}: {body.get('message')}")
    return body['data']


def main() -> None:
    me = api_get('/me')
    print(f"Commande démo — site : {me['site_url']} (kit v{me['pack_version']})")

    for doc in api_get('/documents')['documents']:
        req = urllib.request.Request(
            f"{API}/documents/{doc['type']}.md",
            headers={'X-API-Key': KEY},
        )
        try:
            with urllib.request.urlopen(req, timeout=30) as res:
                markdown = res.read().decode('utf-8')
        except urllib.error.HTTPError as e:
            print(f"⏭️  {doc['type']} : HTTP {e.code}")
            continue
        filename = f"{doc['type']}.md"
        with open(filename, 'w', encoding='utf-8') as f:
            f.write(markdown)
        print(f"✅ {doc['title']} → {filename} ({len(markdown)} caractères)")


if __name__ == '__main__':
    main()
