<?php
class processtext {

function debug($var){
	print "<pre>";
	print_r($var);
	print "</pre>";
}

function text2array($textData,$delimiter = null){
	$textData = explode("\n",$textData);
	if (isset($delimiter)){
		foreach($textData as $linekey => $line){
			$textData[$linekey] = explode($delimiter,$line);
		}
	}
	return $textData;
}
}
?>