<?php
extract(shortcode_atts(array(
    'limit' => -1,
    'style'	=> 'grid',
    'items' => '4',
    'interval' => '',
    'show_excerpt'	=> '',
    'post_in' => ''
), $atts));
$autoplay = ($interval) ? 'true' : 'false';
$items = intval($items);
if($items == '4') $m_items = '3';
if($items == '3') $m_items = '2';
if($items == '2') $m_items = '2';
if($items == '1') $m_items = '1';
$query = array(
	'post_type' => 'agent',
	'posts_per_page' => $limit,
	'suppress_filters' => 0
);

if($post_in){
	$query['post__in'] = explode(',', $post_in);
}

$posts = get_posts($query);
?>


<?php if($style == 'grid'): ?>
<ul class="large-block-grid-<?php echo $items; ?> medium-block-grid-<?php echo $m_items; ?>">
	<?php foreach($posts as $post): ?>
	<li><?php nt_agent_card($post->ID); ?></li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>

<?php if($style == 'carousel'): ?>
<div class="lt-carousel post-carousel" data-items="<?php echo esc_attr($items); ?>" data-m-items="<?php echo esc_attr($m_items); ?>" data-s-items="1" data-autoplay-hover-pause="true" data-smart-speed="250" data-fluid-speed="250" data-nav="true" data-dots="false" data-autoplay="<?php echo esc_attr($autoplay); ?>" data-loop="false" data-autoplay-timeout="<?php echo esc_attr($interval); ?>" data-margin="30">
	<?php foreach($posts as $post): ?>
	<?php nt_person_card($post->ID); ?>
	<?php endforeach; ?>
</div>
<?php endif; ?>