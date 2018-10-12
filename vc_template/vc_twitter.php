<?php
extract(shortcode_atts(array(
    'account'	=> 'twitter'
), $atts));

function nt_relative_time($ts)
{
    if(!ctype_digit($ts))
        $ts = strtotime($ts);

    $diff = time() - $ts;
    if($diff == 0)
        return 'now';
    elseif($diff > 0)
    {
        $day_diff = floor($diff / 86400);
        if($day_diff == 0)
        {
            if($diff < 60) return 'just now';
            if($diff < 120) return '1 minute ago';
            if($diff < 3600) return floor($diff / 60) . ' minutes ago';
            if($diff < 7200) return '1 hour ago';
            if($diff < 86400) return floor($diff / 3600) . ' hours ago';
        }
        if($day_diff == 1) return 'Yesterday';
        if($day_diff < 7) return $day_diff . ' days ago';
        if($day_diff < 31) return ceil($day_diff / 7) . ' weeks ago';
        if($day_diff < 60) return 'last month';
        return date('F Y', $ts);
    }
    else
    {
        $diff = abs($diff);
        $day_diff = floor($diff / 86400);
        if($day_diff == 0)
        {
            if($diff < 120) return 'in a minute';
            if($diff < 3600) return 'in ' . floor($diff / 60) . ' minutes';
            if($diff < 7200) return 'in an hour';
            if($diff < 86400) return 'in ' . floor($diff / 3600) . ' hours';
        }
        if($day_diff == 1) return 'Tomorrow';
        if($day_diff < 4) return date('l', $ts);
        if($day_diff < 7 + (7 - date('w'))) return 'next week';
        if(ceil($day_diff / 7) < 4) return 'in ' . ceil($day_diff / 7) . ' weeks';
        if(date('n', $ts) == date('n') + 1) return 'next month';
        return date('F Y', $ts);
    }
}

?>

<?php 

if( is_plugin_active('oauth-twitter-feed-for-developers/twitter-feed-for-developers.php') ): ?>
	<div class="tweet nt-twitter">
	<ul class="tweet_list">
	<?php $tweets = getTweets($account, 1); 
	
		if(!isset($tweets['error'])): foreach( $tweets as $tweet): 
			if($tweet['text']) {
				$the_tweet = $tweet['text'];
	        
		       	if(is_array($tweet['entities']['user_mentions'])){
		            foreach($tweet['entities']['user_mentions'] as $key => $user_mention){
		                $the_tweet = preg_replace(
		                    '/@'.$user_mention['screen_name'].'/i',
		                    '<a href="http://www.twitter.com/'.$user_mention['screen_name'].'" target="_blank">@'.$user_mention['screen_name'].'</a>',
		                    $the_tweet);
		            }
		        }

		        if(is_array($tweet['entities']['hashtags'])){
		            foreach($tweet['entities']['hashtags'] as $key => $hashtag){
		                $the_tweet = preg_replace(
		                    '/#'.$hashtag['text'].'/i',
		                    '<a href="https://twitter.com/search?q=%23'.$hashtag['text'].'&src=hash" target="_blank">#'.$hashtag['text'].'</a>',
		                    $the_tweet);
		            }
		        }

		        if(is_array($tweet['entities']['urls'])){
		            foreach($tweet['entities']['urls'] as $key => $link){
		                $the_tweet = preg_replace(
		                    '`'.$link['url'].'`',
		                    '<a href="'.esc_url($link['url']).'" target="_blank">'.$link['display_url'].'</a>',
		                    $the_tweet);
		            }
		        }
		         
			} else {
				$the_tweet = '';
			}	
		?>
		<li>
		<blockquote>
			<section><?php echo $the_tweet; ?></section>
			<footer><i class='nt-icon-twitter'></i> <a href="https://twitter.com/<?php echo wp_kses_data($account); ?>"><?php echo wp_kses_data($account); ?></a> <i class='nt-icon-clock-1'></i> <?php echo '<a href="https://twitter.com/YOURUSERNAME/status/'.$tweet['id_str'].'" target="_blank">
                '.nt_relative_time($tweet['created_at']).'
            </a>'; ?></footer>
		</blockquote>
		</li>
	<?php endforeach; else: ?>
		<li>
		<p style="text-align: center;"><?php echo wp_kses_data($tweets['error']); ?></p>
		</li>
	<?php endif; ?>
	</ul>
	</div>
<?php else: ?>
<p style="text-align: center;">Please install <a href="https://wordpress.org/plugins/oauth-twitter-feed-for-developers/">oAuth Twitter Feed for Developers</a> plugin and set API info at "WP-Admin > Settings > Twitter Feed Auth"</p>
<?php endif; ?>

