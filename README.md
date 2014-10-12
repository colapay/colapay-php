Colapay PHP client library
===========

## Quick Start Guide

This guide walks through the steps of using this PHP library.

* Get the latest code

    git clone https://github.com/bobofzhang/colapay-php

* Get an API Key and Secret by [creating an account on Colapay](https://colapay.com).

* Add the following to your PHP script:

    require_once("/path/to/colapay-php/lib/Colapay.php");

* Use the API Key and Secret to create an instance of the client:

```php
$colapay = Colapay::key_secret_mode( $_ENV['API_KEY'], $_ENV['API_SECRET'] );
```

* Use the client to create an invoice by the following code:

```php
$name = "the first invoice";
$price = "100";
$currency = "cny";
$options = array(
        "callback_url" => "some url on your site to accept & process information sent from Colapay",
        "redirect_url" => "some url on your site to where the customer will be redirected when the invoice is paid"
        );

$response = $colapay->create_invoice( $name, $price, $currency, $options );
```

The return value of create_invoice is a JSON object. You can get the invoice id by

```php
$id = $response->invoice->id;
```

And you can get the status of existing invoice by:

```php
$status = $colapay->get_invoice_status( $invoice_id );
```

That's all you need to use this PHP library to create an invoice, get invoice status etc.
There is a complete key secret example in example dir.

For more API interface and parameters explanation, please refer to
[the complete Colapay API](https://colapay.com/api/v1).

## Testing

If you'd like to contribute code or modify this library, you can run the test suite
by executing `/path/to/colapay-php/test/Colapay_ut.php` in a web browser or on the
command line with `php`.

First, init the submodule from the root of the repo using the following commands:

    git submodule init
    git submodule sync
    git submodule update
