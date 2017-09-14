<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;


$client = new Client();

$response = $client->request('GET', 'http://testing-ground.scraping.pro/whoami',[
	'headers' => [
		'Referer' => 'http://testing-ground.scraping.pro'
	]
]);

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