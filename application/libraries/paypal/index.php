<?php

defined('DS') or define('DS', DIRECTORY_SEPARATOR);

set_include_path(dirname(__FILE__) . DS . 'lib' . DS . 'PayPal' . ';' . get_include_path());

$id = 'Ae0_2RA_OwVGTDub8KxEnUF1nZ-FJtfas8zuQr86SB5kw1A_v9vuUWVWuQYs';
$sec = 'EEbAFBAXkaJTL1No9yiP_-aBJRMhfPI0Vr-VOqIpq5tUqZvwqzKd1GXXJDoG';

use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

