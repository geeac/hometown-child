<?php
extract(shortcode_atts(array(
    'speed' => '',
    'items'	=> '5',
    'images' => '',
    'margin' => '20',
    'on_click'	=> '',
    'style' => '',
    'img_size' => 'full',
    'nav' => 'false',
    'custom_url' => ''
), $atts));
$images = explode(',', $images);
$autoplay = ($speed) ? 'true' : 'false';
$items = intval($items);
$m_items = ($items > 3) ? 3:$items;
$gallery_id = 'g-'.md5(uniqid(rand(), true));
$nav = ($nav == '')?'false':$nav;

if ( 'custom_url' === $on_click ) {
	$custom_url = explode( ',', $custom_url );
}

?>
<div class="nt-gallery lt-carousel <?php echo esc_attr($style); ?>"  data-autoplay-hover-pause="true" data-smart-speed="500" data-items="<?php echo esc_attr($items); ?>" data-nav="<?php echo $nav; ?>" data-dots="false" data-autoplay="<?php echo esc_attr($autoplay); ?>" data-loop="true" data-autoplay-timeout="<?php echo esc_attr($speed); ?>" data-m-items="<?php echo esc_attr($m_items); ?>" data-s-items="1" data-margin="<?php echo esc_attr($margin); ?>">
	<?php 
	$counter = 0;
	foreach($images as $image): 
		$img_full_src = wp_get_attachment_image_src($image, 'full');
		$img_src = wp_get_attachment_image_src($image, 'large');

		$post_thumbnail = wpb_getImageBySize( array( 'attach_id' => $image, 'thumb_size' => $img_size ) );
	?>
	<div class="item">
	<?php if($on_click == 'lightbox'): ?>
		<a href="<?php echo esc_url($post_thumbnail['p_img_large'][0]); ?>" class="swipebox" rel="<?php echo esc_attr($gallery_id); ?>"><?php echo $post_thumbnail['thumbnail']; ?></a>
	<?php elseif($on_click == 'custom_url' && isset($custom_url[$counter])): ?>
		<a href="<?php echo $custom_url[$counter]; ?>"><?php echo $post_thumbnail['thumbnail']; ?></a>
	<?php else: ?>
		<?php echo $post_thumbnail['thumbnail']; ?>
	<?php endif; ?>
	</div>
	<?php $counter++; endforeach; ?>
</div>