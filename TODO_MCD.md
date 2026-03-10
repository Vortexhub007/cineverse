# 🎬 MCD CineVerse - À créer dans Looping

## Instructions pour Looping

Ouvrez **Looping** et créez le MCD suivant :

---

## 📦 ENTITÉS

### 1. USER
**Attributs** :
- #user_id (Identifiant - AI)
- username (Texte 50)
- email (Texte 100)
- password (Texte 255)
- role (Texte 10)
- created_at (Date)

---

### 2. MOVIE
**Attributs** :
- #movie_id (Identifiant - AI)
- tmdb_id (Numérique)
- title (Texte 255)
- original_title (Texte 255)
- overview (Texte long)
- release_date (Date)
- vote_average (Numérique décimal 3,1)
- vote_count (Numérique)
- popularity (Numérique décimal 10,2)
- runtime (Numérique)
- budget (Numérique)
- revenue (Numérique)
- poster_path (Texte 255)
- backdrop_path (Texte 255)
- original_language (Texte 10)
- adult (Booléen)
- created_at (Date)

---

### 3. GENRE
**Attributs** :
- #genre_id (Identifiant)
- name (Texte 50)

---

## 🔗 ASSOCIATIONS (RELATIONS)

### Association 1 : AJOUTER_FAVORIS
**Entre** : USER et MOVIE
**Cardinalités** :
- USER (0,n) ──── AJOUTER_FAVORIS ──── (0,n) MOVIE
**Attribut de l'association** :
- created_at (Date)

---

### Association 2 : NOTER
**Entre** : USER et MOVIE
**Cardinalités** :  
- USER (0,n) ──── NOTER ──── (0,n) MOVIE
**Attributs de l'association** :
- rating (Numérique 1-5)
- comment (Texte long)
- created_at (Date)
- updated_at (Date)

---

### Association 3 : APPARTENIR
**Entre** : MOVIE et GENRE
**Cardinalités** :
- MOVIE (0,n) ──── APPARTENIR ──── (1,n) GENRE

---

## 📝 Notes pour le MCD

### Cardinalités expliquées :

**USER ──(0,n)── AJOUTER_FAVORIS ──(0,n)── MOVIE**
- Un utilisateur peut ajouter 0 ou plusieurs films en favoris
- Un film peut être ajouté en favoris par 0 ou plusieurs utilisateurs

**USER ──(0,n)── NOTER ──(0,n)── MOVIE**
- Un utilisateur peut noter 0 ou plusieurs films
- Un film peut être noté par 0 ou plusieurs utilisateurs

**MOVIE ──(0,n)── APPARTENIR ──(1,n)── GENRE**
- Un film appartient à au moins 1 genre (et peut en avoir plusieurs)
- Un genre peut être attribué à 0 ou plusieurs films

---

## 🎨 Exportation depuis Looping

1. **Créer le MCD** avec les entités et associations ci-dessus
2. **Générer le MLD** automatiquement (Menu → Générer → MLD)
3. **Exporter en image** :
   - Fichier → Exporter → Image PNG
   - Sauvegarder : `MCD_CineVerse.png`
   - Sauvegarder : `MLD_CineVerse.png`

---

## 📄 MLD Résultant (Tables)

Après génération automatique dans Looping, vous obtiendrez :

### Tables principales :
1. **users** (#user_id, username, email, password, role, created_at)
2. **movies** (#movie_id, tmdb_id, title, overview, release_date, vote_average, ...)
3. **genres** (#genre_id, name)

### Tables d'association :
4. **favorites** (#favorite_id, _user_id, _movie_id, created_at)
5. **reviews** (#review_id, _user_id, _movie_id, rating, comment, created_at, updated_at)
6. **movie_genres** (#movie_genre_id, _movie_id, _genre_id)

**Légende** :
- `#` = Clé primaire
- `_` = Clé étrangère

---

## ✅ Checklist Looping

- [ ] Ouvrir Looping
- [ ] Créer l'entité USER avec ses attributs
- [ ] Créer l'entité MOVIE avec ses attributs
- [ ] Créer l'entité GENRE avec ses attributs
- [ ] Créer l'association AJOUTER_FAVORIS (USER ↔ MOVIE)
- [ ] Créer l'association NOTER (USER ↔ MOVIE)
- [ ] Créer l'association APPARTENIR (MOVIE ↔ GENRE)
- [ ] Vérifier les cardinalités
- [ ] Générer le MLD
- [ ] Exporter MCD en PNG
- [ ] Exporter MLD en PNG
- [ ] Sauvegarder le fichier .loo