# DOCUMENTATION TECHNIQUE <!-- omit in toc -->
# Tennis <!-- omit in toc -->

***CFPT-Informatique***

## Tables des matières <!-- omit in toc -->

- [1. Table des versions](#1-table-des-versions)
- [2. Introduction](#2-introduction)
- [3. Résumé du cahier des charges](#3-résumé-du-cahier-des-charges)
  - [3.1. Organisation](#31-organisation)
  - [3.2. Livrables](#32-livrables)
  - [3.3. Matériel et logiciels à disposition](#33-matériel-et-logiciels-à-disposition)
  - [3.4. Description de l'application](#34-description-de-lapplication)
- [4. Méthodologie](#4-méthodologie)
  - [4.1. S'informer](#41-sinformer)
  - [4.2. Planifier](#42-planifier)
  - [4.3. Décider](#43-décider)
  - [4.4. Réaliser](#44-réaliser)
  - [4.5. Contrôler](#45-contrôler)
  - [4.6. Evaluer](#46-evaluer)
- [5. Planification](#5-planification)
  - [5.1. Product Backlog](#51-product-backlog)
  - [5.2. Diagramme de Gantt](#52-diagramme-de-gantt)
- [6. Analyse Fonctionnelle](#6-analyse-fonctionnelle)
  - [6.1. Interface graphique](#61-interface-graphique)
    - [6.1.1. Page...](#611-page)
  - [6.2. Fonctionnalités](#62-fonctionnalités)
  - [6.3. Description des fonctionnalités](#63-description-des-fonctionnalités)
  - [6.4. Mesure de sécurité](#64-mesure-de-sécurité)
- [7. Analyse Organique](#7-analyse-organique)
  - [7.1. Technologies utilisées](#71-technologies-utilisées)
  - [7.2. Environnement](#72-environnement)
  - [7.3. Description de la base de données](#73-description-de-la-base-de-données)
    - [7.3.1. Modèle logique de données](#731-modèle-logique-de-données)
  - [7.4. Classes](#74-classes)
  - [7.5. Pages](#75-pages)
- [8. Tests](#8-tests)
  - [8.1. Environnement des tests](#81-environnement-des-tests)
  - [8.2. Plan de test](#82-plan-de-test)
  - [8.3. Rapport de test](#83-rapport-de-test)
- [9. Conclusion](#9-conclusion)
- [10. Bibliographie](#10-bibliographie)
- [11. Annexes](#11-annexes)
  - [11.1. Planning Prévisionnel](#111-planning-prévisionnel)
  - [11.2. Planning Effectif](#112-planning-effectif)
  - [11.3. Code Source](#113-code-source)

## 1. Table des versions
> a faire !!!!!!!!


## 2. Introduction
> Ce document est un rapport montrant la conception du projet.
> Ce projet, réalisé dans le cadre du TPI (Travail Pratique Individuel), permet de valider mes compétances afin l'obtention du CFC.
> Le site web Tennis est un site web permettant la gestion de tournois de tennis. Le tournois prend en compte plusieurs paramètres comme le type de tournois, le nombre de set ou encore le genre (homme/femme) de joueur qui peut participer au tournois.

## 3. Résumé du cahier des charges
> Je dois réaliser un site web en adequation avec le cahier des charges qui m'a été fourni

### 3.1. Organisation


| Elève              | Formateur                | Expert                      | Expert                    |
| ------------------ | ------------------------ | --------------------------- | ------------------------- |
| Bonvallat Dan      | Bergeret Patrick Joseph  | Strazzeri Mickaël           | Vanini Daniel             |
| dan.bnvll@eduge.ch | edu-bergeretpj@edu.ge.ch | mickael.strazzeri@git-it.ch | daniel.vanini@skyguide.ch |



### 3.2. Livrables
* Planning 
* Documentation technique avec codes sources
* Manuel utlisateur
* Résumé du rapport du TPI
* Journal de bord

### 3.3. Matériel et logiciels à disposition
 Un PC standard école, 2 écrans
 Windows 10
 EasyPHP, Laragon, WAMP ou autre
 mysql workbench, phpmyadmin
 Visual Studio Code
 Suite Office

### 3.4. Description de l'application
> L’application permet de réaliser la gestion de tournois de tennis. Elle fournit une planification des matchs, l’inscription des joueurset l’enregistrement des résultats des matchs. L’application se compose de deux parties : 
> * Gestion des tournois,
> * Gestion des matchs.
> 
> Les fonctionnalités disponibles sont les suivantes :
> * Créer, modifier, supprimer un tournoi, 
> * La liste des joueurs inscrits au tournoi est fournie, 
> * Planifier les matchs, 
> * Enregistrer les résultats des matchs,
> * Effectuer des recherches : liste des joueurs, joueurs inscrits à un tournoi, liste des matchs, résultat, vainqueur, perdant d’un mach, résultats des match, …
> 
> Règles de gestion
> Tournois :
> * La création est faite avant le début du tournoi,
> * Le processus de création comporte quatre étapes :
> ◦ Initialisation avec les informations du tournoi
> ◦ Répartition des joueurs dans les tableaux haut et bas,
> ◦ Planification des matchs
> * Après la date de début du tournoi le tournoi est automatiquement verrouillé,
> * Le tournoi est aussi verrouillé sur demande explicite,
> * Une fois verrouillé le tournoi ne peut plus être modifié ni supprimé,
> * Copier un tournoi,
> * Le tournoi ne prend en charge que des matchs en simple,
> * Le genre est masculin ou féminin,
> * Le nombre de sets est trois ou cinq
> * La surface est : terre battue, gazon, surface rapide, …
> * La catégorie est : Grand Chelem, Masters, Masters 1000, ATP 500 Series, ATP 250 Series, ATP Challenge Tour, …
> * Tournoi avec ou sans jeu décisif.
> 
> Joueurs :
> * La liste des joueurs inscrits au tournoi est fournie.
> 
> Matchs :
> * Un match se joue en trois ou cinq sets (défini au niveau du tournoi)
> * Le joueur qui gagne deux sets ou trois sets est déclaré vainqueur.
> * Un match est gagné par forfait si un joueur abandonne en cours de match ou déclare forfait avant le début du match. Le score est celui au moment de l’abandon ou reste non rempli.
> 
> Sets :
> * Dans un tournoi sans jeu décisif, le joueur qui gagne six jeux ou plus avec au moins deux jeux d’écart, remporte le set, exemples 6-1, 6-4, 7-5, 10-8, 14-12, …
> * Dans un tournoi avec jeu décisif, le joueur qui gagne six ou sept jeux avec deux jeux d’écart ou en cas d’égalité 6-6, gagne le jeu décisif, remporte le set, exemples 6-0, …, 6-4, 7-5 ou 7-6
> 
> Jeux :
> * Un jeu est remporté par le joueur qui arrive à quatre points ou plus avec au moins deux points d’écart,
> * Un jeu décisif est gagné par le joueur qui arrive à six points minimum avec deux points d’écart.
> 
> Planification :
> * Un tournoi est composé de deux tableaux : haut et bas,
> * La répartition des joueurs se fait en fonction des têtes de série,
> * Les têtes de série impaires sont placées dans le tableau haut,
> * Les têtes de série paires sont placées dans le tableau bas,
> * Le nombre de tours dans le tournoi dépend du nombre de participants, exemple pour 32 participants, 5 tours à jouer finale incluse (1er tour, 2e tour, ¼, ½ et finale),
> * Les quatre premières têtes de série ne se rencontre qu’à partir des ¼ de finales.
> 
> Interfaces
> 
> « menus »
> Tournois : liste, affiche, recherche, crée, modifie, supprime, copie, verrouille
> Joueurs : liste, affiche, recherche
> Matchs : planifie, répartie les joueurs dans les tableaux, consulte
> Résultats : enregistre, modifie, efface, consulte
> 
> « accueil »
> La page d’accueil affiche par défaut le dernier tournoi consulté, avec ses informations.
> Une zone de recherche présente une liste déroulante avec les tournois, un clic sur un tournoi, met à jour l’affichage avec les informations du tournoi sélectionné.
> 
> « tournois »
> La page affiche la liste des tournois.
> Les actions disponibles : rechercher, voir, créer, modifier, supprimer, copier et verrouillé un tournoi.
> 
> « joueurs »
> La page affiche la liste des joueurs.
> Les actions disponibles : rechercher, voir un joueur.
> « matchs »
> La page affiche la liste des matchs du tournoi sélectionné.
> Les actions disponibles : rechercher, planifier, répartir les joueurs et voir un match.
> 
> « résultats »
> La page affiche le score d’un match.
> Les actions disponibles : sélectionner, enregistrer, modifier et effacer le score d’un match.

## 4. Méthodologie
> Afin de planifier mon projet, j'utilise la méthodologie en six étapes.

### 4.1. S'informer
> La première chose que j'ai faite est de lire attentivement l'énoncé de mon tpi
> Après la lecture du tpi, j'ai appelé mon formateur afin de lui poser des questions sur l'énoncer.

### 4.2. Planifier
> Au début du projet, j'ai découpé le travail que je devais faire pour savoir ce qu'est-ce qui est le plus important.
> Pour tous les points 


### 4.3. Décider

### 4.4. Réaliser

### 4.5. Contrôler

### 4.6. Evaluer

## 5. Planification

### 5.1. Product Backlog

### 5.2. Diagramme de Gantt

## 6. Analyse Fonctionnelle

### 6.1. Interface graphique

#### 6.1.1. Page...

### 6.2. Fonctionnalités

### 6.3. Description des fonctionnalités

### 6.4. Mesure de sécurité

## 7. Analyse Organique

### 7.1. Technologies utilisées

### 7.2. Environnement

### 7.3. Description de la base de données

#### 7.3.1. Modèle logique de données

### 7.4. Classes

### 7.5. Pages

## 8. Tests

### 8.1. Environnement des tests

### 8.2. Plan de test

| N°  | Description du test                                | Résultat attendu |
| --- | -------------------------------------------------- | ---------------- |
| 1   | Test magnifique cil est vraiment trop bien ce test | Il se passe ça   |
| 2   |                                                    |                  |
|     |                                                    |                  |

### 8.3. Rapport de test

OK -> le test fonctionne / NOK -> le test ne fonctionne pas

| N°  | Résultat obtenu                                    | Validation      |
| --- | -------------------------------------------------- | --------------- |
| 1   | Test magnifique cil est vraiment trop bien ce test | OK (26.04.2021) |
| 2   |                                                    |                 |
|     |                                                    |                 |

## 9. Conclusion

## 10. Bibliographie

## 11. Annexes

### 11.1. Planning Prévisionnel

### 11.2. Planning Effectif

### 11.3. Code Source

