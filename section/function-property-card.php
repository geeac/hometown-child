<?php
function nt_property_card($post_id) {
	$bed = floatval(get_post_meta( $post_id, '_meta_bedroom', true ));
	$bath = floatval(get_post_meta( $post_id, '_meta_bathroom', true ));
	$garage = floatval(get_post_meta( $post_id, '_meta_garage', true ));
	$area = floatval(get_post_meta( $post_id, '_meta_area', true ));
	$price = get_post_meta( $post_id, '_meta_price', true );
	if(!$price) $price = nt_get_option('property', 'null_price');
	$per = get_post_meta( $post_id, '_meta_per', true );
?>
<div class="card">
<div class="img-wrap">
  
  <?php if (get_the_post_thumbnail($post_id, 'card')) { ?>
	<a href="<?php echo get_the_permalink($post_id); ?>"><?php echo get_the_post_thumbnail($post_id, 'card'); ?></a>
<?php } else { ?>
  <a href="<?php echo get_the_permalink($post_id); ?>"><img src="http://beta.hoffmanland.com/wp-content/uploads/2017/09/real-estate-home-placeholder-v3.jpg" />
</a>
  <?php }; ?>



  <!-- hoffman : status customization -->

    <?php 
    $hoffman_status_label = get_the_term_list($post_id, 'status', '<li>', '</li><li>', '</li>');
    echo '<!-- hoffman status returned : ' . $hoffman_status_label . ' -->';    
    if ( $hoffman_status_label == '<li><a href="http://www.hoffmanland.com/property-status/available/" rel="tag">Available</a></li>' ){
    $hoffman_status_conditional_class = 'hoffman-status-available';
    } else { 
    $hoffman_status_conditional_class = 'hoffman-status-unknown';    
    };
        
    ?>
    <div class="badge">
      <div class="<?php echo $hoffman_status_conditional_class; ?>">
        <ul class="meta-list">
          <?php echo $hoffman_status_label; ?>
        </ul>
      </div>


      <!-- / hoffman : status customization -->
    
    
		<?php if($price): ?><div class="price"><?php echo nt_currency($price, $per); ?></div><?php endif; ?>
	</div>
</div>
<div class="content-wrap">
<div class="title"><a href="<?php echo get_the_permalink($post_id); ?>"><?php echo get_the_title($post_id); ?></a></div>

   
  
<ul class="meta-list">
<?php echo get_the_term_list($post_id, 'location', '<li>', '</li><li>', '</li>'); ?>
</ul>

  
  
  <ul class="meta-box-list">
	<?php if($area): ?><li><i class="lt-icon flaticon-display6"></i> <?php echo number_format($area); ?> <?php echo nt_get_option('property', 'area'); ?></li><?php endif; ?>
	<li class="right">
		<?php if($bed): ?><i class="lt-icon flaticon-person1 big"></i> <?php echo wp_kses_data($bed); ?> <?php endif; ?>
		<?php if($bath): ?><i class="lt-icon flaticon-shower5"></i> <?php echo wp_kses_data($bath); ?> <?php endif; ?>
		<?php if($garage): ?><i class="lt-icon flaticon-car95"></i>  
		<?php echo wp_kses_data($garage); ?><?php endif; ?>
	</li>
</ul>
</div>
</div>
<?php } ?>