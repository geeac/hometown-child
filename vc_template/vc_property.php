<?php
extract(shortcode_atts(array(
    'limit' => '',
    'style'	=> 'grid',
    'items' => '3',
    'interval' => '',
    'featured' => '',
    'random' => '',
    'type_in' => '',
    'location_in' => '',
    'status_in' => '',
    'sort'	=> ''
), $atts));
$autoplay = ($interval) ? 'true' : 'false';
if($items == '3') $m_items = '2';
if($items == '2') $m_items = '2';
if($items == '1') $m_items = '1';

$limit = (!$limit)?-1:$limit;
$query = array(
	'post_type' => 'property',
	'posts_per_page' => $limit,
	'suppress_filters' => 0
);
if($featured) {
	$meta_query[] = array(
		'key' => '_meta_featured',
		'value' => 'on'
	);
	$query['meta_query'] = $meta_query;
}
if($random) {
	$query['orderby'] = 'rand';
}
$tax_query = array();
if($type_in) {
	$tax_query[] = array(
		'taxonomy' => 'type',
		'field' => 'term_id',
		'terms' => explode(',', $type_in),
		'operator' => 'IN'
	);
}
if($location_in) {
	$tax_query[] = array(
		'taxonomy' => 'location',
		'field' => 'term_id',
		'terms' => explode(',', $location_in),
		'operator' => 'IN'
	);
}
if($status_in) {
	$tax_query[] = array(
		'taxonomy' => 'status',
		'field' => 'term_id',
		'terms' => explode(',', $status_in),
		'operator' => 'IN'
	);
}
$query['tax_query'] = $tax_query;

$properties = get_posts($query);
?>

<?php if($sort) get_template_part('section/section', 'property-sort'); ?>

<?php if($style == 'grid'): ?>
<ul class="large-block-grid-<?php echo $items; ?> medium-block-grid-<?php echo $m_items; ?>">
	<?php foreach($properties as $property): ?>
	<li><?php nt_property_card($property->ID); ?></li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>

<?php if($style == 'carousel'): ?>
<div class="lt-carousel post-carousel" data-items="<?php echo esc_attr($items); ?>" data-m-items="<?php echo esc_attr($m_items); ?>" data-s-items="1" data-autoplay-hover-pause="true" data-smart-speed="250" data-fluid-speed="250" data-nav="true" data-dots="false" data-autoplay="<?php echo esc_attr($autoplay); ?>" data-loop="false" data-autoplay-timeout="<?php echo esc_attr($interval); ?>" data-margin="30">
	<?php foreach($properties as $property): ?>
	<div class="item">
	<?php nt_property_card($property->ID); ?>
	</div>
	<?php endforeach; ?>

</div>
<?php endif; ?>