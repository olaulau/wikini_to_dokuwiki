<?php
require_once 'includes/wikini.class.php';

// $w = new Wikini();
// $t = $w->get_pages_tags();
// var_dump($t);

// $w = new Wikini();
// $b = $w->get_last_body('Eclipse');
// echo "<pre> $b </pre>";

$tag = 'PhpWebGallery';
$tag_bis = article_name_convertion($tag);
echo "$tag => $tag_bis";
