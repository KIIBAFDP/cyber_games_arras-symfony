import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */

// Ce fichier sert de point d'entrée pour Webpack
console.log('Hello depuis Webpack !');

// Vous pouvez importer ici vos styles ou d'autres modules
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
