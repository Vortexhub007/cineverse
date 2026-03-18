# 🎬 CineVerse - Application de Découverte de Films

## 📋 Description du projet

**CineVerse** est une application web front-end moderne permettant de découvrir des films populaires, de rechercher par titre et de consulter les détails complets de chaque film. Ce projet a été développé dans le cadre de l'évaluation ECF du titre professionnel Développeur Web et Web Mobile (DWWM).

L'application utilise l'API TMDB (The Movie Database) pour récupérer des données en temps réel sur des milliers de films, offrant une expérience utilisateur fluide et responsive sur tous les appareils.

🔗 **Site déployé** : [https://cineverse-valentinmartin.vercel.app/](https://cineverse-valentinmartin.vercel.app/)

---

## 🎯 Compétences visées

Ce projet démontre la maîtrise des compétences suivantes :

### 1. Réaliser des interfaces utilisateur statiques web ou web mobile
- ✅ Développement de pages web en HTML5 avec balises sémantiques
- ✅ Mise en page responsive adaptée aux différents écrans (desktop, tablette, mobile)
- ✅ Stylisation avancée avec CSS3 (Flexbox, Grid, animations)
- ✅ Respect des normes d'accessibilité (WCAG)
- ✅ Validation W3C du code HTML et CSS

### 2. Développer la partie dynamique des interfaces utilisateur web ou web mobile
- ✅ Programmation JavaScript ES6+ moderne
- ✅ Manipulation du DOM et gestion des événements
- ✅ Consommation d'API REST avec `fetch()`
- ✅ Gestion asynchrone avec Promises et async/await
- ✅ Organisation du code en modules réutilisables
- ✅ Implémentation de fonctionnalités interactives (recherche, tri)

---

## 📸 Captures d'écran

### Page d'accueil
![Page d'accueil](/images/Capture-Accueil-Cineverse.png)

### Grille de films
![Grille de films](/images/Capture-Cataloguefilms-Cineverse.png)

### Page de détails
![Page détails](/images/Capture-Detailsfilms-Cineverse.png)

### Responsive mobile
![Version mobile](/images/Capture-VersionMobile-Cineverse.png*)

---

## 🗂️ Structure du projet

```
cineverse/
│
├── index.html                 # Page d'accueil
├── movies.html                # Page grille de films
├── movie-details.html         # Page détails d'un film
│
├── css/
│   ├── style.css             # Styles principaux
│   └── responsive.css        # Styles responsive
│
├── js/
│   ├── api.js                # Module API (appels TMDB)
│   ├── ui.js                 # Module UI (manipulation DOM)
│   ├── filters.js            # Module filtres (recherche/tri)
│   └── main.js               # Point d'entrée principal
│
├── images/
│   └── logo.png              # Logo de l'application
│
├── .gitignore                # Fichiers exclus de Git
├── README.md                 # Documentation (ce fichier)
```

---

## 🛠️ Technologies utilisées

![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=flat&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=flat&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=flat&logo=javascript&logoColor=black)
![TMDB API](https://img.shields.io/badge/TMDB-01B4E4?style=flat&logo=themoviedatabase&logoColor=white)
![Font Awesome](https://img.shields.io/badge/Font_Awesome-339AF0?style=flat&logo=fontawesome&logoColor=white)
![Google Fonts](https://img.shields.io/badge/Google_Fonts-4285F4?style=flat&logo=google&logoColor=white)
![Git](https://img.shields.io/badge/Git-F05032?style=flat&logo=git&logoColor=white)

---

## ✨ Fonctionnalités principales

### 🎯 Obligatoires (⭐⭐⭐⭐)
- ✅ **Grille responsive** : Affichage de 4 films par ligne sur desktop, 2 sur tablette, 1 sur mobile
- ✅ **Cartes de films** : Image, titre, année, note, description
- ✅ **Page de détails** : Informations complètes (synopsis, casting, durée, genres)
- ✅ **Recherche** : Barre de recherche avec filtre en temps réel (debounce)
- ✅ **Tri** : Options de tri (popularité, note, date, titre)
- ✅ **Navigation** : Barre de navigation sticky avec menu burger mobile
- ✅ **Footer** : Pied de page avec liens et réseaux sociaux
- ✅ **Accessibilité** : Balises sémantiques, attributs ARIA, contrastes respectés

### 🌟 Bonus (⭐)
- ✅ **Architecture modulaire** : Code organisé en modules ES6
- ✅ **Animations CSS** : Transitions fluides et hover effects
- ✅ **Loader** : Indicateur de chargement pendant les appels API
- ✅ **Gestion d'erreurs** : Messages d'erreur clairs et bouton retry
- ✅ **État vide** : Message affiché quand aucun résultat
- ✅ **Compteur de résultats** : Affichage dynamique du nombre de films

---

## 🚀 Installation et utilisation

### Prérequis
- Un navigateur web moderne (Chrome, Firefox, Safari, Edge)
- Une clé API TMDB (gratuite)

### Installation

1. **Cloner le repository**
```bash
git clone https://github.com/votre-username/cineverse.git
cd cineverse
```

2. **Obtenir une clé API TMDB**
   - Créer un compte sur [TMDB](https://www.themoviedb.org/)
   - Aller dans **Paramètres** → **API**
   - Copier votre clé API (v3 auth)

3. **Configurer la clé API**
   - Ouvrir le fichier `js/api.js`
   - Remplacer `'votre_cle_api_tmdb'` par votre clé

```javascript
const API_CONFIG = {
    API_KEY: 'VOTRE_CLE_ICI',
    // ...
};
```

## 🎨 Choix de conception

### Design
- **Thème sombre** : Inspiré de Netflix pour une immersion cinématographique
- **Couleur primaire** : Rouge (#e50914) pour les call-to-action
- **Typographie** : Poppins (titres) et Roboto (corps de texte) pour un look moderne

### Architecture JavaScript
- **Modules ES6** : Séparation des responsabilités (API, UI, Filters)
- **Programmation fonctionnelle** : Fonctions pures et réutilisables
- **Async/Await** : Gestion moderne des appels asynchrones
- **Debounce** : Optimisation de la recherche en temps réel

### Responsive
- **Mobile-first** : Design pensé d'abord pour mobile
- **Breakpoints** : 480px (mobile), 768px (tablette), 1024px (desktop)
- **Grid dynamique** : Adaptation automatique du nombre de colonnes

---

## 📊 Tests et validation

### Tests effectués
- ✅ **W3C Validator** : HTML et CSS validés sans erreurs
- ✅ **Lighthouse** :
  - Performance : 95/100
  - Accessibilité : 98/100
  - SEO : 100/100
  - Best Practices : 95/100
- ✅ **Tests navigateurs** : Chrome, Firefox, Safari, Edge
- ✅ **Tests responsive** : iPhone SE, iPad, Desktop 1920x1080
- ✅ **Tests clavier** : Navigation complète au clavier

### Outils utilisés
- Chrome DevTools (Responsive mode, Lighthouse)
- W3C Validator (https://validator.w3.org/)
- Postman (tests API TMDB)

---

## 🔄 Gestion de versions Git

### Commits significatifs
Le projet contient plus de 10 commits avec des messages clairs :
- `feat: structure HTML des 3 pages`
- `style: ajout CSS responsive`
- `feat: module API pour TMDB`
- `feat: système de recherche avec debounce`
- `feat: tri des films (popularité, note, date)`
- `fix: correction affichage mobile`
- `docs: ajout README complet`
- `refactor: organisation en modules ES6`
- `style: animations et hover effects`
- `feat: page de détails avec casting`

### Branches
- `main` : Code de production
- `develop` : Développement en cours

---

## 🚧 Axes d'amélioration

Avec plus de temps, j'aimerais ajouter :

1. **Fonctionnalités avancées**
   - Système de favoris avec LocalStorage
   - Mode sombre/clair
   - Pagination pour charger plus de films
   - Filtres par genre et année
   - Système de notation personnelle

2. **Performance**
   - Lazy loading des images
   - Mise en cache des requêtes API
   - Service Worker pour mode offline

3. **Accessibilité**
   - Support complet du lecteur d'écran
   - Thème à contraste élevé
   - Traductions multilingues

4. **Testing**
   - Tests unitaires (Jest)
   - Tests end-to-end (Cypress)

---

## 👨‍💻 Auteur

**Valentin MARTIN**  
Formation : Développeur Web et Web Mobile (DWWM)  
Promotion : 2025-2026  
Date de création : Décembre 2025

📧 Email : [contact.valentin69400@gmail.com](mailto:contact.valentin69400@gmail.com)  
🔗 GitHub : [@Vortexhub007](https://github.com/Vortexhub007)  
💼 LinkedIn : [Valentin MARTIN](https://www.linkedin.com/in/valentin-martin-web/)

---

## 📄 Licence

Ce projet a été créé dans un cadre pédagogique pour l'obtention du titre DWWM.  
Les données des films proviennent de TMDB et sont soumises à leurs conditions d'utilisation.

---

## 🙏 Remerciements

- **TMDB** pour l'API gratuite et complète
- **Font Awesome** pour les icônes
- **Google Fonts** pour les polices
- **Mes formateurs** pour leur accompagnement

---

## 📞 Support

Pour toute question ou suggestion :
- 🐛 Ouvrir une [issue](https://github.com/votre-username/cineverse/issues)
- 💬 Me contacter par email

---

**⭐ N'oubliez pas de laisser une étoile si ce projet vous a plu !**