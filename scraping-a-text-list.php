<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;


$products = [];
$discounted_products = [];
$best_price_products = [];

$client = new Client();

$response = $client->request('GET', 'http://testing-ground.scraping.pro/textlist');

$body = $response->getBody()->getContents();

$crawler = new Crawler($body);


$filter = $crawler->filter('#case_textlist')->html();


$expStr=explode("------------------------",$filter);
$resultString=$expStr[1];



$resultString = trim($resultString);
$resultString = trim($resultString, "<br>");
$resultString = trim($resultString, "\r\n");  
$lines = explode("<br>", $resultString);

echo "<pre>";
echo "All the text lines:<br/>";
print_r($lines);
echo "</pre>";

$cities_without_notes = [];
$cities_with_notes = [];
$bold_cities = [];

foreach($lines as $line)
{	
	if(substr( $line, 0, 1 ) === "(")
	{	
		$cities_with_notes[] = $line;
		continue;
	}
	if(substr( $line, 0, 7 ) === "change:")
	{	
		$cities_with_notes[] = $line;
		continue;
	}

	if(substr( $line, 0, 3 ) === "<b>")
	{
		$bold_cities[] = $line;
	}

	$cities_without_notes[] = $line;
	$cities_with_notes[] = $line;
}


echo "<br/>";

echo "Cities with population without notes:<br/>";
echo "<pre>";
print_r($cities_without_notes);
echo "</pre>";
echo "<br/>";

echo "Cities with population and notes:<br/>";
echo "<pre>";
print_r($cities_with_notes);
echo "</pre>";
echo "<br/>";

echo "Cities marked with bold:<br/>";
echo "<pre>";
print_r($bold_cities);
echo "</pre>";