<?php
// entropie a perplexita

ini_set('memory_limit','512M');

$filecontent = file_get_contents('czech_data.txt');
$words = preg_split('/[\s]+/', $filecontent, -1, PREG_SPLIT_NO_EMPTY);

// unigramy
$unigrams = array();
foreach($words as $val) {
	if(isset($unigrams[$val]))
		$unigrams[$val]++;
	else
		$unigrams[$val] = 1;
}
arsort($unigrams);

// bigramy
$bigrams = array();
$last_word = $words[0];
for($val = 1; $val <= count($words); $val++) {
	$lst = $last_word.'_'.$words[$val];
	if(isset($bigrams[$lst]))
		$bigrams[$lst]++;
	else
		$bigrams[$lst] = 1;
	$last_word = $words[$val];
}
arsort($bigrams);

// pocet slov uni a bigramu
$uni_num = count($words);
$bi_num = $uni_num - 1;

// entropie
$entr = 0;
foreach($unigrams as $key => $value) {
	$entr += ($value/$uni_num) * log(($value/$uni_num), 2);	
}
$entr = (-1) * $entr;
echo "<br>Entropie: ".$entr;

// sdruzena entropie (dvojic)
$s_entr = 0;
foreach($bigrams as $key => $value) {
	$s_entr += ($value/$bi_num) * log(($value/$bi_num), 2);	
}
$s_entr = (-1) * $s_entr;
$s_perp = pow(2, $s_entr);
echo "<br>Perplexita dvojic: ".$s_perp;

// podminena entropie
$p_entr = 0;
$p_entr = $s_entr - $entr;
echo "<br>Podminena entropie: ".$p_entr;







?>