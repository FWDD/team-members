<?php
/**
 * FWDD Team Widget
 */

class FWDD_Team_Widget extends WP_Widget {

	public function __construct() {
		$widget_ops = array( 'classname' => 'team_widget', 'description' => __('Display Team post type', 'fwdd-team') );
		parent::__construct( 'team_widget', __('FWDD Team', 'fwdd-team'), $widget_ops );
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$posts_per_page = (int) $instance['posts_per_page'];
		$category = (int) $instance['category'];
		$team_id = ( null == $instance['team_id'] ) ? '' : strip_tags( $instance['team_id'] );

		echo $args['before_widget'];

		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];

		echo get_team( $posts_per_page, $category, $team_id );

		echo $args['after_widget'];
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
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'posts_per_page' => -1, 'category' => 'none', 'team_id' => null ) );
		$title = strip_tags( $instance['title'] );
		$posts_per_page = (int) $instance['posts_per_page'];
		$category = (int) $instance['category'];
		$team_id = ( null == $instance['team_id'] ) ? '' : strip_tags( $instance['team_id'] );
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'fwdd-team');?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>"><?php _e('Number of Profiles:(-1 for all)', 'fwdd-team');?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" type="text" value="<?php echo esc_attr( $posts_per_page ); ?>" />
		</p>

		<p><label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e('Category', 'fwdd-team');?></label>
			<?php wp_dropdown_categories(array(
				'name' => $this->get_field_name('category'),
				'id' => $this->get_field_id('category'),
				'hierarchical' => true,
				'orderby' => 'name',
				'selected' => $category,
				'show_option_none' => __('Recent Profiles', 'fwdd-team'),
				'taxonomy' => 'team-category'
			)); ?>
		</p>

		<p><label for="<?php echo $this->get_field_id( 'team_id' ); ?>"><?php _e('Team IDs (optional)', 'fwdd-team');?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'team_id' ); ?>" name="<?php echo $this->get_field_name( 'team_id' ); ?>" type="text" value="<?php echo $team_id; ?>" />
		<i><?php _e('List of IDs to show only specific team members Example:1,3,10.', 'fwdd-team');?></i>
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
	register_widget( 'FWDD_Team_Widget' );
}