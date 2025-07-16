# FILES
## list
index.php -> default page of the dashboard shows the current visitors of the day

add.php -> add data depending on collection sent, also serves as the update form if data is sent(autopopulate form)

login -> default page if no session has been started

remove -> Suppressing data from api !!!!NEED KEY

search -> Search form to find visits from a certain date

staff -> List of staff members with buttons to edit and remove 

formation -> List of available formations

## OLD DATA

OLD GENERATED DATA MAY CAUSE ERRORS AND DISPLAY INNACURACIES DUE TO DATA FORMAT CHANGES IN THE API (notable users and staff members)

For debugging purposes, you can use the display() function initiated in functions.php (it's a basic print_r)
-> if DEBUG is set to false, it won't show up

## URL des projets déployés

front : https://jbappoint.netlify.app
CMS : https://ingrwf12.cepegra-frontend.xyz/james_cms
API : https://ingrwf12.cepegra-frontend.xyz/cockpit_james

## GIT REPO

front : https://github.com/James-byds/frontapp_presence
CMS : https://github.com/James-byds/dashboard_point

## Collections de l'API

entries -> historiques de visite
staff -> membres du personnel
formations -> Formations disponibles
users -> visiteurs du centre au moins déjà venus une fois


- méthode d'accés à plusieures entrées
- [api_link] + /api/content/items/ + [nom_collection]

- Alternative pour un seul item
- [api_link] + /api/content/items/ + [nom_collection] / [id]

méthodes possibles pour invité : POST et GET (détail ci dessous)


## API

- API LIVE LINK: https://ingrwf12.cepegra-frontend.xyz/cockpit_james
- basic dev profile: 
username: Pierre 
pswd: pass

public access to api reserved to read only

Documentation API Cockpit

Cette documentation décrit les points d'accès (endpoints) et les tables disponibles via l'API Cockpit, basés sur les informations fournies.

Serveur API

L'adresse de base de l'API est https://ingrwf12.cepegra-frontend.xyz/cockpit_james/api.

Authentification

L'authentification se fait via une clé API (api-key) qui doit être envoyée dans l'en-tête de la requête. Un api-token est également mentionné.

Modules et Endpoints

Module content

Ce module gère le contenu et les éléments de modèle.

GET /content/item/{model}

Récupère un élément de modèle.

•
Paramètres de chemin:

•
model (string, requis): Nom du modèle.



•
Paramètres de requête:

•
locale (string): Locale pour le contenu.

•
filter (string): JSON de filtre encodé en URL.

•
fields (string): Projection de champs encodée en URL sous forme de JSON.

•
populate (integer): Populer l'élément avec les éléments de contenu liés.



•
Réponse: Élément de modèle.

POST /content/item/{model}

Crée ou met à jour un élément de modèle.

•
Paramètres de chemin:

•
model (string, requis): Nom du modèle.



•
Corps de la requête:

•
data (application/json, requis): Données de l'élément de contenu.



•
Réponse: Élément de modèle sauvegardé.

GET /content/item/{model}/{id}

Récupère un élément de contenu spécifique par ID.

•
Paramètres de chemin:

•
model (string, requis): Nom du modèle.

•
id (string, requis): ID de l'élément de contenu.



•
Paramètres de requête:

•
locale (string): Locale pour le contenu.

•
fields (string): Projection de champs encodée en URL sous forme de JSON.

•
populate (integer): Populer l'élément avec les éléments de contenu liés.



•
Réponse: Élément de contenu.

DELETE /content/item/{model}/{id}

Supprime un élément de contenu spécifique par ID.

•
Paramètres de chemin:

•
model (string, requis): Nom du modèle.

•
id (string, requis): ID de l'élément de contenu.



•
Réponse: Élément de contenu supprimé.

GET /content/items/{model}

Récupère une liste d'éléments de modèle publiés.

•
Paramètres de chemin:

•
model (string, requis): Nom du modèle.



•
Paramètres de requête:

•
locale (string): Locale pour le contenu.

•
filter (string): JSON de filtre encodé en URL.

•
sort (string): JSON de tri encodé en URL.

•
fields (string): Projection de champs encodée en URL sous forme de JSON.

•
limit (integer): Nombre maximal d'éléments à retourner.

•
skip (integer): Nombre d'éléments à ignorer.

•
populate (integer): Populer les éléments avec les éléments de contenu liés.



•
Réponse: Liste d'éléments de modèle publiés.

GET /content/items

Récupère une liste d'éléments de modèle publiés pour plusieurs modèles.

•
Paramètres de requête:

•
models (string): Requête de modèles sous forme de JSON ({model1:{filter:{...}}, model2:{...}}).

•
locale (string): Locale pour le contenu.

•
populate (integer): Populer les éléments avec les éléments de contenu liés.



•
Réponse: Liste d'éléments de modèle publiés.

GET /content/aggregate/{model}

Récupère une liste d'éléments de modèle agrégés et publiés.

•
Paramètres de chemin:

•
model (string, requis): Nom du modèle.



•
Paramètres de requête:

•
pipeline (string, requis): JSON de pipeline encodé en URL.

•
locale (string): Locale pour le contenu.

•
populate (integer): Populer les éléments avec les éléments de contenu liés.



•
Réponse: Liste d'éléments de modèle agrégés et publiés.

GET /content/tree/{model}

Récupère une arborescence d'éléments.

•
Paramètres de chemin:

•
model (string, requis): Nom du modèle.



•
Paramètres de requête:

•
locale (string): Locale pour le contenu.

•
fields (string): Projection de champs encodée en URL sous forme de JSON.

•
populate (integer): Populer les éléments avec les éléments de contenu liés.



•
Réponse: Arborescence d'éléments.

Module system

Ce module fournit des informations sur l'état du système.

GET /system/healthcheck

Effectue une vérification de l'état du système.

•
Paramètres de requête:

•
checks (string): Liste de vérifications à effectuer, séparées par des virgules (par défaut : db, memory, fs, redis, smtp, custom).



•
Réponse: État du système (code 200).


