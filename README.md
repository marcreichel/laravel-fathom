> **Please note**: This package is still a work in progress and the Fathom API is also only in early access. Do not use this package in your production environment (yet).

# Laravel Fathom

[![Packagist Version](https://img.shields.io/packagist/v/marcreichel/laravel-fathom)](https://packagist.org/packages/marcreichel/laravel-fathom)
[![Packagist Downloads](https://img.shields.io/packagist/dt/marcreichel/laravel-fathom)](https://packagist.org/packages/marcreichel/laravel-fathom)
[![tests](https://github.com/marcreichel/laravel-fathom/actions/workflows/tests.yml/badge.svg?event=push)](https://github.com/marcreichel/laravel-fathom/actions/workflows/tests.yml)
[![CodeQuality](https://github.com/marcreichel/laravel-fathom/actions/workflows/code-quality.yml/badge.svg?event=push)](https://github.com/marcreichel/laravel-fathom/actions/workflows/code-quality.yml)
[![CodeFactor](https://www.codefactor.io/repository/github/marcreichel/laravel-fathom/badge)](https://www.codefactor.io/repository/github/marcreichel/laravel-fathom)
[![codecov](https://codecov.io/gh/marcreichel/laravel-fathom/branch/main/graph/badge.svg?token=BKK8L3RMYJ)](https://codecov.io/gh/marcreichel/laravel-fathom)
[![GitHub](https://img.shields.io/github/license/marcreichel/laravel-fathom)](https://packagist.org/packages/marcreichel/laravel-fathom)
[![Gitmoji](https://img.shields.io/badge/gitmoji-%20😜%20😍-FFDD67.svg)](https://gitmoji.dev)

This is an unofficial Laravel wrapper for the [Fathom Analytics](https://usefathom.com/ref/SILMHC) API and provides a
neat little Blade component for the Fathom script tag including some helpful configurations.

[![Fathom Analytics](art/fathom-banner.png)](https://usefathom.com/ref/SILMHC)

## Installation

You can install this package via composer:

```bash
composer require marcreichel/laravel-fathom
```

The package will automatically register its service provider.

To publish the config file to `config/fathom.php` run:

```bash
php artisan vendor:publish --tag=fathom-config
```

## Documentation

You will find the full documentation on [the dedicated documentation site](https://marcreichel.dev/docs/laravel-fathom).

## Testing

Run the tests with:

```bash
composer test
```

## Roadmap

- Improve documentation

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Marc Reichel](https://github.com/marcreichel)
- [All Contributors](https://github.com/marcreichel/laravel-fathom/contributors)

## License

[MIT](https://choosealicense.com/licenses/mit/)
