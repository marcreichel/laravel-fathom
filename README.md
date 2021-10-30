> **Please note**: This package is still a work in progress and the Fathom API is also only in early access. Do not use this package in your production environment (yet).

# Laravel Fathom

This is a Laravel wrapper for the [Fathom Analytics](https://usefathom.com/ref/SILMHC) API.

[![Fathom Analytics](art/fathom-banner.png)](https://usefathom.com/ref/SILMHC)

## Installation

*coming soon...*

## Usage

### Get Account

```php
use MarcReichel\LaravelFathom\Fathom;

$account = Fathom::account();
```

### List Sites

```php
use MarcReichel\LaravelFathom\Fathom;

$sites = Fathom::sites();
```

### Get Site

```php
use MarcReichel\LaravelFathom\Fathom;

$site = Fathom::site('CDBUGS');
```

### Create Site

```php
use MarcReichel\LaravelFathom\Fathom;

$site = Fathom::createSite('Acme Inc');
```

### Update Site

```php
use MarcReichel\LaravelFathom\Fathom;

$site = Fathom::updateSite('CDBUGS', [
    'name' => 'Acme Holdings Inc',
    'sharing' => 'private',
    'share_password' => 'the-jean-genie',
]);
```

### Wipe Site

```php
use MarcReichel\LaravelFathom\Fathom;

$site = Fathom::wipeSite('CDBUGS');
```

### Delete Site

```php
use MarcReichel\LaravelFathom\Fathom;

$site = Fathom::deleteSite('CDBUGS');
```

### List Events

```php
use MarcReichel\LaravelFathom\Fathom;

$site = Fathom::events('CDBUGS');
```

### Get Event

```php
use MarcReichel\LaravelFathom\Fathom;

$site = Fathom::event('CDBUGS', 'signed-up-to-newsletter');
```

### Create Event

```php
use MarcReichel\LaravelFathom\Fathom;

$site = Fathom::createEvent('CDBUGS', 'Purchase early access');
```

### Update Event

```php
use MarcReichel\LaravelFathom\Fathom;

$site = Fathom::updateEvent(
    'CDBUGS', // site id
    'purchase-early-access', // event id
    'Purchase Early Access (live)', // new event name
);
```

### Wipe event

```php
use MarcReichel\LaravelFathom\Fathom;

$site = Fathom::wipeEvent('CDBUGS', 'purchase-early-access');
```

### Delete event

```php
use MarcReichel\LaravelFathom\Fathom;

$site = Fathom::deleteEvent('CDBUGS', 'purchase-early-access');
```

### Aggregation

*coming soon...*

### Current visitors

```php
use MarcReichel\LaravelFathom\Fathom;

$site = Fathom::currentVisitors('CDBUGS', true);
```

## Roadmap

- Implement aggregation endpoint
- Write tests
- Improve documentation

## Contribution

Pull requests are welcome :)
