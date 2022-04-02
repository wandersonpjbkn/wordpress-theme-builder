# WordPress Theme Builder

Este projeto tem o carater de prover um conjunto de ferramentas para facilitar o desenvolvimento de temas para WordPress.

## Requisitos

- PHP: 7.0.33^
- [Advanced Custom Fields](https://wordpress.org/plugins/advanced-custom-fields/): 5.8.12^
- [WordPress](https://wordpress.org/download/): 5.4.1^
- [WooCommerce](https://wordpress.org/plugins/woocommerce/): 4.3.0

## Guidelines

- PHP
  - `Templates`, `Template-parts` and `Components` are compressed for performance
  - Because of this, don't write multiple line functions or conditions
  - For any complex validation, invoke a specific function
  - If it needs to write a code snippet, invoke a template-part or a component
  - Make use of variable sharing / global
  - Try not to have exceptions

## Commands

Build for deploy:

``` bash
npm run build --prod
```

``` bash
gulp build --production
```

Place a watcher on the whole `src` folder:

``` bash
npm run watch --prod
```

``` bash
gulp watch --production
```

Clean `dist` folder:

``` bash
gulp clean
```

> Disclaimer: This program have a watcher built in, but it's not that reactive to changes - especiatilly with added new/old files. So, after add or remove anything, is to best run `gulp build` or `npm run build`. There's also `--prod` and `--dev` mode attached to each command. By default, gulp will run everything as `--dev`.

## Folder structure

``` txt
|- builder/
  |- gulp/
  |- utils/
  |- webpack/
  |- config.js
|- dist/
|- node_modules/
|- theme/
  |- public/
  |- src/
    |- assets/
    |- components/
    |- functions/
    |- templates/
    |- templates-parts/
    |- woocommerce/
|- .babelrc
|- .eslintignore
|- .eslintrc.js
|- .gitignore
|- gulpfile.babel.js
|- package.json
```

### Details

- Files
  - `/builder/config.js`: Builder config - mostly, global variables
  - `.babelrc`: Babel config
  - `gulpfile.babel.js`: Gulp config exit

- Folder
  - `/builder/gulp`: contain the gulp config parts
  - `/builder/dist`: files for distribution
  - `/builder/utils`: JS for builder
  - `/builder/webpack`: contain the webpack config parts
  - `/theme/public`: static files for distribution
  - `/theme/src`: files for development
    - `/assets`: assets files
    - `/components`: reusable components
    - `/functions`: functions parts
    - `/templates`: resusable templates
    - `/templates-parts`: templates parts
    - `/woocommerce`: woocommerce parts

## Helpful links

### WordPress

- [Bloginfo](https://developer.wordpress.org/reference/functions/bloginfo/)
- [Conditional Tags](https://codex.wordpress.org/Conditional_Tags)
- [Functions](https://codex.wordpress.org/Function_Reference)
- [Template Tags](https://codex.wordpress.org/Template_Tags)
- [Theme Handbook](https://developer.wordpress.org/themes/getting-started/)

### Structure

- [Gulp 4.0](https://github.com/gulpjs/gulp#use-latest-javascript-version-in-your-gulpfile)
- [CSS Tools: Reset CSS](https://meyerweb.com/eric/tools/css/reset/)
- [WooCommerce: Templates](https://docs.woocommerce.com/document/template-structure/)
- [WooCommerce: Conditional Tags](https://docs.woocommerce.com/document/conditional-tags/)
- [WooCommerce: Checkout Fields](https://docs.woocommerce.com/document/tutorial-customising-checkout-fields-using-actions-and-filters/)
- [ARIA](https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA)
- [ARIA Techniques](https://developer.mozilla.org/pt-BR/docs/Web/Accessibility/ARIA/ARIA_Techniques)
- [Kinda: Speed up Your WordPress (2020)](https://kinsta.com/learn/speed-up-wordpress/)
- [JavaScript Events](https://developer.mozilla.org/pt-BR/docs/Web/Events)

### Others

- [CHANGELOG](CHANGELOG.md)

### Icons (PNG)

- android-chrome-192x192
- android-chrome-512x512
- apple-touch-icon
- apple-touch-icon-60x60
- apple-touch-icon-76x76
- apple-touch-icon-120x120
- apple-touch-icon-152x152
- apple-touch-icon-180x180
- favicon-16x16
- favicon-32x32
- msapplication-icon-144x144
- mstile-150x150

### Icons (SVG)
- safari-pinned-tab
