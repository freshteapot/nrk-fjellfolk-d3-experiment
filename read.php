<?php
$type = "fjellfolk.1.4";

$dom = new DOMDocument();
$dom->load("./fjellfolk.1.4.xml");

$rootNamespace = $dom->lookupNamespaceUri($dom->namespaceURI); 
$xpath = new DOMXpath($dom);
$xpath->registerNamespace("tt", $rootNamespace);

$query = "//tt:p[@style='left']";

$nodes = $xpath->query($query);

$words = array();
foreach($nodes as $node) {
	$text = $xpath->evaluate("string(.)", $node) . "\n\n";
	$text = trim($text);
//We will force it all to lower case.
	$text = strtolower($text);
//Let us do some primitive cleaning.
	$text = clean($text);
	$text = replace($text);
	$temp = explode(" ", $text);
	foreach($temp as $word) {
		$word = clean($word);
		if (empty($word) || preg_match("/\d+/",$word)) {
			continue;
		}
		$words[] = $word;
	}
}

function clean($text)
{
	if(empty($text)) {
		return "";
	}
	$text = trim($text, ".!,?\"-");
	$text = trim($text, ".!,?\"-");
	return $text;
}

function replace($text)
{
	$replace = array(
		"?-",
		".",
		",",
		"?",
		"!",
	);
	$text = str_replace($replace, " ", $text);
	return $text;
}
sort($words);
//Get the uniqueWords
$uniqueWords = array_unique($words);

/*
*/
$items = array();
foreach($words as $word) {
	$items[] = array(
		"id" => uniqid("", true),
		"word_s" => $word,
		"type_s" => $type,
	);
}
file_put_contents("./words.json", json_encode($items));
