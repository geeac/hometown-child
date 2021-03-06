<?php get_header(); ?>

<?php
	// Send Message
	if(isset($_REQUEST['submit'])) {
		if(nt_get_option('advance', 'recaptchar_site_key') && nt_get_option('advance', 'recaptchar_secret_key')) {
			require_once(THEME_LIBS_DIR.'/recaptchalib.php');
			$privatekey = nt_get_option('advance', 'recaptchar_secret_key');
			$resp = recaptcha_check_answer ($privatekey,
			                             $_SERVER["REMOTE_ADDR"],
			                             $_POST["recaptcha_challenge_field"],
			                             $_POST["recaptcha_response_field"]);
			$is_valid = $resp->is_valid;
		} else {
			$is_valid = true;
		}

		global $nt_site_message;
		if($is_valid) {
			

			$from = $_REQUEST['from'];
			$phone = $_REQUEST['phone'];
			$msg = $_REQUEST['message'];
			$to = '';
			if(isset($_REQUEST['to'])) $to = $_REQUEST['to'];
			if(!$to) $to = nt_get_option('property', 'contact_email', get_bloginfo('admin_email'));
			
			$subject = __('Inquiry Property', 'theme_front');
			$property_id = get_post_meta( $post->ID, '_meta_id', true );
			if($property_id) {
				$subject .= ' #'.$property_id;
			}

			$headers[] = 'From: '.$from;
			$headers[] = 'Reply-To: '.$from;
			$headers[] = 'MIME-Version: 1.0';
			$headers[] = 'Content-type: text/html; charset=utf-8';

			$message = '<strong>From</strong>: '.$from;
			$message .= '<br /><strong>Phone</strong>: '.$phone;
			$message .= '<br /><strong>Property</strong>: <a href="'.get_the_permalink().'">'.$post->post_title.'</a>';
			$message .= '<br /><br /><strong>Message</strong>: <br />'.$msg;
			
			wp_mail( $to, $subject, $message, $headers );
			$nt_site_message = __('Your message has been sent.', 'theme_front');
		} else {
			$nt_site_message = __('There are something wrong.', 'theme_front');
		}
	}
?>

<?php 
	$gallery = get_post_meta( $post->ID, '_meta_gallery', true );
	
  //hoffman - get original cf values for the 4 optional descriptors
  $bed = floatval(get_post_meta( $post->ID, '_meta_bedroom', true ));
	$bath = floatval(get_post_meta( $post->ID, '_meta_bathroom', true ));
	$garage = floatval(get_post_meta( $post->ID, '_meta_garage', true ));
	$area = floatval(get_post_meta( $post->ID, '_meta_area', true ));
  
  //hoffman - get potential replacement values for descriptor labels
  $hoffman_custom_label_bathroom = get_post_meta( $post->ID, 'hoffman_label_bathroom', true );
  $hoffman_custom_label_bedroom = get_post_meta( $post->ID, 'hoffman_label_bedroom', true );
  $hoffman_custom_label_garage = get_post_meta( $post->ID, 'hoffman_label_garage', true );
  $hoffman_custom_label_area = get_post_meta( $post->ID, 'hoffman_label_area', true );
 
  //hoffman - set default verbage for the bedroom/bath/area/garage labels
  $hflabel_bathroom = '';
  $hflabel_bathroom_plural = 's';
  $hflabel_bedroom = '';
  $hflabel_bedroom_plural = '';
  $hflabel_garage = '';
  $hflabel_garage_plural = '';
  $hflabel_area = '';
  $hflabel_area_plural = '';
  
  //hoffman - override verbage for the bedroom/bath/area/garage labels as necessary
  
  if ($hoffman_custom_label_bathroom != ''){ 
  $hflabel_bathroom = $hoffman_custom_label_bathroom;
  $hflabel_bathroom_plural = $hoffman_custom_label_bathroom;
  };
  
  if ($hoffman_custom_label_bedroom != ''){ 
  $hflabel_bedroom = $hoffman_custom_label_bedroom;
  $hflabel_bedroom_plural = $hoffman_custom_label_bedroom;
  };
  
  if ($hoffman_custom_label_garage != ''){ 
  $hflabel_garage = $hoffman_custom_label_garage;
  $hflabel_garage_plural = $hoffman_custom_label_garage;
  };
  
  if ($hoffman_custom_label_area != ''){ 
  $hflabel_area = $hoffman_custom_label_area;
  $hflabel_area_plural = $hoffman_custom_label_area;
  };
  
  
	$price = get_post_meta( $post->ID, '_meta_price', true );
	if(!$price) $price = nt_get_option('property', 'null_price');
	$per = get_post_meta( $post->ID, '_meta_per', true );
	$id = get_post_meta( $post->ID, '_meta_id', true );
	$location = get_post_meta( $post->ID, '_meta_location', true );
	$no_location = ($location[0] == '' && $location[1] == '' && $location[2] == '')?true:false;

	$agents = get_post_meta( $post->ID, '_meta_agent', true );
	foreach($agents as $key => $agent) {
		if(get_post_status($agent) != 'publish' || $agent == '') {
			unset($agents[$key]);
		}
	}

	$details = get_post_meta( $post->ID, '_meta_detail', true );
	$user_agent = get_post_meta( $post->ID, '_meta_user_agent', true );
	$favourites = (array)get_post_meta( $post->ID, '_meta_favourites', true );
	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'marker' );

	$property_slide_timeout = nt_get_option('property', 'slide_timeout', '4000');
	$property_slide_autoplay = ($property_slide_timeout)?'true':'false';
