<?php

require_once 'includes/conf.inc.php';

function display_wikini_side($article, $w) {
	$body = $w->get_last_body($article);
	echo nl2br(htmlspecialchars($body));
}

function display_dokuwiki_side($article, $w) {
	global $dokuwiki_install_dir, $pages_subdir;
	$article_filename = $dokuwiki_install_dir . "/" . $pages_subdir . '/' . article_name_convertion($article) . '.txt';
	$fh = fopen($article_filename, 'r');

	while (($buffer = fgets($fh, 4096)) !== false) {
		echo nl2br(htmlspecialchars($buffer));
	}
}

require_once 'comparator.inc.php';

?>
