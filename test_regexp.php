<?php
require_once("includes/fonctions.inc.php");

// liens : [[P2P Page sur le P2P]]	=>	[[p2p|Page sur le P2P]]
$chaine = "bala [[blazbfelabf]] [[http://www.google.fr/stoi zaertezrtzert]] jnfkerbjzgrez \n zerlgnzekrbgzerg [[Stoi le stoi]] zerlghjezorg \n egklzerhgk [[Smoi le smoi]] lzehgkjhrezg";
echo nl2br($chaine) . "<br/>";
echo "<br/>";
$chaine_finale = traitement_liens($chaine);
echo nl2br($chaine_finale) ."<br/>";

echo "<hr>";

//test 



?>