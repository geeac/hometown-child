<?php
$id = '';
extract(shortcode_atts(array(
    'list_id' => '',
    'placeholder' => __('Email Address', 'theme_front'),
    'button_text' => __('Submit', 'theme_front'),
    'button_color' => ''
), $atts));


$ajaxurl = admin_url('admin-ajax.php');
?>
<div class="vc_newsletter">
<form class="ajax-form validate-form" action="<?php echo esc_url($ajaxurl); ?>">
<input type="hidden" name="list_id" value="<?php echo esc_attr($list_id); ?>" />
<input type="hidden" name="action" value="mailchimp_subscribe" />
<div class="input-wrap infield-button">
	<input type="text" name="email" placeholder="<?php echo esc_attr($placeholder); ?>" style="" autocomplete="off" />
	<button class="lt-button primary" style="background-color: <?php echo $button_color; ?>; border-color: <?php echo $button_color; ?>;"><span class="text"><?php echo $button_text; ?></span><i class="flaticon-arrow408 rotating spinner"></i></button>
</div>
<div class="form-response"></div>
</form>
</div>