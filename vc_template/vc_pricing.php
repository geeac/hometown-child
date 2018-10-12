<?php
extract(shortcode_atts(array(
    'title'	=> '',
    'price' => '',
    'features'	=> '',
    'button_text' => '',
    'button_link' => '',
    'button_color' => '',
    'el_class' => '',
), $atts));

$features = explode("\n", str_replace("\r", "", $features));

$price_number = filter_var(substr($price, 0, strpos($price, '.')), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_THOUSAND);
// var_dump($price_number);
if($price_number) {
	$price = str_replace($price_number, '<span class="animate-number" data-to="'.filter_var($price_number, FILTER_SANITIZE_NUMBER_INT).'">'.$price_number.'</span>', $price);
}
?>

<div class="nt-pricing <?php echo esc_attr($el_class); ?>">
	<div class="plan"><?php echo $title; ?></div>
	<div class="price"><?php echo $price; ?></div>
	<ul class="features-list">
	<?php foreach($features as $feature): ?>
		<li><?php echo $feature; ?></li>
	<?php endforeach; ?>
	</ul>

	<?php if($button_text): 
		$button_link = vc_build_link( $button_link );
	?>
        <p><a href="<?php echo esc_url($button_link['url']); ?>" title="<?php echo esc_attr($button_link['title']); ?>" target="<?php echo esc_attr($button_link['target']); ?>" class="lt-button <?php if($button_color): ?>solid<?php endif; ?>" style="background-color:<?php echo $button_color; ?>; border-color:<?php echo $button_color; ?>;"><?php echo $button_text; ?></a></p>
    <?php endif; ?>
</div>