<?php
$output = $title = $interval = $el_class = '';
extract(shortcode_atts(array(
    'el_class' => '',
    'style'	=> '',
    'icon_position' => ''
), $atts));

$el_class = $this->getExtraClass($el_class);

echo '<ul class="list-icon '.$style.' p-'.$icon_position.' '.esc_attr($el_class).'">';
echo do_shortcode($content);
echo '</ul>';