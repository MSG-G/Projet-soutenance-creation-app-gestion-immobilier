# Projet-soutenance-creation-app-gestion-immobilier
# 🏘️ Dev-Immo - Application Web de Gestion Immobilière

Dev-Immo est une application web moderne développée avec Laravel et Postgres, permettant la gestion des biens immobiliers, des utilisateurs (clients, agents, administrateurs), des réservations, des transactions (vente/location) et des contrats. Elle offre également un système de messagerie interne et un tableau de bord statistique.

---

## 📋 Fonctionnalités

### 🔐 Gestion des utilisateurs

* Inscription et connexion sécurisée (breeze)
* Attribution de rôles : client, agent, administrateur
* Modification des informations utilisateur
* Tableau de bord personnalisé selon le rôle

### 🏡 Gestion des biens immobiliers

* Création et modification de biens (vente ou location)
* Ajout de description, images, prix, localisation, type
* Consultation et recherche de biens avec filtres
* Historique et statut du bien (disponible, réservé, vendu, loué)

### 📅 Réservations & Rendez-vous

* Planification de visites par les clients
* Confirmation, annulation ou reprogrammation par les agents

### 📄 Transactions et contrats

* Enregistrement des ventes ou locations
* Suivi du statut des transactions (en cours, terminée)
* Génération automatique de contrats PDF

### 💬 Messagerie interne

* Envoi de messages entre clients et agents
* Notification en temps réel

### 📊 Statistiques

* Nombre de biens en ligne, vendus ou loués
* Activité des agents
* Revenus générés par type de transaction

---

## 🔧 Prérequis

* PHP >= 8.1
* Composer 2.x
* Laravel 10 ou supérieur
* PostgresSql
* Node.js + npm
---

## 📁 Structure du projet Laravel

```plaintext
app/Models         → Modèles Eloquent (User, Property, Appointment...)
app/Http/Controllers → Logique métier (API et Web)
database/migrations → Création des tables
routes/api.php      → Endpoints REST
```

---

## 🛠️ Technologies Utilisées

* **Laravel** : Framework PHP MVC moderne
* **Postgres** : Base de données relationnelle
* **breeze** : Authentification Laravel
* **Postman** : Tests API
* **Html/Css/js/react** : Mise en page responsive
* **Git & GitHub** : Versionnage et collaboration

---

## 📱 Interfaces prévues

* Page d’accueil publique avec moteur de recherche
* Tableau de bord Admin
* Espace Agent (gestion de ses biens et visites)
* Espace Client (réservation, consultation contrat)
* Système de messagerie intégré (optionnel)

---

## 📝 Contribution

1. Cloner le dépôt
2. Créer une branche pour votre fonctionnalité

```bash
git checkout -b feature/NOM_fonctionnalite
```

3. Commiter vos changements

```bash
git commit -m "Ajout de ..."
```

4. Pousser la branche

```bash
git push origin feature/NOM_fonctionnalite
```

5. Ouvrir une Pull Request sur GitHub

---

## 👥 Auteurs


---

## 🙏 Remerciements

* Laravel pour son écosystème puissant
* Les membres de l'équipe projet
* Les enseignants et encadrants pour leur soutien pédagogique
