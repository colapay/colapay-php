<?php

require_once( dirname( __FILE__ ) . '/simpletest/autorun.php' );
require_once( dirname( __FILE__ ) . '/../lib/Colapay.php' );

$_API_KEY = 'api_key';
$_API_SECRET = 'api_secret';

Mock::generate( "Colapay_Requestor" );

class TestOfColapay extends UnitTestCase {

    function testCreateItem() {
        $requestor = new MockColapay_Requestor();
        $requestor->returns( 'do_curl_request', array( "status_code" => 200, "body" => '
        {
            "success": true,
            "item": {
                "id": "542e0298e29c164845d57e5a",
                "name": "first item",
                "price": 100,
                "currency": "cny",
                "merchant": "54290bde8c068a0000b1ddd5",
                "user": "54293188b1fbbe4d9942af70"
            }
        }' ) );

        $colapay = Colapay::key_secret_mode( $_API_KEY, $_API_SECRET );
        $colapay->set_requestor( $requestor );
        $response = $colapay->create_item( "first item", 100, "cny" );
        $this->assertEqual( $response->item->id, '542e0298e29c164845d57e5a');
    }

    function testCreateInvoice() {
        $requestor = new MockColapay_Requestor();
        $requestor->returns( 'do_curl_request', array( "status_code" => 200, "body" => '
        {
            "success": true,
            "invoice": {
                "id": "542e10f4e29c164845d57e5c",
                "status": "created",
                "merchant": "54290bde8c068a0000b1ddd5",
                "base_currency": {
                    "price": 100,
                    "currency": "cny"
                },
                "callback_url": "https://www.baidu.com",
                "redirect_url": "https://www.qq.com"
            }
        }' ) );

        $colapay = Colapay::key_secret_mode( $_API_KEY, $_API_SECRET );
        $colapay->set_requestor( $requestor );
        $options = array(
                "callback_url" => "https://www.baidu.com",
                "redirect_url" => "https://www.qq.com"
                );
        $response = $colapay->create_invoice( "first invoice", 100, "cny", $options );
        $this->assertEqual( $response->invoice->id, '542e10f4e29c164845d57e5c');
        $this->assertEqual( $response->invoice->status, 'created' );
        $this->assertEqual( $response->invoice->callback_url, 'https://www.baidu.com' );
        $this->assertEqual( $response->invoice->redirect_url, 'https://www.qq.com' );
        $this->assertEqual( $response->invoice->base_currency->price, 100 );
        $this->assertEqual( $response->invoice->base_currency->currency, 'cny' );
        $this->assertEqual( $response->invoice->merchant, '54290bde8c068a0000b1ddd5' );
    }
}

