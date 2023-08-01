# Linvoice

## is a minimalistic Invoice creation app

### Disclaimer: This cute toy was built to scratch an itch I'm having at work, it's not intended for public consumption

## Tech & Tools:

-   Laravel (v10 base)
-   Breeze / Inertia.js Scaffolding
-   Vue 3: Composition API with `script setup`
-   Tailwind CSS
-   [DaisyUI](https://daisyui.com/)
-   [DomPDF's Laravel Wrapper](https://github.com/barryvdh/laravel-dompdf)

## Features:

-   Easy to use
-   Elegant Responsive UI

## Code Style/Format Treatment

[Laravel Pint](https://laravel.com/docs/10.x/pint) with stock config & [Prettier](https://prettier.io/)

## Try it online!

[Demo](https://linvoice-production.up.railway.app/create)

## Local Dev Env Setup

### Install Dependencies

```bash
composer install
npm install
```

### Set Environment Variables

```
cp .env.example .env
```

### Migrations

```bash
php artisan migrate --seed
```

### Run Dev Server

```bash
php artisan serve
```

### Compile Vue.js

```bash
npm run dev
```
