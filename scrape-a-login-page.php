<?php

require 'vendor/autoload.php';

$client = new \GuzzleHttp\Client();
$cookieJar = new \GuzzleHttp\Cookie\CookieJar();


$response = $client->post('http://testing-ground.scraping.pro/login?mode=login', [
    'form_params' => [
        'usr' => 'admin',
        'pwd' => '12345',
    ],
    'headers' => [
    	'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36'
    ],
    'allow_redirects' => true,
    'cookies' => $cookieJar
]
);

$response2 = $client->get('http://testing-ground.scraping.pro/login?mode=welcome', [
	'allow_redirects' => true,'cookies' => $cookieJar
]);

echo $response2->getBody()->getContents();