<?php
$output = $title = $el_class = $open = $css_animation = '';
extract(shortcode_atts(array(
    'title' => '',
    'el_class' => '',
    'open' => 'false',
    'css_animation' => ''
), $atts));

$el_class = $this->getExtraClass($el_class);
$open = ( $open == 'true' ) ? ' active' : '';
$el_class .= ( $open == ' active' ) ? ' active' : '';

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_toggle' . $open, $this->settings['base'], $atts );
$css_class .= $this->getCSSAnimation($css_animation);

$output .= apply_filters('wpb_toggle_heading', '<div class="'.$css_class.'"><span><i class="flaticon-plus79"></i> '.$title.'</span></div>', array('title'=>$title, 'open'=>$open));
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_toggle_content' . $el_class, $this->settings['base'], $atts );
$output .= '<div class="'.$css_class.'">'.wpb_js_remove_wpautop($content, true).'</div>'.$this->endBlockComment('toggle')."\n";

echo $output;