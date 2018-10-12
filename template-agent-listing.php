<?php 
// Template Name: Agent Listing
get_header(); 

$query = array(
	'post_type' => 'agent',
	'paged'=> $paged
);

if(is_page()) {
	$wp_query = new WP_Query($query);
}
?>

<div class="main-content">
<div class="section">
<div class="row">

	<div class="large-12 columns">

	<ul class="large-block-grid-4 medium-block-grid-3">
	<?php while ( have_posts() ) : the_post(); ?>
		<li><?php nt_agent_card($post->ID); ?></li>
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