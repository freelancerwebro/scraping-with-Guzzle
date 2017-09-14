<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;


$client = new Client();

$response = $client->request('GET', 'http://testing-ground.scraping.pro/invalid');

$body = $response->getBody()->getContents();

$crawler = new Crawler($body);

$filter = $crawler->filter('#case_invalid')->html();

$tags = trim(strip_tags($filter));

$tagLines = explode("\n", $tags);

$tagLines = array_filter($tagLines);

foreach($tagLines as $line)
{
	echo $line."<br/>";
}