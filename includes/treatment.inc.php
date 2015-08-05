<?php
// http://fr2.php.net/manual/fr/book.pcre.php

function traitement_liens($chaine, $debug=false)
{
	// [[link a long description]]	=>	[[link|a long description]]
	// words are everything without '[' and ']'
	$nb_res = preg_match_all('@\[\[([^\[\]]+)\]\]@', $chaine, $matches);
	if($debug) echo "$nb_res matches : <br/>";

	$chaine_finale = $chaine;
	foreach ($matches[1] as $key => $value) {
		// first word without a space, next words with a preceding space
		preg_match('@^([^ \[\]]+)(( [^\[\]]+)*)@', $value, $m);
// 		print_r($m);
		$link = article_name_convertion($m[1], $debug);
		$text = $m[2];
		if(empty($text) && is_camel_case($m[1])) { // try to create a smart text for the link
			$text = str_replace('_', ' ', $link);
			$text = ucwords($text);
		}
		
		$transformed = $link . (!empty($text) ? '|'.ltrim($text) : '');
		if($debug) echo "[[$value]] => [[$transformed]] <br/>";
		$tmp = str_replace("[[$value]]", "[[$transformed]]", $chaine_finale, $count);
		if($count == 1)
			$chaine_finale = $tmp;
		else
			echo "erreur replace count = $count <br/>";
	}
	return $chaine_finale;
}

function traitement_titres($chaine, $debug=false)
{
	// titles must not contain link, whereas we transform title to bold so that the link will work
	// words are everything without '='
	$nb_res = preg_match_all('@([=]{2,5})([^=]+)([=]{2,5})@', $chaine, $matches);
	if($debug) echo "$nb_res matches : <br/>";

	$chaine_finale = $chaine;
	foreach ($matches[2] as $key => $value) {
		if(preg_match('@\[\[([^\[\]]+)\]\]@', $value)) {
			$tmp = str_replace ( $matches[0][$key] , '**'.$matches[2][$key].'**' , $chaine_finale , $count);
			if($count == 1)
				$chaine_finale = $tmp;
			else
				echo "erreur replace count = $count <br/>";
		}
	}
	return $chaine_finale;
}


function traitement_chasse_fixe($chaine, $debug=false)
{
	// ##content##		=>	''content''
	
	// prevent real '' to generate wrong things
	$chaine_finale = str_replace("''", "<nowiki>''</nowiki>", $chaine);
	
	// words are everything without '##'
	$nb_res = preg_match_all('@##([^#]+)##@', $chaine, $matches);
	if($debug) echo "$nb_res matches : <br/>";

	foreach ($matches[1] as $value) {
		$transformed = $value;
		if($debug) echo "##$value## => ''$transformed'' <br/>";
		$tmp = str_replace("##$value##", "''$transformed''", $chaine_finale, $count);

		$chaine_finale = $tmp;
		/*
		 if($count == 1)
			$chaine_finale = $tmp;
		else
			echo "erreur replace count = $count <br/>";
		*/
	}
	return $chaine_finale;
}


function traitement_puces($chaine, $debug=false)
{
	//  - line		=>	* line
	// space before '-' define indentation level, double those nomber of spaces before '*'
	// words are everything without '-'
	$array = explode("\n", $chaine);
	
	$chaine_finale = $chaine;
	foreach ($array as $line) {
		$res = preg_match('@^([[:blank:]]+)-(.+)$@', $line, $matches);
		if($res > 0) {
			$transformed = $matches[1] . $matches[1] . '*' . $matches[2];
			if($debug) echo $matches[1].'-'.$matches[2]." => $transformed <br/>\n";
			$tmp = str_replace($matches[0], $transformed, $chaine_finale, $count);
			if($count == 1)
				$chaine_finale = $tmp;
			else
				echo "erreur replace count = $count <br/>\n";
		}
	}
	
	return $chaine_finale;
}

function traitement_no_format($chaine, $debug=false)
{
	// "" content ""	=>		<nowiki> content </nowiki>
	// words are everything without '""'
	$nb_res = preg_match_all('@""(((?!"").)*)""@', $chaine, $matches);
	if($debug) echo "$nb_res matches : <br/>\n";

	$chaine_finale = $chaine;
	foreach ($matches[1] as $key => $value) {
		$transformed = "<nowiki>$value</nowiki>";
		if($debug) echo htmlspecialchars('""'.$value.'""'." => $transformed") . " <br/> \n";
		$tmp = str_replace($matches[0][$key], $transformed, $chaine_finale, $count);

		$chaine_finale = $tmp;
		/*
			if($count == 1)
			$chaine_finale = $tmp;
		else
			echo "erreur replace count = $count <br/>";
		*/
	}
	return $chaine_finale;
}

function traitement_code($chaine, $debug=false)
{
	// %% content %%	=>		<code> content </code>
	// words are everything without '%%'
	$nb_res = preg_match_all('@%%([^%]+)%%@', $chaine, $matches);
	if($debug) echo "$nb_res matches : <br/>\n";

	$chaine_finale = $chaine;
	foreach ($matches[1] as $key => $value) {
		$transformed = "<code>$value</code>";
		if($debug) echo htmlspecialchars('""'.$value.'""'." => $transformed") . " <br/> \n";
		$tmp = str_replace($matches[0][$key], $transformed, $chaine_finale, $count);

		$chaine_finale = $tmp;
		/*
			if($count == 1)
			$chaine_finale = $tmp;
		else
			echo "erreur replace count = $count <br/>";
		*/
	}
	return $chaine_finale;
}


function traitement_newline($chaine, $debug=FALSE)
{
	// handle repeteated "\n"
	$nb_res = preg_match_all('@(\n{2,})@', $chaine, $matches);
	if($debug)
		echo "$nb_res matches : <br/>\n";

	
	$array = array();
	foreach ($matches[1] as $key => $value) {
		$array[] = $value;
	}
	$array = array_unique($array);
	
	$chaine_finale = $chaine;
	foreach ($array as $value) {
		$nb = strlen($value);
		if($debug)
			echo "\\n x $nb <br/>";
		$nb  = $nb - 1;
		$transformed = "\n";
		for($i=0; $i<$nb; $i++) {
			$transformed .= "\\\\ \n";
		}
		$tmp = str_replace($value, $transformed, $chaine_finale, $count);
		$chaine_finale = $tmp;
	}
	
	return $chaine_finale;
}
