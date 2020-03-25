<?php
#iso 4217
function get_iso_codes() 
{
    return [
        978 => 'EUR',
        972 => 'TJS',
        643 => 'RUB',
        980 => 'UAH',
        756 => 'CHF',
        840 => 'USD',
        398 => 'KZT'
    ];
}

function get_qiwi_currencies_list()
{
    $iso = get_iso_codes();
    $qiwi = 'https://edge.qiwi.com/sinap/crossRates';

    $qiwi_normalized = [];

    $qiwi_fiat = json_decode(file_get_contents($qiwi));

    # Генерируем читаемый код с валютами
    foreach ($qiwi_fiat->result as $rates) {
        if (!in_array($iso[$rates->to], $qiwi_normalized)) {
            $qiwi_normalized[] = $iso[$rates->to];
        }
    }
    $result = [
        'type' => 'fiat',
        'currencies' => $qiwi_normalized
    ];

    return $result;
}

function get_qiwi_buysell_list($from)
{
    $available = get_qiwi_currencies_list();
    $prices = get_qiwi_currencies_prices($from, $available['currencies']);
    $result = [];
    foreach ($prices as $item) {
        $amount = $item['price'] < 2 ? 1 : 100;
        $result[] = [
            'from' => $item['from'],
            'to' => $item['to'],
            'amount' => $amount,
            'price' => (float)number_format($amount / $item['price'], 2, '.', ''),
        ];
    }
    return $result;
}

function get_qiwi_currencies_prices($from, $to)
{
    $qiwi = 'https://edge.qiwi.com/sinap/crossRates';

    $iso = get_iso_codes();

    $result = [];

    $qiwi_fiat = json_decode(file_get_contents($qiwi));

    # Генерируем читаемый код с валютами
    foreach ($qiwi_fiat->result as $rate) {
        if ($from == $iso[$rate->to] and in_array($iso[$rate->from], $to)) {
            $result[] = [
                'from' => $iso[$rate->to],
                'to' => $iso[$rate->from],
                'price' => $rate->rate
            ];
        }
    }
    return $result;
}

function get_crypto_currencies_list()
{
    $cryptocompare = 'https://min-api.cryptocompare.com/data/top/totalvolfull?limit=10&tsym=USD';
    $cryptocompare_top = json_decode(file_get_contents($cryptocompare));
    $coins = [];
    foreach ($cryptocompare_top->Data as $coin) $coins[] = $coin->CoinInfo->Name;
    $result = [
        'type' => 'crypto',
        'currencies' => $coins
    ];

    return $result;
}

function get_crypto_currencies_prices($from, $to)
{
    $to = implode(',', $to);
    $cryptocompare = 'https://min-api.cryptocompare.com/data/pricemulti?fsyms=' . $from . '&tsyms=' . $to;
    $cryptocompare_prices = json_decode(file_get_contents($cryptocompare));
    $result = [];
    foreach ($cryptocompare_prices as $from => $to_list) {
        foreach ($to_list as $to => $price) {
            $result[] = [
                'from' => $from,
                'to' => $to,
                'price' => $price
            ];
        }
    }
    return $result;
}

