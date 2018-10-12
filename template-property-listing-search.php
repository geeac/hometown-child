<?php 
// Template Name: Property Listing
get_header(); 

$property = array(
	'post_type' => 'property',
	'paged'=> $paged
);
if(is_page()) {
	$wp_query = new WP_Query($property);
}
?>

<div class="main-content">
<div class="section">
<div class="row">

	<div class="large-12 columns">

	<?php get_template_part('section/section', 'property-sort'); ?>

	<ul class="large-block-grid-3 medium-block-grid-2">
	<?php while ( have_posts() ) : the_post(); ?>
		<li><?php nt_property_card($post->ID); ?></li>
	<?php endwhile; ?>
	</ul>

	<div class="vspace"></div>
    <div class="pagination-wrap clearfix">
      <?php posts_nav_link(' ', "<span class='button button-primary previouspostslink'>".__('&larr; Previous Page', 'theme_front')."</span>", "<span class='button button-primary nextpostslink'>".__("Next Page &rarr;", 'theme_front')."</span>"); ?>
    </div>
	</div>

</div></div>
</div><!-- .main-content -->

<?php get_footer(); ?>