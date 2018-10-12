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
    'icon_color' => ''
), $atts));

if($image) $image = wp_get_attachment_image_src($image, 'feature-thumb');

$el_class = $this->getExtraClass($el_class);
$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' '.$el_class, $this->settings['base']);
if($image) $css_class .= ' with-image';
$css_class .= ' p-'.$style;
$button_link = vc_build_link( $button_link );
?>
<div class="box-icon <?php echo esc_attr($css_class); ?>">
	<div class="feature-content">
		<?php if($icon): ?><div class="feature-icon "><?php echo do_shortcode("[nt_icon id='".$icon."' color='".$icon_color."']"); ?></div><?php endif; ?>
		<h3><?php echo esc_html($title); ?></h3>
		<?php echo apply_filters('the_content', $content); ?>
        <?php if($button_text): ?>
            <a href="<?php echo esc_attr($button_link['url']); ?>" title="<?php echo esc_attr($button_link['title']); ?>" target="<?php echo esc_attr($button_link['target']); ?>" class="button small secondary"><?php echo $button_text; ?></a>
        <?php endif; ?>
	</div>
</div>