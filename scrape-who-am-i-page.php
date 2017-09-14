<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;


$products = [];
$discounted_products = [];
$best_price_products = [];

$client = new Client();

$response = $client->request('GET', 'http://testing-ground.scraping.pro/whoami',[
	'headers' => [
		'Referer' => 'http://testing-ground.scraping.pro'
	]
]);

$_SERVER['HTTP_REFERER'] = "Facebook";

$body = $response->getBody()->getContents();

$crawler = new Crawler($body);

$filter = $crawler->filter('#case_whoami')->html();

$filter = trim(strip_tags($filter));

$details = explode("\n", $filter);


foreach($details as $index => $detail)
{
	if($index % 2 == 0)
		echo $detail.": ";
	else
		echo $detail."<br/>";
}