<?php
ini_set('memory_limit','512M');

$unigrams = array();
$bigrams = array();

$filecontent = file_get_contents('english_data.txt');
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

$file_name = "english_unigramy.txt";
$file_uni = fopen($file_name, 'a') or die("can't open file");

foreach($unigrams as $key => $value) {
	$text = $key." ".$value."\n";
	fwrite($file_uni, $text);
}
fclose($file_uni);

echo "slovni unigramy safe and sound";

for($k = 0; $k < count($words)-2; $k++) {
	$w = $words[$k].' '.$words[$k+1];
	
	if(isset($bigrams[$w]))
		$bigrams[$w]++;
	else
		$bigrams[$w] = 1;
}

arsort($bigrams); // sort cetnost desc
$file_name = "english_bigramy.txt";
$file_bi = fopen($file_name, 'a') or die("can't open file");

foreach($bigrams as $key => $value) {
	$text = $key." ".$value."\n";
	fwrite($file_bi, $text);
}
fclose($file_bi);


echo "slovni bigramy safe and sound";


// vypsaný unigramy, bigramy podle četností
// bigramový model a jeho perplexita (číslo 2 na podmíněný něco)
// podmíněná entropie dat (každýho datovýho korpusu)
// seřadit bigramy podle vzájemné informace
?>