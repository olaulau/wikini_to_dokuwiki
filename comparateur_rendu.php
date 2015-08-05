<?php

require_once 'includes/conf.inc.php';

function display_wikini_side($article, $w) {
	global $wikini_url;
	$url_wikini = $wikini_url . "/wakka.php?wiki=" . $article;
	?>
		<iframe src="<?php echo $url_wikini?>" width="100%" height="100%"></iframe>
	<?php
}

function display_dokuwiki_side($article, $w) {
	global $dokuwiki_url;
	$url_dokuwiki = $dokuwiki_url . "/doku.php?id=" . article_name_convertion($article);
	?>
		<iframe src="<?php echo $url_dokuwiki?>" width="100%" height="100%"></iframe>
	<?php
}

require_once 'comparator.inc.php';

?>
