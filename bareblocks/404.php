<?php
get_template_part('head');
?>

	<main id="primary" class="site-main main-404">

		<section>
			<header>
				<h1><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'bareblocks' ); ?></h1>
			</header>

			<div>
				<p><?php esc_html_e( 'It looks like nothing was found at this location.', 'bareblocks' ); ?></p>
			</div>
		</section>

	</main>

<?php
get_footer();
