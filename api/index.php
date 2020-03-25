<?php
/**
 * Currencies Api
 * @version 0.0.1
 */

require_once __DIR__ . '/vendor/autoload.php'; //ot composera
require_once __DIR__ . '/api.php';

//print_r($_REQUEST);
//die();

$config = [
    'settings' => [
        'displayErrorDetails' => true,

        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
        ],
    ],
];

$app = new Slim\App($config);

/**
 * GET currenciesGet
 * Summary: List of all currencies
 * Notes: Get all currencies
 */
$app->GET('/api/0.0.1/currencies', function ($request, $response, $args) {
    $fiat = get_qiwi_currencies_list();
    $crypto = get_crypto_currencies_list();
    $result = [$fiat, $crypto];
    $response = $response->withJson($result);
    return $response;
});


/**
 * GET currenciesPricesTypeGet
 * Summary: prices of currencies
 * Notes: prices of currencies
 */
$app->GET('/api/0.0.1/currencies/prices/{type}', function ($request, $response, $args) {

    $queryParams = $request->getQueryParams();
    $from = strtoupper($queryParams['from']);
    $to = strtoupper($queryParams['to']);
    $to = explode(',', $to);
    if (count($to) < 1 or $to[0] == '' or !strlen($from)) {
        $response = $response->withStatus(400);
        return $response;
    }
    $currency_type = $args['type'];
    if ($currency_type == 'fiat') {
        $response = $response->withJson(get_qiwi_currencies_prices($from, $to));
    } elseif ($currency_type == 'crypto') {
        $response = $response->withJson(get_crypto_currencies_prices($from, $to));
    } else {
        $response = $response->withStatus(400);
        return $response;
    }
    return $response;
});


/**
 * GET currenciesTypeGet
 * Summary: List of all currencies
 * Notes: Get all currencies
 * Output-Formats: [application/json]
 */
$app->GET('/api/0.0.1/currencies/{type}', function ($request, $response, $args) {

    $currency_type = $args['type'];
    if ($currency_type == 'fiat') {
        $response = $response->withJson(get_qiwi_currencies_list());
    } elseif ($currency_type == 'crypto') {
        $response = $response->withJson(get_crypto_currencies_list());
    } else {
        $response = $response->withStatus(400);
    }
    return $response;
});

$app->GET('/api/0.0.1/currencies/{type}/buysell', function ($request, $response, $args) {
    $queryParams = $request->getQueryParams();
    $from = strtoupper($queryParams['from']);
    if (!strlen($from)) $from = 'RUB';
    $currency_type = $args['type'];
    if ($currency_type == 'fiat') {
        $response = $response->withJson(get_qiwi_buysell_list($from));
    } else {
        $response = $response->withStatus(400);
    }
    return $response;
});


$app->run();
