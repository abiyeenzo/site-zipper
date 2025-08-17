
# Site Zipper – Dashboard Pro

![PHP](https://img.shields.io/badge/PHP-8.0+-blue)
![License](https://img.shields.io/badge/License-MIT-green)
![Responsive](https://img.shields.io/badge/Responsive-Yes-orange)
![Languages](https://img.shields.io/badge/Languages-4-brightgreen)

Site Zipper est un outil PHP léger et responsive permettant de **scanner, zipper et gérer l’archive complète d’un site web** via une interface web simple et multilingue.

---

## Fonctionnalités

- **Création de ZIP du site :**
  - Scanne automatiquement tous les fichiers du site.
  - Crée une archive ZIP complète prête à être téléchargée.

- **Gestion des archives existantes :**
  - Affiche la liste des fichiers ZIP créés.
  - Permet de **renommer**, **supprimer** ou **télécharger** chaque archive.

- **Interface multilingue :**
  - Supporte plusieurs langues : français, anglais, chinois, russe.
  - Détection automatique de la langue du navigateur.
  - Possibilité de changer la langue manuellement via un menu déroulant.

- **Responsive et moderne :**
  - Design épuré compatible mobile et desktop.
  - Boutons d’action clairs avec icônes Font Awesome.

- **Sécurité basique :**
  - Protection contre les chemins de fichiers malveillants.
  - Gestion sécurisée des noms de fichiers avec `basename()`.

---

## Installation

1. **Téléchargez ou clonez le dépôt :**
```bash
git clone https://github.com/abiyeenzo/site-zipper.git
````

2. **Placez le projet dans votre serveur PHP** (ex. `htdocs` ou `www`).

3. **Assurez-vous que le serveur a les permissions d’écriture** dans le dossier pour créer les ZIP.

4. **Ouvrez le dashboard dans votre navigateur :**

```
http://localhost/site-zipper/
```

---

## Utilisation

* Cliquez sur le bouton **Scanner et zipper tout le site** pour créer une archive ZIP.
* La section **Zips existants** liste toutes les archives créées.
* Pour chaque archive, vous pouvez :

  * **Télécharger** la ZIP.
  * **Renommer** le fichier.
  * **Supprimer** l’archive.
* Changez la langue avec le menu déroulant en haut de la page.

---

## Dossiers importants

* `/lang/` : contient les fichiers de traduction par langue (`fr.php`, `en.php`, `zh.php`, `ru.php`).
* `/` : contient le script principal `index.php` et les fichiers ZIP créés.

---

## Technologies

* PHP 8+
* HTML / CSS
* JavaScript
* Font Awesome 6

---

## Licence

Ce projet est sous licence **MIT**.
Vous êtes libre de l’utiliser et de le modifier. Voir [LICENSE](LICENSE) pour plus de détails.

---

## Auteur

**Abiye Enzo** – [GitHub](https://github.com/abiyeenzo)

---
## Capture d’écran

Voici les captures d’écran du dashboard multilingue de **Site Zipper**, organisées en carré 4×4 :

| English (EN) | Français (FR) | Русский (RU) | 中文 (ZH) |
|--------------|---------------|--------------|-----------|
| ![EN](https://github.com/user-attachments/assets/19e4fa01-8ce0-4362-b0fb-bf843ce9ef4c) | ![FR](https://github.com/user-attachments/assets/25eae430-9b50-47ec-a9ee-727f5c064bbf) | ![RU](https://github.com/user-attachments/assets/1cc48e1a-4132-49ec-8625-954eee2f022f) | ![ZH](https://github.com/user-attachments/assets/bd4a5c17-c48c-4bf7-a1ee-acbf51bb85ac) |
