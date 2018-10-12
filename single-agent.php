<?php get_header(); ?>

<div class="main-content">
<div class="row">

<div class="large-8 columns">
<div class="section">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php 
			if(strpos($post->post_content,'vc_row') !== false) {
				the_content();
			} else {
				echo '<div class="row"><div class="large-12 columns">';
				the_content();
				echo '</div></div>';
			}
		?>
	<?php endwhile; ?>

	<div class="vspace"></div> <!-- <div class="vspace"></div>
	<h3><?php _e('Assigned Properties', 'theme_front'); ?></h3> 
	<div class="vspace"></div> -->
	<ul class="large-block-grid-2 medium-block-grid-2">
	<?php 
		$properties = get_posts(array('post_type' => 'property', 'post_status' => 'publish', 'posts_per_page' => -1));
		foreach($properties as $property): 
			$agents = get_post_meta( $property->ID, '_meta_agent', true );
			if(in_array($post->ID, $agents)):
			?>
			<li><?php nt_property_list($property->ID); ?></li>
	<?php endif; endforeach; ?>
	</ul>
</div>
</div>

<aside class="sidebar large-4 columns">
<div class="section">
	<?php if ( dynamic_sidebar( 'agent' ) ); ?>
</div>
</aside>

</div><!-- .row -->
</div><!-- #content -->

<?php get_footer(); ?>