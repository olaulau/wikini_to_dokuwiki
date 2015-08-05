<?php
/* fill-in the correct values and rename to conf.inc.php */

// config utilisateur
$mysql_host = "localhost";
$mysql_login = "";
$mysql_password = "";
$base = "wikini";
$wikini_table_prefix = "wikini_";
$dokuwiki_install_dir = "/home/<user>/public_html/dokuwiki";
$wikini_url = "http://<domain>/wikini";
$dokuwiki_url = "http://<domain>/dokuwiki";

// config technique
$wikini_pages_table_name = "pages";
$wikini_user_filter = array('WikiNiInstaller', 'WikiAdmin');
$wikini_page_filter = array('PagesOrphelines', 'PagesACreer', 'RechercheTexte', 'ReglesDeFormatage', 'AideWikiNi', 'TableauDeBordDeCeWiki');
$wikini_log_pages = 'LogDesActionsAdministratives';
$article_name_convertion = array('PagePrincipale' => 'start');
$wikini_start_page = 'PagePrincipale';
$out_directory = "tmp";
$data_directory = 'data';
$pages_subdir =  "pages";
$history_subdir = "attic";
$meta_subdir = "meta";

?>