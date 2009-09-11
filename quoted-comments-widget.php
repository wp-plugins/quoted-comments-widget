<?php
/*
Plugin Name: Quoted Comments Widget
Description: Adds a widget which shows the most recent comments, with quotes.
Author: Rattle
Author URI: http://www.rattlecentral.com
Version: 0.1
*/

/* Note currently hard-coded. NOT for wider distribution... */

class QuotedCommentsWidget extends WP_Widget {

	function QuotedCommentsWidget() {
		$widget_ops = array('classname' => 'quoted_comments_widget', 'description' => __('Display recent comments, with quotes.'));
		$this->WP_Widget('quoted_comments', __('Quoted Recent Comments'), $widget_ops, $control_ops);

	}

	function widget( $args, $instance ) {
			global $wpdb, $comments, $comment;

			extract($args, EXTR_SKIP);
			$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Comments') : $instance['title']);
			if ( !$number = (int) $instance['number'] )
				$number = 5;
			else if ( $number < 1 )
				$number = 1;
			else if ( $number > 15 )
				$number = 15;

			if ( !$comments = wp_cache_get( 'quoted_recent_comments', 'widget' ) ) {
				$comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_approved = '1' ORDER BY comment_date_gmt DESC LIMIT 15");
				wp_cache_add( 'quoted_recent_comments', $comments, 'widget' );
			}

			$comments = array_slice( (array) $comments, 0, $number );
	?>
			<?php echo $before_widget; ?>
				<?php if ( $title ) echo $before_title . $title . $after_title; ?>
				<ul id="recentcomments"><?php
				if ( $comments ) : foreach ( (array) $comments as $comment) :
				echo  '<li class="recentcomments">';

				echo '<p class="content">“' . get_comment_excerpt() . '”</p>';
				
				echo '<a class="comment-author" href="' . get_comment_link($comment->comment_ID) . '">' . get_comment_author() . '</a> on <a href="' . get_permalink($comment->comment_post_ID) . '">' . get_the_title($comment->comment_post_ID) . '</a>';
					
					echo '</li>';
				endforeach; endif;?></ul>
			<?php echo $after_widget; ?>
	<?php
	}

	function flush_widget_cache() {
		wp_cache_delete('quoted_recent_comments', 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_quoted_recent_comments']) )
			delete_option('widget_quoted_recent_comments');

		return $instance;
	}

	function form( $instance ) {
		$title = strip_tags($instance['title']);
		$number = isset($instance['number']) ? absint($instance['number']) : 5;

?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of comments to show:'); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /><br />
		<small><?php _e('(at most 15)'); ?></small></p>

<?php
	}
}

add_action('widgets_init', create_function('', 'return register_widget("QuotedCommentsWidget");'));


?>