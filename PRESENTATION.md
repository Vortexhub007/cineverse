# PRESENTATION PowerPoint

📊 Plan de Présentation - CineVerse
Durée recommandée : 10-15 minutes

🎬 Slide 1 : Page de titre
Contenu :

Titre : CineVerse - Application de Découverte de Films
Sous-titre : Projet ECF - Développeur Web et Web Mobile
Votre nom et prénom
Date : Décembre 2024
Logo CineVerse (icône film)
Design :

Fond sombre avec image de cinéma en arrière-plan
Couleur principale : Rouge (
#e50914)
📋 Slide 2 : Sommaire
Contenu :

Contexte du projet
Démonstration de l'application
Choix techniques
Difficultés rencontrées
Points de fierté
Axes d'amélioration
🎯 Slide 3 : Contexte du projet
Contenu :

Objectif : Créer une application web front-end dynamique
Thème choisi : Découverte de films
Compétences visées :
Interfaces statiques (HTML5/CSS3)
Partie dynamique (JavaScript ES6+)
Source de données : API TMDB
Visuel :

Icônes HTML5, CSS3, JavaScript
Logo TMDB
💻 Slide 4 : Démonstration - Vue d'ensemble
Contenu :

3 pages :
Page d'accueil (Hero section)
Grille de films
Détails d'un film
Capture d'écran de chaque page
Action en direct :

Navigation entre les pages
🔍 Slide 5 : Démonstration - Fonctionnalités
Contenu :

✅ Recherche en temps réel
✅ Tri (popularité, note, date, titre)
✅ Compteur de résultats
✅ Navigation responsive
✅ Détails complets des films
Action en direct :

Taper dans la barre de recherche
Changer le tri
Cliquer sur un film pour voir les détails
📱 Slide 6 : Responsive Design
Contenu :

Desktop : 4 colonnes (1920x1080)
Tablette : 2 colonnes (768x1024)
Mobile : 1 colonne (360x800)
Visuel :

3 captures d'écran côte à côte montrant les différentes tailles
Ou GIF animé montrant le redimensionnement
Action en direct :

Ouvrir les DevTools et tester le responsive
🛠️ Slide 7 : Technologies utilisées
Contenu :

Front-end :

HTML5 (structure sémantique)
CSS3 (Flexbox, Grid, animations)
JavaScript ES6+ (modules, async/await)
APIs & Ressources :

TMDB API (données des films)
Font Awesome (icônes)
Google Fonts (Poppins, Roboto)
DevOps :

Git/GitHub (gestion de versions)
Vercel (déploiement)
Visuel :

Logos des technologies
🏗️ Slide 8 : Architecture du code
Contenu :

Organisation modulaire :

js/
├── api.js      → Appels API TMDB
├── ui.js       → Manipulation DOM
├── filters.js  → Recherche et tri
└── main.js     → Orchestration
Avantages :

✅ Code réutilisable
✅ Maintenance facilitée
✅ Séparation des responsabilités
Visuel :

Schéma de l'architecture
Extrait de code (exemple de fonction)
💡 Slide 9 : Extraits de code - API
Contenu :

Exemple : Récupération des films

javascript
export async function getPopularMovies(page = 1) {
    const url = `${BASE_URL}/movie/popular?api_key=${API_KEY}&language=fr-FR&page=${page}`;
    const response = await fetch(url);
    const data = await response.json();
    return data;
}
Points clés :

Utilisation de async/await
Gestion des paramètres
Export ES6 modules
💡 Slide 10 : Extraits de code - Recherche
Contenu :

Exemple : Debounce pour optimiser la recherche

javascript
export function debounce(func, delay = 300) {
    let timeoutId;
    return function(...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => {
            func.apply(this, args);
        }, delay);
    };
}
Bénéfices :

⚡ Réduit le nombre d'appels API
🎯 Améliore les performances
✨ Meilleure expérience utilisateur
🚧 Slide 11 : Difficultés rencontrées
Contenu :

