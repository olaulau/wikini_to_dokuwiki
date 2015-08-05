<?php
require_once('includes/conf.inc.php');
require_once('includes/fonctions.inc.php');
require_once('includes/wikini.class.php');


$debug = FALSE;


// clean temporary files before
if(file_exists($out_directory))
{
	remove_all_files($out_directory . "/" . $pages_subdir);
	rmdir($out_directory . "/" . $pages_subdir);
	// remove_all_files($out_directory . "/" . $history_subdir);
	// rmdir($out_directory . "/" . $history_subdir);
	// remove_all_files($out_directory . "/" . $meta_subdir);
	// rmdir($out_directory . "/" . $meta_subdir);
	rmdir($out_directory);
}


// prepare temporary folders
mkdir($out_directory);
mkdir($out_directory . "/" . $pages_subdir);
// mkdir($out_directory . "/" . $history_subdir);
// mkdir($out_directory . "/" . $meta_subdir);


// init
$wikini = new Wikini();


// écriture des articles
$array = $wikini->get_all_pages();
// var_dump($array); die;
$pages_out_dir = $out_directory . "/" . $pages_subdir;
$cpt = 0;
foreach ($array as $key => $value) {
	$data = $value[0];
// 	if($data['tag'] != 'Pratique') continue; //TODO : just for tests
    $nom_fichier = $pages_out_dir  . "/" . article_name_convertion($data['tag']) . '.txt';
    $monfichier = fopen($nom_fichier, "w");
    $body_transforme = transforme_body($data['body']);
	fputs($monfichier, $body_transforme);
    fclose($monfichier);
    echo "generated " . $pages_out_dir . "/" . article_name_convertion($data['tag']) . '.txt' . "<br/>";
    $cpt ++;
}
// echo "$cpt articles écrits <br/>";


/*
// écriture de l'historique
$sql_query =
"SELECT *
FROM `wikini_pages`
where user not in ( 'WikiNiInstaller', 'WikiAdmin' )
order by tag asc, time desc";
$history_out_dir = $out_directory . "/" . $history_subdir;
$reponse = $mysqli->query($sql_query);
$cpt = 0;
while ($donnees = $reponse->fetch_object() )
{
	$tag = $donnees->tag;
//	if($tag != 'WampEclipse') continue; //TODO : just for tests
	$datetime = new DateTime($donnees->time);
    $nom_fichier = $history_out_dir  . "/" . $tag . "." .$datetime->getTimestamp() . '.txt.gz';
    $monfichier = gzopen($nom_fichier, "wb");
    gzwrite($monfichier, utf8_encode($donnees->body));
    gzclose($monfichier);
    $cpt++;
}
echo "$cpt historiques écrits";
*/

// clean dest & copy files
if(file_exists($dokuwiki_install_dir))
{
	remove_all_files($dokuwiki_install_dir . "/" . $data_directory . '/' . $pages_subdir);
	// remove_all_files($dokuwiki_install_dir . "/" . $data_directory . '/' . $history_subdir);
	// remove_all_files($dokuwiki_install_dir . "/" . $data_directory . '/' . $meta_subdir);
	
	copy_all_files($pages_out_dir, $dokuwiki_install_dir . '/' . $data_directory . '/' . "/" . $pages_subdir);
// 	copy_all_files($history_out_dir, $dokuwiki_install_dir . '/' . $data_directory . '/' . "/" . $history_subdir);
}
else
{
	echo "répertoire wikini ('" . $dokuwiki_install_dir . "') pas présent. vérifier la config.";
}


// clean temporary files after
if(!$debug) {
	remove_all_files($out_directory . "/" . $pages_subdir);
	rmdir($out_directory . "/" . $pages_subdir);
	// remove_all_files($out_directory . "/" . $history_subdir);
	// rmdir($out_directory . "/" . $history_subdir);
	// remove_all_files($out_directory . "/" . $meta_subdir);
	// rmdir($out_directory . "/" . $meta_subdir);
	rmdir($out_directory);
}
