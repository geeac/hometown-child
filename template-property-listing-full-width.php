<?php 
// Template Name: Property Listing
get_header();
/*
// vars
$queried_object = get_queried_object(); 
$taxonomy = $queried_object->taxonomy;
$tax_custom_field_id = 'location_' . $queried_object->term_id;

// process hoffman listings count
$hoffman_user_meta_propertiesperpage = get_field('hoffman_location_listings_count', $tax_custom_field_id );

if ($hoffman_user_meta_propertiesperpage){ $hoffman_user_final_propertiescount = $hoffman_user_meta_propertiesperpage; } else { $hoffman_user_final_propertiescount = 9; }

?>

<div class="main-content">
<div class="section">
<div class="row">

	<div class="large-12 columns">

	<?php get_template_part('section/section', 'property-sort'); ?>

<?php 
global $query_string;
if ($hoffman_user_final_propertiescount != ''){
query_posts( $query_string . '&posts_per_page=' . $hoffman_user_final_propertiescount );
};
?>

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

<?php wp_reset_query(); wp_reset_postdata(); get_footer(); ?>*/

if ( get_query_var('paged') ) {
    $paged = get_query_var('paged');
} elseif ( get_query_var('page') ) {
    $paged = get_query_var('page');
} else {
    $paged = 1;
}
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

		<?php 
			// process hoffman listings count
			$hoffman_user_meta_propertiesperpage = get_field('hoffman_location_listings_count', $tax_custom_field_id );
			global $query_string;
			if (!empty($hoffman_user_meta_propertiesperpage)){
				query_posts( $query_string . '&posts_per_page=' . $hoffman_user_meta_propertiesperpage );
			};
		?>

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