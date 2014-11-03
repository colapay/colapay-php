<?php

require_once( dirname( __FILE__ ) . '/../lib/Colapay.php' );

$_API_KEY = "FHHbu6RHREZq_h1VBlrIGznq38c";
$_API_SECRET = "GFMEd5Hfo8Uv_--c9vVe9ksk38HOhz5bLD4Aqe1q";

// set api using environment, default 'production'
Colapay::set_api_env( 'development' );

// get Colapay api instance to use
$colapay = Colapay::key_secret_mode( $_API_KEY, $_API_SECRET );

// prepare parameters for create invoice
$name = "first invoice中文能搞定吗";
echo mb_detect_encoding( $name ) . '<br><br>';
$price = "100";
$currency = "cny";
$merchant = "0123456789";
$options = array(
        "custom_id" => "10000",
        "callback_url" => "https://www.baidu.com",
        "redirect_url" => "https://www.qq.com"
        );

// create invoice
$response = $colapay->create_invoice( $name, $price, $currency, $merchant, $options );
var_dump( $response );
echo '<br><br>';
if ( $response->success ) {
    echo 'invoice_id: ' . $response->invoice->id;
    echo '<br><br>';
    echo 'invoice_status: ' . $colapay->get_invoice_status( $response->invoice->id )->invoice->status;
    echo '<br><br>';
} else {
    echo "create invoice failed";
    echo '<br><br>';
}

// create item
$name = 'first item';
$response = $colapay->create_item( $name, $price, $currency );
if ( $response->success ) {
    var_dump( $response );
    echo '<br><br>';
} else {
    echo 'create item failed';
    echo '<br><br>';
}

