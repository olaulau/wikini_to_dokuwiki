<?php

require_once 'conf.inc.php';
require_once 'treatment.inc.php';

function remove_all_files($dir_name)
{
	$liste = scandir($dir_name);
	foreach ($liste as $fichier)
	{
		if(is_file($dir_name . "/" . $fichier)) {
			unlink($dir_name . "/" . $fichier);
			echo "rm " . $dir_name . "/" . $fichier . "  <br/>";
		}
	}
}


function copy_all_files($src_dir, $dest_dir)
{
	$files = scandir($src_dir);
	foreach ($files as $file)
	{
		if(is_file($src_dir . "/" . $file)) {
			copy($src_dir . "/" . $file, $dest_dir . "/" . $file);
			echo "cp " . $src_dir . "/" . $file . " => " . $dest_dir . "/" . $file . "  <br/>";
		}
	}
}


function transforme_body($body)
{
	$body = traitement_titres($body, FALSE);
	$body = traitement_liens($body, FALSE);
	$body = traitement_chasse_fixe($body, FALSE);
	$body = traitement_puces($body, FALSE);
	$body = traitement_no_format($body, FALSE);
	$body = traitement_code($body, FALSE);
	$body = traitement_newline($body, FALSE);
	
	return $body;
}



function string_list_to_sql_list(&$array) {
	array_walk($array, function(&$item){$item = "'".$item."'";});
	return implode(', ', $array);
}


function article_name_convertion($name, $debug=FALSE) {
	global $article_name_convertion;
	if(!is_url($name)) {
		if(isset($article_name_convertion[$name])) {
			if($debug) echo "convertion depuis config <br/>";
			$res = $article_name_convertion[$name];
		}
		else {
			if($debug) echo "convertion depuis CamelCase regexp <br/>";
			$res = from_camel_case($name, $debug);
		}
	}
	else {
		if($debug) echo "it's an URL, don't convert <br/>";
		$res = $name;
	}
	return $res;
}

// http://stackoverflow.com/a/1993772
function from_camel_case($input, $debug) {
	$res = preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
	if($debug) print_r($matches);
	if($res) {
		if($debug) echo "recognised as CamelCase input, converting <br/>";
		$ret = $matches[0];
		foreach ($ret as &$match) {
			$match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
		}
		return implode('_', $ret);
	}
	else {
		if($debug) echo "not recognised as CamelCase input, returning original string (maybe URL ?) <br/>";
		return $input;
	}
}
function is_camel_case($input) {
	$regex = '!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!';
	$res = preg_match_all($regex, $input, $matches);
	return isset($res);
}
function is_url($input) {
	$regex='/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
	$res = preg_match_all($regex, $input, $matches);
	return (isset($res) && $res > 0);
}
