<?php

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

//nacteni unigramu
$unigrams = get_full_clean_array(1);

$handle = fopen("czech_char_unigramy.txt", "r");
if ($handle) {
    
	while (($line = fgets($handle)) !== false) {
        $line_vals = explode(' ', $line);
		$unigrams[$line_vals[0]] = floatval($line_vals[1]);
    }

    fclose($handle);
} else {
	echo 'fail';
} 

//nacteni bigarmu
$bigrams = get_full_clean_array(2);
$handle = fopen("czech_char_bigramy.txt", "r");
if ($handle) {
    
	while (($line = fgets($handle)) !== false) {
        $line_vals = explode(' ', $line);
		$line_vals[0] = explode(';', $line_vals[0]);
		$bigrams[$line_vals[0][0]][$line_vals[0][1]] = (float)$line_vals[1];
    }

    fclose($handle);
} else {
	echo 'fail';
} 

//nacteni trigarmu
$trigrams = get_full_clean_array(3);
$handle = fopen("czech_char_trigramy.txt", "r");
if ($handle) {
    
	while (($line = fgets($handle)) !== false) {
        $line_vals = explode(' ', $line);
		$line_vals[0] = explode(';', $line_vals[0]);
		$trigrams[$line_vals[0][0]][$line_vals[0][1]][$line_vals[0][2]] = (float)$line_vals[1];
    }

    fclose($handle);
} else {
	echo 'fail';
}

