# Documentation de l'API Gestion Immobilière

## Table des matières
- [Authentification](#authentification)
- [Gestion des Utilisateurs](#gestion-des-utilisateurs-admin-uniquement)
- [Gestion des Propriétaires](#gestion-des-propriétaires-admin-et-agent)
- [Gestion des Biens Immobiliers](#gestion-des-biens-immobiliers)
- [Gestion des Réservations](#gestion-des-réservations)
- [Gestion des Contrats](#gestion-des-contrats-admin-et-agent)
- [Gestion des Photos](#gestion-des-photos-admin-et-agent)
- [Notifications](#notifications)
- [Messages](#messages)

## Authentification

### Inscription
```http
POST /api/register
```
**Corps de la requête :**
```json
{
    "name": "string",
    "email": "string",
    "password": "string",
    "password_confirmation": "string",
    "role": "client" // Par défaut
}
```

### Connexion
```http
POST /api/login
```
**Corps de la requête :**
```json
{
    "email": "string",
    "password": "string"
}
```

### Déconnexion
```http
POST /api/logout
```
**Authentification requise :** Token Bearer

## Gestion des Utilisateurs (Admin uniquement)

### Liste des utilisateurs
```http
GET /api/users
```
**Authentification requise :** Token Bearer + Rôle Admin

### Recherche d'utilisateurs
```http
GET /api/users/search?query=string
```
**Authentification requise :** Token Bearer + Rôle Admin

### Détails d'un utilisateur
```http
GET /api/users/{id}
```
**Authentification requise :** Token Bearer + Rôle Admin

### Créer un utilisateur
```http
POST /api/users
```
**Authentification requise :** Token Bearer + Rôle Admin
**Corps de la requête :**
```json
{
    "name": "string",
    "email": "string",
    "password": "string",
    "role": "admin|agent|client",
    "phone": "string"
}
```

### Modifier un utilisateur
```http
PUT /api/users/{id}
```
**Authentification requise :** Token Bearer + Rôle Admin

### Supprimer un utilisateur
```http
DELETE /api/users/{id}
```
**Authentification requise :** Token Bearer + Rôle Admin

## Gestion des Propriétaires (Admin et Agent)

### Liste des propriétaires
```http
GET /api/proprietaires
```
**Authentification requise :** Token Bearer + Rôle Admin/Agent

### Recherche de propriétaires
```http
GET /api/proprietaires/search?query=string
```
**Authentification requise :** Token Bearer + Rôle Admin/Agent

### Détails d'un propriétaire
```http
GET /api/proprietaires/{id}
```
**Authentification requise :** Token Bearer + Rôle Admin/Agent

### Créer un propriétaire
```http
POST /api/proprietaires
```
**Authentification requise :** Token Bearer + Rôle Admin/Agent
**Corps de la requête :**
```json
{
    "nom": "string",
    "prenom": "string",
    "email": "string",
    "telephone": "string",
    "adresse": "string"
}
```

### Modifier un propriétaire
```http
PUT /api/proprietaires/{id}
```
**Authentification requise :** Token Bearer + Rôle Admin/Agent

### Supprimer un propriétaire
```http
DELETE /api/proprietaires/{id}
```
**Authentification requise :** Token Bearer + Rôle Admin/Agent

## Gestion des Biens Immobiliers

### Liste des biens (Public)
```http
GET /api/biens
```
**Authentification requise :** Token Bearer

### Recherche de biens
```http
GET /api/biens/search?query=string
```
**Authentification requise :** Token Bearer + Rôle Admin/Agent

### Détails d'un bien (Public)
```http
GET /api/biens/{id}
```
**Authentification requise :** Token Bearer

### Créer un bien
```http
POST /api/biens
```
**Authentification requise :** Token Bearer + Rôle Admin/Agent
**Corps de la requête :**
```json
{
    "titre": "string",
    "description": "string",
    "prix": "number",
    "surface": "number",
    "adresse": "string",
    "statut": "disponible|vendu|loue",
    "proprietaire_id": "number",
    "ville_id": "number",
    "type_bien_id": "number"
}
```

### Modifier un bien
```http
PUT /api/biens/{id}
```
**Authentification requise :** Token Bearer + Rôle Admin/Agent

### Supprimer un bien
```http
DELETE /api/biens/{id}
```
**Authentification requise :** Token Bearer + Rôle Admin/Agent

## Gestion des Réservations

### Liste des réservations (Admin/Agent)
```http
GET /api/reservations
```
**Authentification requise :** Token Bearer + Rôle Admin/Agent

### Recherche de réservations
```http
GET /api/reservations/search?query=string
```
**Authentification requise :** Token Bearer + Rôle Admin/Agent

### Créer une réservation (Client)
```http
POST /api/reservations
```
**Authentification requise :** Token Bearer + Rôle Client
**Corps de la requête :**
```json
{
    "date_visite": "datetime",
    "bien_id": "number"
}
```

### Modifier une réservation
```http
PUT /api/reservations/{id}
```
**Authentification requise :** Token Bearer + Rôle Admin/Agent

### Supprimer une réservation
```http
DELETE /api/reservations/{id}
```
**Authentification requise :** Token Bearer + Rôle Admin/Agent

## Gestion des Contrats (Admin et Agent)

### Liste des contrats
```http
GET /api/contrats
```
**Authentification requise :** Token Bearer + Rôle Admin/Agent

### Détails d'un contrat
```http
GET /api/contrats/{id}
```
**Authentification requise :** Token Bearer + Rôle Admin/Agent

### Créer un contrat
```http
POST /api/contrats
```
**Authentification requise :** Token Bearer + Rôle Admin/Agent
**Corps de la requête :**
```json
{
    "date_debut": "date",
    "date_fin": "date|null",
    "montant": "number",
    "type": "location|vente",
    "client_id": "number",
    "bien_id": "number"
}
```

### Modifier un contrat
```http
PUT /api/contrats/{id}
```
**Authentification requise :** Token Bearer + Rôle Admin/Agent

### Supprimer un contrat
```http
DELETE /api/contrats/{id}
```
**Authentification requise :** Token Bearer + Rôle Admin/Agent

## Gestion des Photos (Admin et Agent)

### Ajouter une photo
```http
POST /api/photos
```
**Authentification requise :** Token Bearer + Rôle Admin/Agent
**Corps de la requête :** `multipart/form-data`
```
photo: File
bien_id: number
```

### Supprimer une photo
```http
DELETE /api/photos/{id}
```
**Authentification requise :** Token Bearer + Rôle Admin/Agent

## Notifications

### Liste des notifications
```http
GET /api/notifications
```
**Authentification requise :** Token Bearer

### Marquer une notification comme lue
```http
PUT /api/notifications/{id}/read
```
**Authentification requise :** Token Bearer

## Messages

### Liste des messages
```http
GET /api/messages
```
**Authentification requise :** Token Bearer

### Envoyer un message
```http
POST /api/messages
```
**Authentification requise :** Token Bearer
**Corps de la requête :**
```json
{
    "contenu": "string",
    "destinataire_id": "number"
}
```

### Supprimer un message
```http
DELETE /api/messages/{id}
```
**Authentification requise :** Token Bearer

## Notes importantes

1. Tous les endpoints nécessitent un token Bearer d'authentification obtenu lors de la connexion.
2. Les rôles déterminent l'accès aux différentes fonctionnalités :
   - Admin : accès complet
   - Agent : accès à la gestion des biens, propriétaires, réservations et contrats
   - Client : accès limité (consultation des biens et création de réservations)
3. Les réponses sont au format JSON et incluent généralement :
   - Code 200 : Succès
   - Code 201 : Création réussie
   - Code 400 : Erreur de requête
   - Code 401 : Non authentifié
   - Code 403 : Non autorisé
   - Code 404 : Ressource non trouvée
   - Code 422 : Erreur de validation
   - Code 500 : Erreur serveur

## Exemples d'utilisation

### Authentification et obtention du token
```bash
curl -X POST http://votre-domaine.com/api/login \
  -H "Content-Type: application/json" \
  -d '{"email": "user@example.com", "password": "password"}'
```

### Créer un bien immobilier
```bash
curl -X POST http://votre-domaine.com/api/biens \
  -H "Authorization: Bearer votre_token" \
  -H "Content-Type: application/json" \
  -d '{
    "titre": "Appartement moderne",
    "description": "Bel appartement rénové",
    "prix": 250000,
    "surface": 75,
    "adresse": "123 rue Example",
    "statut": "disponible",
    "proprietaire_id": 1,
    "ville_id": 1,
    "type_bien_id": 1
  }'
```

### Rechercher des biens
```bash
curl -X GET "http://votre-domaine.com/api/biens/search?query=appartement" \
  -H "Authorization: Bearer votre_token"
``` 