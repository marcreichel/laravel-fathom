# Sites

## List Sites

Return a list of all sites your API key owns. Sites are sorted by `created_at` ascending.

```php
// torchlight! {"lineNumbers": false}
use MarcReichel\LaravelFathom\Fathom;

Fathom::sites()->get();
```

### Limit the results

```php
// torchlight! {"lineNumbers": false}
use MarcReichel\LaravelFathom\Fathom;

Fathom::sites()->limit(5)->get();
```

### (Cursor) Pagination

```php
// torchlight! {"lineNumbers": false}
use MarcReichel\LaravelFathom\Fathom;

Fathom::sites()->after('CDBUGS')->get();
Fathom::sites()->before('CDBUGS')->get();
```

## Get Site

```php
// torchlight! {"lineNumbers": false}
use MarcReichel\LaravelFathom\Fathom;

Fathom::site('CDBUGS')->get();
```

## Create Site

```php
// torchlight! {"lineNumbers": false}
use MarcReichel\LaravelFathom\Fathom;

Fathom::sites()->create([
    'name' => 'Acme Inc', // required
    'sharing' => 'private', // optional, one of 'none', 'private' or 'public'
    'share_password' => 'the-jean-genie', // optional
]);
```

## Update Site

```php
// torchlight! {"lineNumbers": false}
use MarcReichel\LaravelFathom\Fathom;

Fathom::site('CDBUGS')->update([
    'name' => 'Acme Holdings Inc',
    'sharing' => 'private',
    'share_password' => 'the-jean-genie',
]);
```

## Wipe Site

Wipe all pageviews & event completions from a website. This would typically be used when you want to cmpletely reset
statistics or right before you launch a website (to remove test data).

```php
// torchlight! {"lineNumbers": false}
use MarcReichel\LaravelFathom\Fathom;

Fathom::site('CDBUGS')->wipe();
```

## Delete Site

Delete a site (careful, you can't undo this).

```php
// torchlight! {"lineNumbers": false}
use MarcReichel\LaravelFathom\Fathom;

Fathom::site('CDBUGS')->delete();
```

## Aggregation

```php
// torchlight! {"lineNumbers": false}
use MarcReichel\LaravelFathom\Fathom;

Fathom::site('CDBUGS')
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

## Current Visitors

```php
// torchlight! {"lineNumbers": false}
use MarcReichel\LaravelFathom\Fathom;

$detailed = false; // Optional

Fathom::site('CDBUGS')
    ->currentVisitors($detailed);
```
