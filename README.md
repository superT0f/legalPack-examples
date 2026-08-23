# MonKitLégal — Exemples d'intégration API

[![Licence GPL v3](https://img.shields.io/badge/licence-GPLv3-blue.svg)](LICENSE)
[![API](https://img.shields.io/badge/API-v1.1.42-green.svg)](https://conformite.prigent.tech/api/docs)

**MonKitLégal** génère les pages légales obligatoires des sites web français
(mentions légales, politique de confidentialité RGPD, CGU, CGV, bandeau
cookies) — scan gratuit, kit complet à 9 €, sans abonnement.

Ce repo rassemble des **exemples de code prêts à copier** pour consommer
l'API publique, avec une **clé de démonstration** qui renvoie un vrai jeu de
données fictif (« Boulangerie Maison Dupont ») — aucun compte requis.

👉 Nos offres commerciales : [PROMOTION.md](PROMOTION.md)

## Démarrage en 30 secondes

Clé de démonstration (publique, lecture seule, données fictives) :

```
deadbeefdeadbeefdeadbeefdeadbeef
```

```bash
curl -H "Authorization: Bearer deadbeefdeadbeefdeadbeefdeadbeef" \
  https://conformite.prigent.tech/api/v1/documents
```

Essayez aussi dans votre navigateur, sans clé ni code :
[pages légales hébergées de la démo](https://conformite.prigent.tech/api/client-deadbeefdeadbeefdeadbeefdeadbeef/)
— rendues en direct par notre moteur.

## L'API en bref

Base URL : `https://conformite.prigent.tech` — doc interactive :
[/api/docs](https://conformite.prigent.tech/api/docs) (OpenAPI 3).

| Endpoint | Description |
|---|---|
| `GET /api/v1/me` | Infos de la commande (email masqué, version du kit, URL des pages hébergées) |
| `GET /api/v1/documents` | Liste des documents du kit + URLs par format |
| `GET /api/v1/documents/<type>` | Document en JSON : données structurées + HTML complet |
| `GET /api/v1/documents/<type>.md` | Document en Markdown brut |

Types : `mentions-legales`, `confidentialite`, `cgu`, `cgv` (CGV si vente en
ligne détectée).

Authentification : header `Authorization: Bearer <clé>` ou `X-API-Key: <clé>`.
La clé est délivrée à l'achat du LegalPack (9 €) — c'est aussi l'identifiant
des pages hébergées du client. Codes d'erreur : `401` (clé absente/invalide),
`403` (commande non payée), `409` (documents en préparation).

Chaque document est aussi servi en **page hébergée** HTML + PDF à la volée :
`GET /api/client-<clé>/<type>` et `…/<type>.pdf` — aucune clé requise, lien
à donner à vos visiteurs.

## Exemples

| Fichier | Langage | Ce qu'il fait |
|---|---|---|
| [examples/curl.sh](examples/curl.sh) | Bash/curl | Les 4 endpoints, un par un |
| [examples/javascript.js](examples/javascript.js) | JS (fetch) | Liste les documents, injecte le HTML des mentions légales dans une page |
| [examples/php.php](examples/php.php) | PHP (cURL) | Récupère les 4 documents et les écrit en `.html` |
| [examples/python.py](examples/python.py) | Python (stdlib) | Télécharge les documents en Markdown |

Aucune dépendance externe : chaque exemple n'utilise que la bibliothèque
standard ou des outils déjà présents.

## Pour aller plus loin

- **WordPress** : notre plugin officiel synchronise vos pages légales
  automatiquement (dossier `kits/wordpress-monkitlegal/` du dépôt principal).
- **Scan gratuit** : testez la conformité de votre site sur
  [conformite.prigent.tech](https://conformite.prigent.tech) — 30 secondes,
  sans email.

## Licence

Code de ces exemples : [GPL v3](LICENSE). Les documents générés via l'API
appartiennent au client qui les a achetés.
