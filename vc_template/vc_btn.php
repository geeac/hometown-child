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
    'icon_position' => 'left',
    'link' => '',
), $atts));

$link = vc_build_link( $link );

$css = '';
if($color != '') {
    $css .= 'background: '.$color.'; border-color: '.$color.';';
    $style = 'solid';
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

echo '<div class="bt-align-'.$align.'"><a href="'.$link['url'].'"  target="'.$link['target'].'" title="'.$link['title'].'" class="lt-button '.esc_attr($el_class).'" style="'.$css.'">'.$title.'</a></div>';