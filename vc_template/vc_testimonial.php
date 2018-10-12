<?php
extract(shortcode_atts(array(
    'interval' => '',
    'el_class' => '',
), $atts));
$el_class = $this->getExtraClass($el_class);
$autoplay = ($interval) ? 'true' : 'false';
?>
<div class="nt-testimonials lt-carousel <?php echo esc_attr($el_class); ?>" data-items="1" data-transition-style="fade" data-smart-speed="750" data-animate-out="fadeOut" data-animate-in="fadeIn" data-autoplay-hover-pause="true" data-navigation="false" data-loop="true" data-autoplay="<?php echo esc_attr($autoplay); ?>" data-autoplay-timeout="<?php echo esc_attr($interval); ?>" data-dots="false">
<?php echo do_shortcode($content); ?>
</div>