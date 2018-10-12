<?php
extract(shortcode_atts(array(
    'title' => '',
    'sub_title' => '',
    'sub_title_position' => 'after',
    'title_align' => '',
    'style' => 'no-line',
    'margin_bottom' => '',
    'el_class' => '',
    'icon' => '',
    'border' => ''
), $atts));
$class = "vc_separator wpb_content_element";

$class .= ($title_align!='') ? ' '.$title_align : '';
// $class .= ($style!='') ? ' '.$style : '';
if($border == 'false') $class .= ' no-line';
if(!$sub_title) $class .= ' no-sub';


$class .= $this->getExtraClass($el_class);
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base']);

?>

<div class="<?php echo esc_attr(trim($css_class)); ?>">

<?php if($sub_title_position == 'before'): ?><div class="sub-title"><?php echo esc_html($sub_title); ?></div><br /><?php endif; ?>

<h2 class="title">
<?php echo esc_html($title); ?>
</h2>

<?php if($sub_title_position == 'after'): ?><br /><div class="sub-title"><?php echo esc_html($sub_title); ?></div><?php endif; ?>
</div>

<?php echo $this->endBlockComment('separator')."\n";