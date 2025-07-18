# Documentation du Projet `dashboard_point`

## Introduction

**`dashboard_point`** est une application PHP de tableau de bord destinée à la gestion des visites, du personnel et des formations d'un centre. Elle communique avec une API Cockpit pour centraliser et manipuler les données des visiteurs, du staff, des historiques de passage et des formations.

## Sommaire

- [Introduction](#introduction)
- [Fonctionnalités principales](#fonctionnalit%C3%A9s-principales)
- [Structure des fichiers](#structure-des-fichiers)
- [Installation et Lancement](#installation-et-lancement)
- [Connexion à l’API](#connexion-%C3%A0-lapi)
- [Collections API](#collections-api)
- [Utilisation des Modules](#utilisation-des-modules)
- [Exemples de Requêtes API](#exemples-de-requ%C3%AAtes-api)
- [Accès \& Déploiement](#acc%C3%A8s--d%C3%A9ploiement)
- [Débogage](#d%C3%A9bogage)
- [Notes sur les données et la compatibilité](#notes-sur-les-donn%C3%A9es-et-la-compatibilit%C3%A9)


## Fonctionnalités principales

- **Visualisation des visiteurs du jour**
- **Ajout / Modification d'entrées via formulaire**
- **Connexion sécurisée avec gestion de session**
- **Suppression de données (protection par clé API)**
- **Recherche d’entrées par date**
- **Gestion du staff (CRUD)**
- **Gestion des formations proposées**
- **Compatibilité API Cockpit : Récupération, ajout, modification et suppression des données**


## Structure des fichiers

| Fichier / Dossier | Description principale |
| :-- | :-- |
| `index.php` | Page principale du dashboard (affiche les visiteurs du jour) |
| `add.php` | Ajout de données selon la collection (sert aussi à l’édition/modification) |
| `login` | Page d’accueil si aucune session ouverte |
| `remove` | Suppression d’entrées via l’API (*API key nécessaire*) |
| `search` | Formulaire de recherche pour trouver des visites par date |
| `staff` | Liste des membres du personnel, édition et suppression |
| `formation` | Liste des formations disponibles |

## Installation et Lancement

1. **Prérequis**
    - Serveur PHP (7.4+ recommandé)
    - Accès internet pour communiquer avec l’API Cockpit
2. **Clonage du projet**

```bash
git clone https://github.com/James-byds/dashboard_point.git
cd dashboard_point
```

3. **Configuration**
    - Adapter le(s) fichier(s) de configuration pour inclure l’URL de l’API et la clé associée si nécessaire.
4. **Démarrer le serveur local**

```bash
php -S localhost:8000
```

Puis accéder à `http://localhost:8000/` dans votre navigateur.

## Connexion à l’API

- **API Cockpit** : [https://ingrwf12.cepegra-frontend.xyz/cockpit_james/api](#)
- **Authentification**
    - Utilisation d’une clé API envoyée dans l’en-tête de chaque requête (`api-key`).
    - Un `api-token` peut également être utilisé selon la configuration.
- **Endpoints principaux**
    - `GET /content/items/{model}` : Liste des éléments d’une collection
    - `POST /content/item/{model}` : Création ou mise à jour d’un élément
    - `GET /content/item/{model}` : Récupération d’un élément unique
    - `DELETE /content/item/{model}/{id}` : Suppression d’un élément


## Collections API

Les collections principales utilisées sont :

- `entries` — historiques de visite (logs de passages)
- `staff` — membres du personnel
- `formations` — formations disponibles
- `users` — visiteurs déjà venus au centre


## Utilisation des Modules

| Module | Objectif | Accès Requis |
| :-- | :-- | :-- |
| index.php | Tableau de bord quotidien | Public/Sécurisé |
| add.php | Ajout ou modification de données | Sécurisé |
| login | Page de connexion | Public |
| remove | Suppression (nécessite une clé API) | Sécurisé |
| search | Recherche de visites par date | Sécurisé |
| staff | Gestion des membres du staff | Sécurisé |
| formation | Liste des formations | Sécurisé |

## Exemples de Requêtes API

- **Lister toutes les entrées d’une collection**

```
GET /api/content/items/[nom_collection]
(Exemple: /api/content/items/entries)
```

- **Récupérer un élément précis par ID**

```
GET /api/content/item/[nom_collection]/[id]
```

- **Ajout ou modification**

```
POST /api/content/item/[nom_collection]
Body : { ... }
Headers : { "api-key": "VOTRE_API_KEY" }
```

- **Suppression**

```
DELETE /api/content/item/[nom_collection]/[id]
Headers : { "api-key": "VOTRE_API_KEY" }
```


## Accès \& Déploiement

- **Frontend** : [https://jbappoint.netlify.app](#)
- **CMS** : [https://ingrwf12.cepegra-frontend.xyz/james_cms](#)
- **API** : [https://ingrwf12.cepegra-frontend.xyz/cockpit_james](#)
- **Dépôt GitHub**
    - Frontend : [https://github.com/James-byds/frontapp_presence](#)
    - CMS : [https://github.com/James-byds/dashboard_point](#)


## Débogage

- Vous pouvez utiliser la fonction `display()` (définie dans `functions.php`) pour debuguer rapidement (`print_r`), si la constante `DEBUG` est à `true`.


## Notes sur les données et la compatibilité

- **Anciennes données ("OLD DATA")**
    - Certains anciens jeux de données peuvent provoquer des erreurs d’affichage à cause de changements de structure de la base/API.
    - Vérifiez la compatibilité des entrées et nettoyez la base si besoin.


## Remarques complémentaires

- Toutes les requêtes API qui modifient les données nécessitent une clé API.
- L’accès invité n’a qu’un droit de lecture (GET) et création (POST) limité.
- Le système supporte la recherche avancée, la gestion multi-utilisateur et la gestion du personnel.
