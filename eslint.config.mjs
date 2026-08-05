/**
 * ESLint flat config.
 *
 * Replaces .jshintrc and .jscsrc. JSCS was deprecated years ago and its own
 * notice tells users to migrate to ESLint ("JSCS has merged with ESLint").
 *
 * Only plugin-authored JavaScript is linted; assets/js/vendor/ holds bundled
 * third-party libraries.
 */
import js from '@eslint/js';
import globals from 'globals';

export default [
  {
    ignores: [
      'node_modules/**',
      'vendor/**',
      'build/**',
      'assets/js/vendor/**',
      'assets/js/**/*.min.js',
    ],
  },
  js.configs.recommended,
  {
    files: ['assets/js/**/*.js'],
    languageOptions: {
      ecmaVersion: 2022,
      sourceType: 'script',
      globals: {
        ...globals.browser,
        jQuery: 'readonly',
        wp: 'readonly',
        // Localized by wp_localize_script() in inc/shapely-enqueues.php.
        shapelyCompanion: 'readonly',
        // Provided by the enqueued 'nav-menu' dependency (WP core).
        wpNavMenu: 'readonly',
        // Provided by the WP editor; previewer.js feature-detects Masonry.
        tinymce: 'readonly',
        Masonry: 'readonly',
      },
    },
    rules: {
      curly: 'error',
      eqeqeq: ['error', 'allow-null'],
      quotes: ['error', 'single', { avoidEscape: true }],
      'no-caller': 'error',
      'no-eval': 'error',
      'no-implied-eval': 'error',
      'no-irregular-whitespace': ['error', { skipStrings: true }],
      'no-unused-vars': ['warn', { args: 'none' }],
      'no-undef': 'error',
    },
  },
];
