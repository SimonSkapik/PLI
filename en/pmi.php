<?php
ini_set('memory_limit','1024M');

$uni = array();
$bi = array();
$words = array();
$n = 0;

$file = fopen("english_unigramy.txt", "r") or exit("Unable to open file!");
while(!feof($file)) {
	$f = fgets($file);
	if($f != '') {
		$words = explode(' ', $f);
		$uni[$words[0]] = $words[1];
		$n += $words[1];
	}
  }
fclose($file);

$file = fopen("english_bigramy.txt", "r") or exit("Unable to open file!");
while(!feof($file)) {
	$f = fgets($file);
	if($f != '') {
		$words = explode(' ', $f);
		if($words[1] != '') {
			$val = $words[0].','.$words[1];
			$bi[$val] = $words[2];
		}
		else
			echo "Chybny bigram: ".$words[0].','.$words[1].' '.$words[2]."<br>";
	}
}
fclose($file);
$pmi = array();

foreach($bi as $key => $value) {
	$w = explode(',',$key);
	$pmi[$key] = log($n * ($value / ($uni[$w[0]] * $uni[$w[1]])));
}
arsort($pmi);

$max = reset($pmi);
foreach ($pmi as $key => $value) {
	if($value >= $max)
		echo "PMI(".$key.") = ".$value."<br>";
}
 

?>