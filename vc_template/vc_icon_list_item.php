<?php
extract(shortcode_atts(array(
    'title'	=> '',
    'icon' => ''
), $atts));

echo '<li>' .do_shortcode('[nt_icon id="'.$icon.'"]').' '. $title . '</li>';