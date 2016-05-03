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

$unigrams;
$bigrams;
$trigrams;

function load_data($lang){
	global $unigrams, $bigrams, $trigrams;

	//nacteni unigramu
	$unigrams = get_full_clean_array(1);

	$handle = fopen($lang."_char_unigramy.txt", "r");
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
	$handle = fopen($lang."_char_bigramy.txt", "r");
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
	$handle = fopen($lang."_char_trigramy.txt", "r");
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
}

function get_score($text, $lang){
	global $unigrams, $bigrams, $trigrams;
	load_data($lang);
	$strlen = strlen( $text );
	$parts = array();
	$char1 = ' ';
	$char2 = ' ';
	$score = 1;
	$counter = 0;
	for( $i = 0; $i <= $strlen; $i++ ) {
		$char3 = substr( $text, $i, 1 );
		if($char3 != ' ' && $char3 != '0'){
			if($char2 == ' ') {
				$counter++;
				$score *= $unigrams[$char3];
			}else if($char1 == ' ' && $char2 != '0'){
				$counter++;
				$score *= $bigrams[$char2][$char3];
			}else{
				if($char1 != '0' && $char2 != '0'){
					$counter++;
					$score *= $trigrams[$char1][$char2][$char3];
				}
			}
		}
		if($counter == 10){
			$parts[] = $score;
			$score = 1;
			$counter = 0;
		}
		$char1 = $char2;
		$char2 = $char3;
	}	
	$score_count = count($parts);
	$score_sum = array_sum($parts);
	return ($score_sum / $score_count);
}

if(isset($_POST['txt'])){
	$czech = get_score($_POST['txt'],'czech');
	$pl = get_score($_POST['txt'],'pl');
	$sk = get_score($_POST['txt'],'sk');
	if($czech >= $pl && $czech >= $sk){
		echo 'Čeština';
	}else if($sk >= $pl){
		echo 'Slovak';
	}else{
		echo 'pl';
	}
}