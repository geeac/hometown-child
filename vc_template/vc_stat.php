<?php
extract(shortcode_atts(array(
    'number' => '100',
    'title'	=> '',
    'icon'	=> '',
    'unit'	=> ''
), $atts));

?>
<div class="nt-stat">
	<div class="stat" ><span class="animate-number" data-to="<?php echo esc_attr($number); ?>"><?php echo intval($number); ?></span><?php echo $unit; ?></div>
	<div class="line"></div>
	<?php echo do_shortcode('[nt_icon id="'.$icon.'"]'); ?> <?php echo wp_kses_data($title); ?>
</div>