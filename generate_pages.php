<?php
require_once('includes/conf.inc.php');
require_once('includes/fonctions.inc.php');
require_once('includes/wikini.class.php');


$debug = FALSE;


function clean_dokuwiki_directories() {
	global $out_directory, $pages_subdir, $history_subdir, $meta_subdir;
	if(file_exists($out_directory))
	{
		remove_all_files($out_directory . "/" . $pages_subdir);
		rmdir($out_directory . "/" . $pages_subdir);
		rmdir($out_directory);
	}
	
}


// clean temporary files before
clean_dokuwiki_directories();


// prepare temporary folders
mkdir($out_directory);
mkdir($out_directory . "/" . $pages_subdir);


// init
$wikini = new Wikini();
$wikini->load();
$pages = $wikini->get_pages();
// var_dump($pages); die;


// écriture des articles
$pages_out_dir = $out_directory . "/" . $pages_subdir;
$cpt = 0;
foreach ($pages as $tag => $histo) {
	$page = reset($histo); // last page
// 	if($value['tag'] != 'X30Hardy') continue; //TODO : just for tests
	$nom_fichier = $pages_out_dir  . "/" . article_name_convertion($page['tag']) . '.txt';
// 	echo $value['tag'] . " => " . $nom_fichier;	die;
	
    $monfichier = fopen($nom_fichier, "w");
    $body_transforme = transforme_body($page['body']);
	fputs($monfichier, $body_transforme);
    fclose($monfichier);
    echo "generated " . $pages_out_dir . "/" . article_name_convertion($page['tag']) . '.txt' . "<br/>";
    $cpt ++;
}
echo "$cpt pages written <br/>";


// clean dest & copy files
if(file_exists($dokuwiki_install_dir))
{
	remove_all_files($dokuwiki_install_dir . "/" . $data_directory . '/' . $pages_subdir);
	copy_all_files($pages_out_dir, $dokuwiki_install_dir . '/' . $data_directory . '/' . "/" . $pages_subdir);
}
else
{
	echo "wikini directory ('" . $dokuwiki_install_dir . "') doesn't exist. please verify config.";
}


// clean temporary files after
if(!$debug) {
	clean_dokuwiki_directories();
}
