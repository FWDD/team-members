<?php
/**
 * Team Widget
 */

/**
 * Team Widget
 */
class Team_Widget extends WP_Widget {
	private $text_domain;

	public function __construct() {
		$this->text_domain = 'rivalmind-team';
		$widget_ops = array( 'classname' => 'team_widget', 'description' => __('Display Team post type', $this->text_domain) );
		parent::__construct( 'team_widget', __('RivalMind Team', $this->text_domain), $widget_ops );
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$posts_per_page = (int) $instance['posts_per_page'];
		$category = (int) $instance['category'];
		$team_id = ( null == $instance['team_id'] ) ? '' : strip_tags( $instance['team_id'] );

		echo $before_widget;

		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;

		echo get_team( $posts_per_page, $category, $team_id );

		echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['posts_per_page'] = (int) $new_instance['posts_per_page'];
		$instance['category'] = (int) $new_instance['category'];
		$instance['team_id'] = ( null == $new_instance['team_id'] ) ? '' : strip_tags( $new_instance['team_id'] );

		return $instance;
	}

	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'posts_per_page' => '1', 'category' => 'none', 'team_id' => null ) );
		$title = strip_tags( $instance['title'] );
		$posts_per_page = (int) $instance['posts_per_page'];
		$category = (int) $instance['category'];
		$team_id = ( null == $instance['team_id'] ) ? '' : strip_tags( $instance['team_id'] );
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', $this->text_domain);?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>"><?php _e('Number of Profiles:', $this->text_domain);?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" type="text" value="<?php echo esc_attr( $posts_per_page ); ?>" />
		</p>

		<p><label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e('Category', $this->text_domain);?></label>
			<?php wp_dropdown_categories(array(
				'name' => $this->get_field_name('category'),
				'id' => $this->get_field_id('category'),
				'hierarchical' => true,
				'orderby' => 'name',
				'selected' => $category,
				'show_option_none' => __('Recent Profiles', $this->text_domain),
				'taxonomy' => 'team-category'
			)); ?>
		</p>

		<p><label for="<?php echo $this->get_field_id( 'team_id' ); ?>"><?php _e('Team IDs (optional)', $this->text_domain);?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'team_id' ); ?>" name="<?php echo $this->get_field_name( 'team_id' ); ?>" type="text" value="<?php echo $team_id; ?>" />
		<i><?php _e('List of IDs to show only specific team members Example:1,3,10.', $this->text_domain);?></i>
		</p>
		<?php
	}
}

add_action( 'widgets_init', 'register_team_widget' );
/**
 * Register widget
 *
 * This functions is attached to the 'widgets_init' action hook.
 */
function register_team_widget() {
	register_widget( 'Team_Widget' );
}