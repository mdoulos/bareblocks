<?php
/** Used as the fallback template for any page that doesn't have a template. */
get_template_part('head');
?>

	<main id="primary" class="site-main main-index">
        <?php
            if ( have_posts() ) {

                while ( have_posts() ) {
                    the_post();
                }

                the_posts_navigation();

            }
		?>
	</main>

<?php
get_footer();