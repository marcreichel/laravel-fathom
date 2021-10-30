> **Please note**: This package is still a work in progress and the Fathom API is also only in early access. Do not use this package in your production environment (yet).

# Laravel Fathom

[![Packagist Version](https://img.shields.io/packagist/v/marcreichel/laravel-fathom)](https://packagist.org/packages/marcreichel/laravel-fathom)
[![Packagist Downloads](https://img.shields.io/packagist/dt/marcreichel/laravel-fathom)](https://packagist.org/packages/marcreichel/laravel-fathom)
[![CodeFactor](https://www.codefactor.io/repository/github/marcreichel/laravel-fathom/badge)](https://www.codefactor.io/repository/github/marcreichel/laravel-fathom)
[![GitHub](https://img.shields.io/github/license/marcreichel/laravel-fathom)](https://packagist.org/packages/marcreichel/laravel-fathom)
[![Gitmoji](https://img.shields.io/badge/gitmoji-%20😜%20😍-FFDD67.svg)](https://gitmoji.dev)

This is a Laravel wrapper for the [Fathom Analytics](https://usefathom.com/ref/SILMHC) API.

[![Fathom Analytics](art/fathom-banner.png)](https://usefathom.com/ref/SILMHC)

## Installation

*coming soon...*

## Usage

### Get Account

```php
use MarcReichel\LaravelFathom\Fathom;

Fathom::account()->get();
```

### List Sites

```php
use MarcReichel\LaravelFathom\Fathom;

Fathom::sites()->all();
```

### Get Site

```php
use MarcReichel\LaravelFathom\Fathom;

Fathom::site('CDBUGS')->get();
```

### Create Site

```php
use MarcReichel\LaravelFathom\Fathom;

Fathom::sites()->create('Acme Inc');
```

### Update Site

```php
use MarcReichel\LaravelFathom\Fathom;

Fathom::site('CDBUGS')->update([
    'name' => 'Acme Holdings Inc',
    'sharing' => 'private',
    'share_password' => 'the-jean-genie',
]);
```

### Wipe Site

```php
use MarcReichel\LaravelFathom\Fathom;

Fathom::site('CDBUGS')->wipe();
```

### Delete Site

```php
use MarcReichel\LaravelFathom\Fathom;

Fathom::site('CDBUGS')->delete();
```

### List Events

```php
use MarcReichel\LaravelFathom\Fathom;

Fathom::site('CDBUGS')->events()->all();
```

### Get Event

```php
use MarcReichel\LaravelFathom\Fathom;

Fathom::site('CDBUGS')
    ->event('signed-up-to-newsletter')
    ->get();
```

### Create Event

```php
use MarcReichel\LaravelFathom\Fathom;

Fathom::site('CDBUGS')
    ->events()
    ->create('Purchase early access');
```

### Update Event

```php
use MarcReichel\LaravelFathom\Fathom;

Fathom::site('CDBUGS')
    ->event('purchase-early-access')
    ->update([
        'name' => 'Purchase Early Access (live)',
    ]);
```

### Wipe event

```php
use MarcReichel\LaravelFathom\Fathom;

Fathom::site('CDBUGS')
    ->event('purchase-early-access')
    ->wipe();
```

### Delete event

```php
use MarcReichel\LaravelFathom\Fathom;

Fathom::site('CDBUGS')
    ->event('purchase-early-access')
    ->delete();
```

### Aggregation

*coming soon...*

### Current visitors

```php
use MarcReichel\LaravelFathom\Fathom;

Fathom::site('CDBUGS')
    ->currentVisitors();
```

## Roadmap

- Implement aggregation endpoint
- Implement cursor pagination
- Write tests
- Improve documentation

## Contribution

Pull requests are welcome :)
