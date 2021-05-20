# DOCUMENTATION UTILISATEUR <!-- omit in toc -->
# Tennis <!-- omit in toc -->

***CFPT-Informatique***

## Tables des matières <!-- omit in toc -->
- [1. Introduction](#1-introduction)
- [2. Navigation](#2-navigation)
- [Installation](#installation)
- [3. Fonctionnalités](#3-fonctionnalités)
  - [3.1. Recherche de tournois](#31-recherche-de-tournois)
  - [3.2. Création](#32-création)
  - [3.3. Modification](#33-modification)
  - [3.4. Recherche de joueur](#34-recherche-de-joueur)
  - [3.5. Planification des matchs](#35-planification-des-matchs)
  - [3.7. Redirection page principale](#37-redirection-page-principale)
  - [3.8. Suppression d'un tournois](#38-suppression-dun-tournois)
  - [3.9. Copier](#39-copier)
- [4. Pages](#4-pages)
  - [4.1. Page index](#41-page-index)
  - [4.2. Page Création](#42-page-création)
  - [4.3. Page Modification](#43-page-modification)
  - [4.4. Page Joueur](#44-page-joueur)
  - [4.5. Page Tournois](#45-page-tournois)

## 1. Introduction
> Le site ***Tennis*** permet de créer, modifier, supprimer des tournois. L'utilisateur peut visualiser un tournois ainsi qu'enregistrer les données des matchs et de télécharger le résultat des matchs
## 2. Navigation
> Lorsque l'utilisateur arrive sur le site, il a accès à la page création. Lorsqu'un tournois est créé, l'utilisateur a accès à trois nouvelles pages. Il peut naviguer à travers les pages modifications, joueurs et tournois (permet de visualiser le tournois).

## Installation
> Il faut importer la base de données qui se trouve dans les dossiers 
> Le mot de passe est Bonval22

## 3. Fonctionnalités
### 3.1. Recherche de tournois
> Sur la page principale, se trouve une barre de recherche.
> L'utilisateur peut entrer du texte et cliquer sur le bouton recherche qui affichera les tournois dont le ou les mots ressemble au nom du tournois.
![recherche](imageDocUtilisateur/recherche.PNG)
### 3.2. Création
> Sur la page création, l'utilisateur doit remplir un formulaire puis le valider en cliquant sur le bouton "Créer".
![creer](imageDocUtilisateur/creer.PNG)

### 3.3. Modification
> La page est la même que la page création mais le formulaire contient déjà les informations du tournois. L'utilisateur n'a plus qu'à changer les données qu'il veut et de valider le formulaire en cliquant sur le bouton "Modifier".
![modifier](imageDocUtilisateur/modifier.PNG)

### 3.4. Recherche de joueur
> Sur cette page l'utilisateur peut rechercher par le nom ou le prénom un joueur grâce à une barre de recherche.
![recherche](imageDocUtilisateur/recherche.PNG)

### 3.5. Planification des matchs
> Sur la page tournois, l'utilisateur peut rentrer les données du match sélectionné (heure, date, résultat).
![planification](imageDocUtilisateur/planification.PNG)

### 3.7. Redirection page principale
> Sur chaque page l'utilisateur peut à tout moment revenir sur la page principale en cliquant sur le titre du site en haut de la page (Tennis). Il sera alors redirigé sur la page principale.
![redirection](imageDocUtilisateur/redirection.PNG)

### 3.8. Suppression d'un tournois
> L'utilisateur peut supprimer un tournois en cliquant sur le lien "Supprimer" à coté d'un tournois.
![supprimer](imageDocUtilisateur/supprimer.PNG)

### 3.9. Copier
> L'utilisateur peut copier un tournoi en cliquant sur le lien "Copier" à coté d'un tournois. Cela aura pour effet de recréer le même tournoi.
![copier](imageDocUtilisateur/copier.PNG)

## 4. Pages
### 4.1. Page index
> C'est sur cette page que l'utilisateur se trouvera lorsqu'il arrivera sur le site. C'est depuis cette page qu'il aura accès aux pages création, modification, tournois et joueurs. Les tournois créés s'afficheront sur cette page. Lorsqu'un tournois est créé, l'utilisateur peut le visualiser, le copier, le supprimer, voir les joueurs du tournois et le modifier.
![pageIndex](../docTechnique/imageCode/pageIndex.PNG)



### 4.2. Page Création
> Sur cette page se trouve un formulaire que l'utilisateur doit remplir. A la fin de ce formulaire, se trouve un bouton permettant de créer le tournois. Lorsque le bouton sera cliqué, l'utilisateur sera redirigé sur la page principale et le tournois apparaîtra.
![pageCreation1](../docTechnique/imageCode/pageCreation1.PNG)
![pageCreation2](../docTechnique/imageCode/pageCreation2.PNG)

### 4.3. Page Modification
> Sur cette page se trouve un formulaire déjà remplit avec les données du tournois. L'utilisateur a juste à modifier le champ qu'il souhaite et cliquer sur le bouton modifier. Il sera redirigé sur la page principale et les données du tournois auront changé.

![pageModification1](../docTechnique/imageCode/pageModification1.PNG)
![pageModification2](../docTechnique/imageCode/pageModification2.PNG)

### 4.4. Page Joueur
> Sur cette page l'utilisateur peut effectuer des recherches sur les joueurs du tournois.
![pageJoueurs](../docTechnique/imageCode/joueurs.PNG)


### 4.5. Page Tournois
> Sur cette page, un bracket du tournois apparaît avec les premiers matches déjà créé. L'utilisateur peut entrer les données des matches et passer au suivant. Il peut aussi télécharger un pdf du match.
![tournois](../docTechnique/imageCode/tournois.PNG)

