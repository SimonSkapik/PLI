<?php
ini_set('memory_limit','512M');

$unigrams = array();

$filecontent = file_get_contents('czech_data.txt');
$words = preg_split('/[\s]+/', $filecontent, -1, PREG_SPLIT_NO_EMPTY);

foreach($words as $val) {
	if(isset($unigrams[$val]))
		$unigrams[$val]++;
	else
		$unigrams[$val] = 1;
}

// ksort($unigrams); // sort slovo asc
// krsort($unigrams); // sort slovo desc
// asort($unigrams); // sort cetnost asc
arsort($unigrams); // sort cetnost desc

$file_name = "czech_unigramy.txt";
$file_uni = fopen($file_name, 'a') or die("can't open file");

foreach($unigrams as $key => $value) {
	$text = $key." ".$value."\n";
	fwrite($file_uni, $text);
}
fclose($file_uni);

echo "safe and sound";


// vypsaný unigramy, bigramy podle četností
// bigramový model a jeho perplexita (číslo 2 na podmíněný něco)
// podmíněná entropie dat (každýho datovýho korpusu)
// seřadit bigramy podle vzájemné informace
?>