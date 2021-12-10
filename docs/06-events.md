# Events

## List Events

```php
// torchlight! {"lineNumbers": false}
use MarcReichel\LaravelFathom\Fathom;

Fathom::site('CDBUGS')->events()->get();
```

### Limit the results

```php
// torchlight! {"lineNumbers": false}
use MarcReichel\LaravelFathom\Fathom;

Fathom::site('CDBUGS')->events()->limit(5)->get();
```

### (Cursor) Pagination

```php
// torchlight! {"lineNumbers": false}
use MarcReichel\LaravelFathom\Fathom;

Fathom::site('CDBUGS')
    ->events()
    ->after('signed-up-to-newsletter')
    ->get();
Fathom::site('CDBUGS')
    ->events()
    ->before('signed-up-to-newsletter')
    ->get();
```

## Get Event

```php
// torchlight! {"lineNumbers": false}
use MarcReichel\LaravelFathom\Fathom;

Fathom::site('CDBUGS')
    ->event('signed-up-to-newsletter')
    ->get();
```

## Create Event

```php
// torchlight! {"lineNumbers": false}
use MarcReichel\LaravelFathom\Fathom;

Fathom::site('CDBUGS')
    ->events()
    ->create([
        'name' => 'Purchase early access',
    ]);
```

## Update Event

```php
// torchlight! {"lineNumbers": false}
use MarcReichel\LaravelFathom\Fathom;

Fathom::site('CDBUGS')
    ->event('purchase-early-access')
    ->update([
        'name' => 'Purchase Early Access (live)',
    ]);
```

## Wipe Event

```php
// torchlight! {"lineNumbers": false}
use MarcReichel\LaravelFathom\Fathom;

Fathom::site('CDBUGS')
    ->event('purchase-early-access')
    ->wipe();
```

## Delete Event

```php
// torchlight! {"lineNumbers": false}
use MarcReichel\LaravelFathom\Fathom;

Fathom::site('CDBUGS')
    ->event('purchase-early-access')
    ->delete();
```

## Aggregation

```php
// torchlight! {"lineNumbers": false}
use MarcReichel\LaravelFathom\Fathom;

Fathom::site('CDBUGS')
    ->event('signed-up-for-newsletter')
    ->aggregate(['visits'])
    ->groupByDay()
    ->groupByField('referrer_hostname')
    ->orderBy('visits', 'desc')
    ->timezone('Europe/Berlin')
    ->limit(200)
    ->where('pathname', 'is', '/pricing')
    ->where('pathname', 'is not', '/login')
    ->get();
```