?>

<div class="main-content">
<div class="row">

<?php if(nt_get_option('property', 'single_layout', 'sidebar') == 'sidebar-left'): ?>
	<div class="large-8 large-push-4 columns">
<?php elseif(nt_get_option('property', 'single_layout', 'sidebar') == 'full-width'): ?>
	<div class="large-12 columns">
<?php else: ?>
	<div class="large-8 columns">
<?php endif; ?>

<div class="section">
	
	<?php if($gallery): ?>
	<div class="property-hero">
	<div class="carousel-wrap">
		<div class="carousel" data-items="1" data-dots="false"  data-auto-height="true"  data-animate-out="fadeOut" data-single-item="true" data-autoplay="<?php echo $property_slide_autoplay; ?>" data-autoplay-timeout="<?php echo $property_slide_timeout; ?>" data-autoplay-hover-pause="true">
			<?php foreach($gallery as $image): 
				$img_src = wp_get_attachment_image_src($image, 'slide');
			?>
			<div class="item"><img src="<?php echo $img_src[0]; ?>" width="<?php echo $img_src[1]; ?>" height="<?php echo $img_src[2]; ?>" alt="<?php echo get_the_title($image); ?>" /></div>
			<?php endforeach; ?>
		</div>
		<?php if(count($gallery) > 1): 
			$count = count($gallery);
			if($count >= 5) $count = 5;
		?>
		<div class="carousel thumbnail-carousel" data-margin="2" data-dots="false" data-items="<?php echo $count; ?>" style="width: <?php echo $count*50-2; ?>px;">
			<?php foreach($gallery as $image): 
				$img_src = wp_get_attachment_image_src($image, 'thumbnail');
			?>
			<div class="item"><img src="<?php echo $img_src[0]; ?>" width="<?php echo $img_src[1]; ?>" height="<?php echo $img_src[2]; ?>" alt="<?php echo get_the_title($image); ?>" /></div>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
    
    
    
    <!-- hoffman : status customization-->
    
    <?php 
    $hoffman_status_label = get_the_term_list($post->ID, 'status', '<li>', '</li><li>', '</li>'); 
    
    if ( $hoffman_status_label == '<li><a href="http://www.hoffmanland.com/property-status/available/" rel="tag">Available</a></li>' ) { 
    	$hoffman_status_conditional_class = 'hoffman-status-available';
    } else { 
    	$hoffman_status_conditional_class = 'hoffman-status-unknown';
    };
        
    ?>
    
		<div class="<?php echo $hoffman_status_conditional_class; ?>">
			<ul class="meta-list">
				<?php echo $hoffman_status_label; ?>
			</ul>
		</div>


    <!-- / hoffman : status customization -->
    
    
    
	</div>
	<ul class="property-hero-list">
		<?php if($price): ?><li class="price"><?php echo nt_currency($price, $per); ?></li><?php endif; ?>
		<?php if($id): ?><li><?php _e('ID', 'theme_front'); ?>: <?php echo $id; ?></li><?php endif; ?>
	</ul>
	
	<?php if(nt_get_option('property', 'favourite', 'on') == 'on'): ?>
		<a href="#" class="add-wish-list <?php if(in_array(get_current_user_id(), $favourites)): ?>active<?php endif; ?>" data-property-id="<?php echo $post->ID; ?>"><span class="lt-icon flaticon-favorite21"></span></a>
	<?php endif; ?>
	
	</div>
	<?php endif; ?>

	<ul class="meta-box-list">
    <?php if($hflabel_bathroom): ?><li><?php echo $hflabel_bathroom; ?></li><?php endif; ?>
    <?php if($hflabel_bedroom): ?><li><?php echo $hflabel_bedroom; ?></li><?php endif; ?>    
    <?php if($hflabel_garage): ?><li><?php echo $hflabel_garage; ?></li><?php endif; ?>
    <?php if($hflabel_area): ?><li><?php echo $hflabel_area; ?></li><?php endif; ?>
	</ul>
	<div class="vspace"></div>

	<?php while ( have_posts() ) : the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; ?>

	<div class="vspace"></div><div class="vspace"></div>

	<div class="wpb_tabs wpb_content_element" data-interval="0">
	<div class="wpb_wrapper wpb_tour_tabs_wrapper ui-tabs vc_clearfix">
		
		<ul class="wpb_tabs_nav ui-tabs-nav vc_clearfix">
			<?php if($details): ?><li class="active"><a href="#tab-details"><?php _e('Details', 'theme_front'); ?></a></li><?php endif; ?>
			<?php if(!$no_location): ?><li><a href="#tab-location"><?php _e('Location', 'theme_front'); ?></a></li><?php endif; ?>
			<li><a href="#tab-contact"><?php _e('Contact', 'theme_front'); ?></a></li>
		</ul>

	<?php if($details): ?>
	<div id="tab-details" class="wpb_tab ui-tabs-panel wpb_ui-tabs-hide vc_clearfix">
	<div class="row">
		<div class="columns large-12">
		<ul class="table-list">
			<?php foreach($details as $detail):
			?>
				<li><strong><?php echo esc_html($detail['stack_title']); ?></strong> <span><?php echo esc_html($detail['detail']); ?></span></li>
			<?php endforeach; ?>
		</ul>
		</div>
	</div>
	</div>
	<?php endif; ?>		
	
	<?php if(!$no_location): ?>
	<div id="tab-location" class="wpb_tab ui-tabs-panel wpb_ui-tabs-hide vc_clearfix">
	<div class="map-outer-wrap">
		<div class="map-wrap" data-zoom="13" style="height:500px;" data-latitude="<?php echo esc_attr($location[1]); ?>" data-longitude="<?php echo esc_attr($location[2]); ?>">
			<div data-latitude="<?php echo esc_attr($location[1]); ?>" data-longitude="<?php echo esc_attr($location[2]); ?>"></div>
		</div>
		<a href="https://www.google.com/maps/?q=<?php echo wp_kses_data($location[1]); ?>,<?php echo wp_kses_data($location[2]); ?>&z=10" rel="no-follow" class="overlay-link" target="_blank"><small><?php _e('View on Google Map', 'theme_front'); ?></small></a>
	</div>
	</div>
	<?php endif; ?>


	<div id="tab-contact" class="wpb_tab ui-tabs-panel wpb_ui-tabs-hide vc_clearfix">
	<div class="row">
		<div class="columns large-7">

		<?php if(nt_get_option('property', 'contact_note')): ?>
			<div class="contact-note">
			<?php echo apply_filters('the_content', nt_get_option('property', 'contact_note')); ?>
			</div>
		<?php endif; ?>

		<?php 
			if($agents)
			foreach($agents as $agent):
				if($agent):
				$agent_post = get_post($agent);
				$phone = get_post_meta( $agent, '_meta_phone', true );
				$email = sanitize_email(get_post_meta( $agent, '_meta_email', true ));
				$description = $agent_post->post_content;
		?>
		<div class="agent-card clearfix">
			<a href="<?php echo get_the_permalink($agent); ?>">
				<?php echo get_the_post_thumbnail( $agent, 'thumbnail', array('class'=>'thumb') ); ?>
			</a>
			<div class="title"><a href="<?php echo get_the_permalink($agent); ?>"><?php echo wp_kses_data($agent_post->post_title); ?></a></div>
			<div class="sub">
				<ul class="inline-list">
					<?php if($phone): ?><li><?php echo wp_kses_data($phone); ?></li><?php endif; ?><?php if($email): ?><li><a href="mailto:<?php echo antispambot($email); ?>"><?php echo antispambot($email); ?></a></li><?php endif; ?>
				</ul>
			</div>
			<?php if($description && count($agents) == 1): ?><div class="bio"><?php echo wp_trim_words($description, 75); ?></div><?php endif; ?>
		</div>
		<?php endif; endforeach; ?>
		<?php if($user_agent): 
			$user = get_user_by('id', $user_agent);
			$user_agent_phone = get_user_meta($user_agent, 'phone', true);
			$user_agent_display_name = get_user_meta($user_agent, 'display_name', true);
			if(!$user_agent_display_name) $user_agent_display_name = get_user_meta($user_agent, 'nickname', true);
			$user_agent_description = get_user_meta($user_agent, 'description', true);
		?>
		<div class="agent-card clearfix">
			<?php echo get_avatar($user->user_email, 512, '', $user_agent_display_name); ?>
			<div class="title"><?php echo wp_kses_data($user_agent_display_name); ?></div>
			<div class="sub">
				<ul class="inline-list">
					<?php if($user_agent_phone): ?><li><?php echo wp_kses_data($user_agent_phone); ?></li><?php endif; ?><?php if($user->user_email): ?><li><a href="mailto:<?php echo antispambot($user->user_email); ?>"><?php echo antispambot($user->user_email); ?></a></li><?php endif; ?>
				</ul>
			</div>
			<?php if($user_agent_description && count($agents) == 0): ?><div class="bio"><?php echo wp_kses_data($user_agent_description); ?></div><?php endif; ?>
		</div>
		<?php endif; ?>
		</div>
		<div class="columns large-5">
			<script type="text/javascript">
			 var RecaptchaOptions = {
			    theme : 'custom',
			    custom_theme_widget: 'recaptcha_widget'
			 };
			 </script>
			<form method="post" class="validate-form agent-contact-form">
				<p><input type="text" name="from" placeholder="<?php _e('Email Address', 'theme_front'); ?> *" data-rule-required="true" data-rule-email="true" data-msg-required="Email Address is required." data-msg-email="Invalid Email address."/></p>
				<p><input type="text" name="phone" placeholder="<?php _e('Phone Number', 'theme_front'); ?>" /></p>
				<p><textarea name="message" placeholder="<?php _e('Message', 'theme_front'); ?>" rows="5"></textarea></p>
				<p>
				<?php if(!empty($agents) || $user_agent): ?>
					<select name="to" class="select-box">
						<option value=""><?php _e('Send message to', 'theme_front'); ?></option>
						<?php 
							foreach($agents as $agent):
							if(!$agent) break;
							$agent_post = get_post($agent);
							$email = sanitize_email(get_post_meta( $agent, '_meta_email', true ));
						?>
						<option value="<?php echo esc_attr($email); ?>"><?php echo wp_kses_data($agent_post->post_title); ?></option>
						<?php endforeach; ?>
						<?php 
							if($user_agent): 
							$user = get_user_by('id', $user_agent);
							$user_agent_display_name = get_user_meta($user_agent, 'display_name', true);
							if(!$user_agent_display_name) $user_agent_display_name = get_user_meta($user_agent, 'nickname', true);

						?>
						<option value="<?php echo esc_attr($user->user_email); ?>"><?php echo wp_kses_data($user_agent_display_name); ?></option>
						<?php endif; ?>
					</select>
					<?php endif; ?>
				</p>
    <?php if(nt_get_option('advance', 'recaptchar_site_key') && nt_get_option('advance', 'recaptchar_secret_key')): ?>
    <div id="recaptcha_widget" style="display:none">
	   <div id="recaptcha_image"></div>
	   <div class="recaptcha_only_if_incorrect_sol" style="color:red">Incorrect please try again</div>
	   <input type="text" id="recaptcha_response_field" name="recaptcha_response_field" placeholder="<?php _e('Enter the words above', 'theme_front'); ?> *" data-rule-required="true" data-msg-required="reCAPTCHAR is required." />

	   <div class="refresh"><a href="javascript:Recaptcha.reload()"><span class="lt-icon flaticon-refresh8"></span></a></div>
 	</div>

	 <script type="text/javascript"
	    src="http://www.google.com/recaptcha/api/challenge?k=<?php echo nt_get_option('advance', 'recaptchar_site_key'); ?>">
	 </script>
	 <noscript>
	   <iframe src="http://www.google.com/recaptcha/api/noscript?k=<?php echo nt_get_option('advance', 'recaptchar_site_key'); ?>"
	        height="300" width="500" frameborder="0"></iframe><br>
	   <textarea name="recaptcha_challenge_field" rows="3" cols="40">
	   </textarea>
	   <input type="hidden" name="recaptcha_response_field"
	        value="manual_challenge">
	 </noscript>
	<?php endif; ?>

				<div class="form-response"></div>
				<input type="submit" name="submit" class="full-width primary lt-button" value="<?php _e('Submit', 'theme_front'); ?>" />
			</form>
		</div>
	</div>
	</div>
	
	</div> 
	</div>

	<?php if( nt_get_option('property', 'single_share', 'on') == 'on' ) get_template_part('section/section', 'share'); ?>

	<?php 
		$tax_query['relation'] = 'OR';
		$cur_locations = wp_get_post_terms( $post->ID, 'location', array('fields' => 'ids') );
		if($cur_locations) {
			$tax_query[] = array(
							'taxonomy' => 'location',
							'field'    => 'id',
							'terms'    => $cur_locations,
							'operator' => 'IN'
						);
		}
		$cur_type = wp_get_post_terms( $post->ID, 'type', array('fields' => 'ids') );
		// if($cur_type) {
		// 	$tax_query[] = array(
		// 					'taxonomy' => 'type',
		// 					'field'    => 'id',
		// 					'terms'    => $cur_type,
		// 					'operator' => 'IN'
		// 				);
		// }
		$properties = get_posts(array('post_type' => 'property', 'post_status' => 'publish', 'posts_per_page' => 4, 'post__not_in' => array($post->ID), 'tax_query' => $tax_query));
		
		if($properties):
	?>
	<div class="vspace" style="height: 60px;"></div>
	<h3><?php _e('Related Properties', 'theme_front'); ?></h3>
	<div class="vspace" style="height: 15px;"></div>
	<ul class="large-block-grid-2 medium-block-grid-2">
	<?php 
		foreach($properties as $property): ?>
			<li><?php nt_property_list($property->ID); ?></li>
	<?php endforeach; ?>
	</ul>
	<?php endif; ?>

</div>
</div>

<?php if(nt_get_option('property', 'single_layout', 'sidebar') != 'full-width'): ?>
	<?php if(nt_get_option('property', 'single_layout', 'sidebar') == 'sidebar'): ?>
		<aside class="sidebar large-4 columns">
	<?php else: ?>
		<aside class="sidebar sidebar-left large-4 large-pull-8 columns">
	<?php endif; ?>
	<div class="section">
		<?php if ( dynamic_sidebar( 'property' ) ); ?>
	</div>
	</aside>
<?php endif; ?>

</div><!-- .row -->
</div><!-- #content -->

<?php get_footer(); ?>