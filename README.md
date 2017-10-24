# iCaptious Framework

* Project page: http://developers.icaptious.com/iCaptious/
* Repository: https://github.com/neomorina/iCaptious
* Version: 1.0.0
* License: MIT, see [LICENSE](LICENSE)

## Description

iCaptious is an Open Source Framework built for PHP, which makes prgramming easier.
iCaptious provides plugins for third-party integration with itself.

## Installation

### Direct download (no Composer)

If you wish to install the framework manually (i.e. without Composer), then you
can use the links on the main project page to either clone the repo or download
the [ZIP file](https://github.com/neomorina/iCaptious/archive/master.zip). For
convenience, an autoloader script is provided in `autoload.php` which you
can require into your script instead of Composer's `vendor/autoload.php`. For
example:

```php
Require('/path/to/iCaptious/autoload.php');

use iCaptious\Core\Route;

Route::load("/", function(){
   echo "Hello World!";
});
```

## Usage

First, require the autoload file `autoload.php`

iCaptious Routing library can do many requests as Redirect, Secure SSL Connection, process get requests etc.
For example:
```php
<?php
use iCaptious\Core\Route;

// run this function if the domain was requested
Route::Domain("icaptious.com", function(){ 
  // Secure the connection by default if not secured already
  Route::Secure();
  echo "<h1>Welcome to icaptious.com :)</h1>";
});
```

## Contributing

We are an open Community and appriciate your contributions via GitHub Pull Requests.
