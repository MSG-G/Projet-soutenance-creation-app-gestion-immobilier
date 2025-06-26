# 🏘️ Dev-Immo - Application Web de Gestion Immobilière

**Dev-Immo** est une application web moderne développée avec **Laravel** et **Postgres**, permettant la gestion des biens immobiliers, des utilisateurs (clients, agents, administrateurs), des réservations, des transactions (vente/location) et des contrats. Elle offre également un système de messagerie interne et un tableau de bord statistique.

---

## 📋 Fonctionnalités

### 🔐 Gestion des utilisateurs
- Inscription et connexion sécurisée (breeze)
- Attribution de rôles : client, agent, administrateur
- Modification des informations utilisateur
- Tableau de bord personnalisé selon le rôle

### 🏡 Gestion des biens immobiliers
- Création et modification de biens (vente ou location)
- Ajout de description, images, prix, localisation, type
- Consultation et recherche de biens avec filtres
- Historique et statut du bien (disponible, réservé, vendu, loué)

### 📅 Réservations & Rendez-vous
- Planification de visites par les clients
- Confirmation, annulation ou reprogrammation par les agents

### 📄 Transactions et contrats
- Enregistrement des ventes ou locations
- Suivi du statut des transactions (en cours, terminée)
- Génération automatique de contrats PDF

### 💬 Messagerie interne
- Envoi de messages entre clients et agents
- Notification en temps réel

### 📊 Statistiques
- Nombre de biens en ligne, vendus ou loués
- Activité des agents
- Revenus générés par type de transaction

---

## 🔧 Prérequis

- PHP >= 8.1  
- Composer 2.x  
- Laravel 10 ou supérieur  
- PostgreSQL  
- Node.js + npm  

---

## 📁 Structure du projet Laravel


---

## 🛠️ Technologies Utilisées

- Laravel : Framework PHP MVC moderne  
- Postgres : Base de données relationnelle  
- Breeze : Authentification Laravel  
- Postman : Tests API  
- HTML / CSS / JS / React : Mise en page responsive  
- Git & GitHub : Versionnage et collaboration  

---

## 📱 Interfaces prévues

- Page d’accueil publique avec moteur de recherche  
- Tableau de bord Admin  
- Espace Agent (gestion de ses biens et visites)  
- Espace Client (réservation, consultation contrat)  
- Système de messagerie intégré (optionnel)  

---

## 📝 Contribution

1. Cloner le dépôt  
2. Créer une branche pour votre fonctionnalité :
```bash
git checkout -b feature/NOM_fonctionnalite

