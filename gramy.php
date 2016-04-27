<?php
ini_set('memory_limit','512M');

function get_full_clean_array($dim){
	$arr = array('a'=>0,
				'b'=>0,
				'c'=>0,
				'd'=>0,
				'e'=>0,
				'f'=>0,
				'g'=>0,
				'h'=>0,
				'i'=>0,
				'j'=>0,
				'k'=>0,
				'l'=>0,
				'm'=>0,
				'n'=>0,
				'o'=>0,
				'p'=>0,
				'q'=>0,
				'r'=>0,
				's'=>0,
				't'=>0,
				'u'=>0,
				'v'=>0,
				'w'=>0,
				'x'=>0,
				'y'=>0,
				'z'=>0,
	);
	if($dim > 1){
		foreach($arr as $key => $value){
			$arr[$key] = get_full_clean_array(($dim-1));
		}
	}
	return $arr;
}

$unigrams = get_full_clean_array(1);
/*
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

echo "slovni unigramy safe and sound";

*/

//znakove unigramy
$filecontent = file_get_contents('czech_data.txt');

$strlen = strlen( $filecontent );
$letters = 0;
for( $i = 0; $i <= $strlen; $i++ ) {
    $char = substr( $filecontent, $i, 1 );
	if( $char != ' ' ) {
		$letters++;
		if(isset($unigrams[$char]))
			$unigrams[$char]++;
		else
			$unigrams[$char] = 1;
	}
}

$file_name = "czech_char_unigramy.txt";
$file_uni = fopen($file_name, 'w') or die("can't open file");

foreach($unigrams as $key => $value) {
	if($key != '0'){
		$text = $key." ".($value/$letters)."\n";
		fwrite($file_uni, $text);
	}
}
fclose($file_uni);

echo "znakove unigramy safe and sound".PHP_EOL;

//znakove bigramy
$bigrams = get_full_clean_array(2);

$strlen = strlen( $filecontent );
$pairs = 0;
$char1 = ' ';
for( $i = 0; $i <= $strlen; $i++ ) {
    $char2 = substr( $filecontent, $i, 1 );
	if( $char1 != ' ' && $char2 != ' ' && $char1 != '0' && $char2 != '0' ) {
		$pairs++;
		$bigrams[$char1][$char2]++;
	}
	$char1 = $char2;
}

$file_name = "czech_char_bigramy.txt";
$file_uni = fopen($file_name, 'w') or die("can't open file");

foreach($bigrams as $key1 => $value1) {
	if($key1 != '0'){
		foreach($value1 as $key2 => $value2) {
			if($key2 != '0'){
				$text = $key1.';'.$key2." ".($value2/$pairs)."\n";
				fwrite($file_uni, $text);
			}
		}
	}
}
fclose($file_uni);

echo "znakove bigramy safe and sound".PHP_EOL;

//znakove trigramy
$trigrams = get_full_clean_array(3);

$strlen = strlen( $filecontent );
$triples = 0;
$char1 = ' ';
$char2 = ' ';
for( $i = 0; $i <= $strlen; $i++ ) {
    $char3 = substr( $filecontent, $i, 1 );
	if( $char1 != ' ' && $char2 != ' ' && $char3 != ' ' && $char1 != '0' && $char2 != '0' && $char3 != '0' ) {
		$triples++;
		$trigrams[$char1][$char2][$char3]++;
	}
	$char1 = $char2;
	$char2 = $char3;
}

$file_name = "czech_char_trigramy.txt";
$file_uni = fopen($file_name, 'w') or die("can't open file");

foreach($trigrams as $key1 => $value1) {
	if($key1 != '0'){
		foreach($value1 as $key2 => $value2) {
			if($key2 != '0'){
				foreach($value2 as $key3 => $value3) {
					if($key3 != '0'){
						$text = $key1.';'.$key2.';'.$key3." ".($value3/$triples)."\n";
						fwrite($file_uni, $text);
					}
				}
			}
		}
	}
}
fclose($file_uni);

echo "znakove trigramy safe and sound".PHP_EOL;
// vypsaný unigramy, bigramy podle četností
// bigramový model a jeho perplexita (číslo 2 na podmíněný něco)
// podmíněná entropie dat (každýho datovýho korpusu)
// seřadit bigramy podle vzájemné informace
?>