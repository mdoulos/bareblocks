<?php
/** The <head> element for all pages. */
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php get_template_part('code-snippets/head-snippets', null, $args);  ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<div id="page" class="site">
		<?php get_header(); ?>
