<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Comparateur</title>
	<link rel="stylesheet" type="text/css" href="css.css">
	<script type="text/javascript" src="js/jquery-2.1.3.min.js"> </script>
	<script type="text/javascript" src="js/js.js"> </script>
</head>
<body>

<?php
require_once("includes/conf.inc.php");
require_once("includes/fonctions.inc.php");
require_once("includes/wikini.class.php");

if(!empty($_GET['article']))
	$article = $_GET['article'];
else 
	$article = $wikini_start_page;


$w = new Wikini();
$tags = $w->get_pages_tags();

$key = array_search($article, $tags);
$previous = $tags[$key-1];
$next = $tags[$key+1];

?>
	<span id="entete">
		<form action="" method="get">
			<a href="?article=<?=$previous?>"> &lt;&lt; <?= $previous ?> </a>
			<select name="article" style="width: 150px">
<?php
foreach ($tags as $tag) {
	$selected = '';
	if($tag == $article)
		$selected = ' selected="selected"';
	echo '<option' . $selected . '>' . $tag . '</option>';
}
?>
			</select>
			<a href="?article=<?=$next?>"> <?=$next?> &gt;&gt; </a>
		</form>
	</span>

<?php
$url_wikini = $wikini_url . "/wakka.php?wiki=" . $article;
$url_dokuwiki = $dokuwiki_url . "/doku.php?id=" . article_name_convertion($article);
?>
	<div id="gauche">
		<?php
		display_wikini_side($article, $w);
		?>
	</div>
	<div id="droite">
		<?php
		display_dokuwiki_side($article, $w);
		?>
	</div>

</body>
</html>