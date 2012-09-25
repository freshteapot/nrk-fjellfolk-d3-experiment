<?php
$dom = new DOMDocument();
$dom->load("./output.xml");

$xpath = new DOMXpath($dom);

$query = "(//lst[@name='facet_fields'])/lst[@name='word_s']//*";

$nodes = $xpath->query($query);

$items = array();
foreach ($nodes as $node ) {
	$items[] = array(
		"name" => $xpath->evaluate("string(@name)", $node),
		"total" => $xpath->evaluate("string(.)", $node),
	);
}
file_put_contents("./words.with.totals", json_encode($items));