1. Gestion de l'asynchrone

Problème : Comprendre Promises et async/await
Solution : Documentation MDN et tests Postman
2. Responsive complexe

Problème : Grid CSS avec 4/2/1 colonnes
Solution : Media queries et tests DevTools
3. Debounce de la recherche

Problème : Trop d'appels API pendant la saisie
Solution : Implémentation d'un debounce
⭐ Slide 12 : Points de fierté
Contenu :

1. Architecture modulaire

Code organisé et maintenable
Séparation claire des responsabilités
2. Design moderne

Interface inspirée de Netflix
Animations fluides
3. Accessibilité

Balises sémantiques
Navigation au clavier
Contrastes respectés
4. Performance

Score Lighthouse : 95+
📊 Slide 13 : Tests et validation
Contenu :

W3C Validator : ✅ Aucune erreur

Lighthouse :

🟢 Performance : 95/100
🟢 Accessibilité : 98/100
🟢 SEO : 100/100
🟢 Bonnes pratiques : 95/100
Tests navigateurs :

✅ Chrome, Firefox, Safari, Edge
✅ iPhone SE, iPad, Desktop
Visuel :

Capture d'écran des résultats Lighthouse
🔮 Slide 14 : Axes d'amélioration
Contenu :

Avec plus de temps :

Fonctionnalités :

📌 Système de favoris (LocalStorage)
🌓 Mode sombre/clair
📄 Pagination avancée
🎭 Filtres par genre
Technique :

⚡ Lazy loading des images
💾 Cache des requêtes API
🧪 Tests unitaires (Jest)
🎓 Slide 15 : Compétences acquises
Contenu :

Techniques :

✅ Maîtrise HTML5 sémantique
✅ CSS3 avancé (Grid, Flexbox)
✅ JavaScript moderne (ES6+)
✅ Consommation d'API REST
✅ Git et GitHub
Transversales :

✅ Autonomie et organisation
✅ Recherche de solutions
✅ Documentation technique
✅ Présentation de projet
🔗 Slide 16 : Liens et ressources
Contenu :

📌 Site déployé : https://cineverse.vercel.app

💻 GitHub : https://github.com/votre-username/cineverse

📚 Documentation : README complet dans le repository

📧 Contact : votre.email@example.com

QR Code : (optionnel) vers le site déployé

🙏 Slide 17 : Remerciements
Contenu :

Merci à :

👨‍🏫 Mes formateurs pour leur accompagnement
🎬 TMDB pour l'API gratuite
👥 Mes camarades de promotion
💼 Tous ceux qui ont suivi ce projet
Texte final : "Merci de votre attention. Je suis prêt à répondre à vos questions."

💬 Slide 18 : Questions / Réponses
Contenu :

Grand titre : "Questions ?"
Vos coordonnées
Image de fond engageante
📝 Conseils pour la présentation
Avant la présentation
✅ Tester le site en conditions réelles
✅ Préparer une vidéo de démo en backup
✅ Vérifier la connexion internet
✅ Charger le site en avance
Pendant la présentation
🎯 Parler clairement et pas trop vite
👀 Regarder l'auditoire
💡 Expliquer les choix techniques
📊 Montrer les résultats concrets
🎬 Faire une démo live si possible
Gestion du temps
Intro : 1-2 min
Démo : 3-4 min
Technique : 3-4 min
Difficultés/Fierté : 2-3 min
Amélioration : 1-2 min
Questions : 2-3 min
Réponses aux questions fréquentes
"Pourquoi ce thème ?" → Passionné de cinéma + API riche + projet visuellement attractif

"Pourquoi TMDB ?" → API gratuite, complète, bien documentée, données en français

"Difficultés principales ?" → Gestion de l'asynchrone + responsive complexe + debounce

"Pourquoi modules ES6 ?" → Code réutilisable + maintenable + bonne pratique moderne

"Amélioration prioritaire ?" → Système de favoris avec LocalStorage

Bonne présentation ! 🎉
