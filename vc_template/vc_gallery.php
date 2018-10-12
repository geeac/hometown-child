<?php
extract(shortcode_atts(array(
    'interval' => '',
    'images' => '',
    'img_size' => 'full',
    'custom_links' => '',
    'onclick' => 'link_image',
    'custom_links_target' => '',
), $atts));
$images = explode(',', $images);
$autoplay = ($interval) ? 'true' : 'false';
$custom_links = explode( ',', $custom_links );
?>
<div class="nt-gallery lt-carousel"  data-autoplay-hover-pause="true" data-smart-speed="250" data-items="1" data-nav="true" data-dots="true" data-autoplay="<?php echo esc_attr($autoplay); ?>" data-loop="true" data-autoplay-timeout="<?php echo intval($interval); ?>" data-animate-out="fadeOut">
	<?php foreach($images as $i => $image): 
		$img_src = wp_get_attachment_image_src($image, $img_size);
		$img_full_src = wp_get_attachment_image_src($image, 'full');
	?>
	<div class="item">
	<?php if($onclick == 'link_image'): ?><a href="<?php echo esc_url($img_full_src[0]); ?>" class="swipebox" title=""><?php endif; ?>
	<?php if($onclick == 'custom_link' && is_array($custom_links)): ?><a href="<?php echo esc_url($custom_links[$i]); ?>" target="<?php echo esc_attr($custom_links_target); ?>"><?php endif; ?>
		<img src="<?php echo $img_src[0]; ?>" alt="<?php echo get_the_title($image); ?>" />
	<?php if($onclick != 'link_no'): ?></a><?php endif; ?>
	</div>
	<?php endforeach; ?>
</div>