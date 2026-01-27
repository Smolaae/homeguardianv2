# HomeGuardian - Site Web

Site web responsive pour HomeGuardian, l'assistant intelligent pour la maintenance et la sécurité domestique.

## Fonctionnalités

- ✅ Design responsive avec Tailwind CSS
- ✅ Mode sombre/clair
- ✅ Multi-langue (Français/Anglais)
- ✅ Animations au scroll
- ✅ Formulaire de contact sécurisé
- ✅ Galerie de tutoriels vidéo
- ✅ Section témoignages dynamique
- ✅ Notifications IoT simulées
- ✅ Navigation fluide

## Structure des fichiers

\`\`\`
/
├── index.html          # Page principale
├── app.js             # JavaScript principal
├── locales/
│   ├── fr.json        # Traductions françaises
│   └── en.json        # Traductions anglaises
└── README.md          # Documentation
\`\`\`

## Installation

1. Téléchargez tous les fichiers
2. Ouvrez `index.html` dans votre navigateur
3. Ou hébergez sur votre serveur web préféré

## Intégration CMS

Ce site est prêt à être intégré avec :
- WordPress
- Drupal
- Joomla
- Ou tout autre CMS

### Pour WordPress :
1. Créez un nouveau thème
2. Copiez le HTML dans `index.php`
3. Ajoutez les fichiers JS et JSON dans le dossier du thème
4. Enregistrez les scripts dans `functions.php`

### Pour un hébergement statique :
Compatible avec :
- Vercel
- Netlify
- GitHub Pages
- AWS S3
- Tout hébergement web standard

## Personnalisation

### Couleurs
Les couleurs sont définies dans les variables CSS au début de `index.html` :
- `--primary`: #4a90e2 (Bleu principal)
- `--accent-green`: #37c47a (Vert accent)
- `--accent-red`: #ff6b6b (Rouge doux)

### Traductions
Modifiez les fichiers JSON dans `/locales/` pour ajouter ou modifier les traductions.

### Formulaire de contact
Le formulaire est actuellement en mode démo. Pour l'activer :
1. Remplacez la simulation dans `app.js` (ligne ~200)
2. Ajoutez votre endpoint API
3. Configurez la validation côté serveur

## Support navigateurs

- Chrome (dernières versions)
- Firefox (dernières versions)
- Safari (dernières versions)
- Edge (dernières versions)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Licence

© 2025 HomeGuardian. Tous droits réservés.
