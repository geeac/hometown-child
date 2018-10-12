<?php
$output = $title = $interval = $el_class = '';
extract(shortcode_atts(array(
    'el_class' => '',
    'style'	=> '',
    'icon_position' => ''
), $atts));

$el_class = $this->getExtraClass($el_class);

echo '<div class="animate-box '.esc_attr($el_class).'">'.do_shortcode($content).'</div>';