<?php
$title = $text = $image = $icon = $button_text = $href = $target = $el_class = '';
extract(shortcode_atts(array(
    'title' => '',
    'icon' => '',
    'target' => '_self',
    'href' => '',
    'el_class' => '',
    'button_text' => '',
    'button_link' => '',
    'image'	=> '',
    'style' => '',
), $atts));

if($style == 'icon-left') {
    $image = '';
}

if($image) $image = wp_get_attachment_image_src($image, 'card');

$el_class = $this->getExtraClass($el_class);
$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' '.$el_class, $this->settings['base']);
if($image) $css_class .= ' with-image';
$css_class .= ' '.$style;


$button_link = vc_build_link( $button_link );

?>
<div class="card teaser <?php echo esc_attr($css_class); ?>">
	<?php if($image): ?><div class="img-wrap"><img src="<?php echo $image[0]; ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>" alt="" /></div><?php endif; ?>
	<div class="content-wrap align-center">
		<?php if($icon && false): ?><div class="feature-icon "><?php echo do_shortcode("[nt_icon id='".$icon."']"); ?></div><?php endif; ?>
		<div class="title"><?php echo wp_kses_data($title); ?></div>
		<?php echo apply_filters('the_content', $content); ?>
        <?php if($button_text): ?>
            <p><a href="<?php echo $button_link['url']; ?>" title="<?php echo $button_link['title']; ?>" target="<?php echo $button_link['target']; ?>" class="button small secondary"><?php echo $button_text; ?></a></p>
        <?php endif; ?>
	</div>
</div>