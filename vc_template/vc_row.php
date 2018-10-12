<?php
$output = $el_class = $bg_image = $bg_color = $bg_image_repeat = $font_color = $padding = $margin_bottom = $css = '';
extract(shortcode_atts(array(
    'el_class'        => '',
    'bg_image'        => '',
    'bg_color'        => '',
    'bg_image_repeat' => '',
    'font_color'      => '',
    'padding'         => '',
    'margin_bottom'   => '',
    'css' => '',
    'layout' => '',
    'element_color'	  => '',
    'el_id'             => '',
), $atts));

// wp_enqueue_style( 'js_composer_front' );
// wp_enqueue_script( 'wpb_composer_front_js' );
// wp_enqueue_style('js_composer_custom_css');

if($el_id) $el_id = 'id="'.$el_id.'"';

$el_class = $this->getExtraClass($el_class);
$el_class .= ($element_color)?' element-'.$element_color:'';

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_row wpb_row '. ( $this->settings('base')==='vc_row_inner' ? 'vc_inner ' : '' ) . get_row_css_class() . esc_attr($el_class) . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

$style = $this->buildStyle($bg_image, $bg_color, $bg_image_repeat, $font_color, $padding, $margin_bottom);
$output .= '<div class="section '.$css_class.' '.$layout.'" '.$el_id.' '.$style.'>';
$output .= '<div class="row">';
$output .= wpb_js_remove_wpautop($content);
$output .= '</div>';
$output .= '</div>'.$this->endBlockComment('row');

echo $output;