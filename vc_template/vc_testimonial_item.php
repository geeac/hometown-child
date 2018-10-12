<?php
extract(shortcode_atts(array(
    'name' => '',
    'quote' => '',
    'rating' => '',
    'meta' => '',
), $atts));
$meta = ($meta) ? ' - '.$meta : $meta;
?>
<blockquote class="item">
	<section><?php echo apply_filters('the_content', $quote); ?></section>
	<footer>
		<?php if($rating): ?>
		<div class="rating">
			<?php for($i=1; $i<=5; $i++): ?>
				<?php if($i<=$rating): ?><i class="nt-icon-star-1"></i><?php endif; ?>
				<?php if($i>$rating): ?><i class="nt-icon-star-1 inactive"></i><?php endif; ?>
			<?php endfor; ?>
			</div>
		<?php endif; ?>
		<?php echo wp_kses_data($name); ?><?php echo wp_kses_data($meta); ?></footer>
</blockquote>