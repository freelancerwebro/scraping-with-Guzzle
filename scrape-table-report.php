<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

$client = new Client();

$response = $client->request('GET', 'http://testing-ground.scraping.pro/table');

$body = $response->getBody()->getContents();

$crawler = new Crawler($body);

$products = [];


$table = $crawler->filter('#case_table > table')->filter('tr')->each(function ($tr, $i) {
    return $tr->filter('th')->each(function ($td, $i) {
        return trim($td->text());
    });
});

$totalProducts = count($table[0]) - 2;


$table = $crawler->filter('#case_table > table')->filter('tr')->each(function ($tr, $i) {
    return $tr->filter('td')->each(function ($td, $i) {

        	return trim($td->text());
    });
});

array_shift($table);

print_r($table);

$year = null;
$quarter = null;
$totalSizeOfRow = 2 * $totalProducts + 2;

foreach($table as $row)
{
	if(empty($row))
	{
		continue;
	}

	if(count($row) == 1 && !empty($row[0]))
	{
		$products[$row[0]] = [];
		$year = $row[0];
	}

	if(preg_match("/Q[1-4]/", $row[0]))
	{
		$products[$year][$row[0]] = [];	
		$quarter = $row[0];		

		$products[$year][$quarter] = prepareRow($year, $quarter, $row);
	}

}


function prepareRow($year, $quarter, $row)
{
	global $totalSizeOfRow;
	global $totalProducts; 
	$quarter = $row[0];
	$total = $row[sizeof($row)-1];
	$result = ['total' => $total];

	if(sizeof($row) == $totalSizeOfRow)
	{
		
		$productNo = 1;
		for($i = 1; $i < sizeof($row); $i++)
		{	
			if($productNo > $totalProducts)
				continue;

			$result['product_'.$productNo]['items'] = $row[$i];
			$result['product_'.$productNo]['amount'] = $row[$i+1];

			if($i % 2 == 1)
				$productNo++;
		}
	}



	return $result;
}

print_r($products);

