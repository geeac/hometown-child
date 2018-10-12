<?php
$output = $color = $size = $icon = $target = $href = $el_class = $title = $position = '';
extract(shortcode_atts(array(
    'color' => '',
    'size' => '',
    'icon' => '',
    'href' => '',
    'target' => '',
    'el_class' => '',
    'title' => '',
    'align' => '',
    'style'	=> '',
    'icon_position' => 'left'
), $atts));

$css = '';
if($color != '' && $style == 'primary') {
    $css .= 'background: '.$color.'; border-color: '.$color.';';
}

$el_class .= ' '.$style;
$el_class .= ' '.$size;
$el_class .= ' i-'.$icon_position;

$icon = ($icon)?do_shortcode('[nt_icon id="'.$icon.'"]'):'';
if($icon_position == 'right') {
	$title = $title.' '.$icon;
} else {
	$title = $icon.' '.$title;
}

// $href = vc_build_link($href);
// if(!$href['target']) $href['target'] = "_self";

echo '<div class="bt-align-'.$align.'"><a href="'.esc_url($href).'"  target="'.esc_attr($target).'" class="lt-button '.esc_attr($el_class).'" style="'.$css.'">'.$title.'</a></div>';