<?php
/**
 * Team Post Type
 *
 * @package   Team_Post_Type
 * @license   GPL-2.0+
 */

/**
 * Register post types and taxonomies.
 *
 * @package Team_Post_Type
 */
class Team_Post_Type_Registrations {

	public $post_type = 'team';

	public $taxonomies = array( 'team-category' );

	public function init() {
		// Add the team post type and taxonomies
		add_action( 'init', array( $this, 'register' ) );
	}

	/**
	 * Initiate registrations of post type and taxonomies.
	 *
	 * @uses Team_Post_Type_Registrations::register_post_type()
	 * @uses Team_Post_Type_Registrations::register_taxonomy_category()
	 */
	public function register() {
		$this->register_post_type();
		$this->register_taxonomy_category();
	}

	/**
	 * Register the custom post type.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	protected function register_post_type() {
		$labels = array(
			'name'               => __( 'Team', 'rivalmind-team' ),
			'singular_name'      => __( 'Team Member', 'rivalmind-team' ),
			'add_new'            => __( 'Add Profile', 'rivalmind-team' ),
			'add_new_item'       => __( 'Add Profile', 'rivalmind-team' ),
			'edit_item'          => __( 'Edit Profile', 'rivalmind-team' ),
			'new_item'           => __( 'New Team Member', 'rivalmind-team' ),
			'view_item'          => __( 'View Profile', 'rivalmind-team' ),
			'search_items'       => __( 'Search Team', 'rivalmind-team' ),
			'not_found'          => __( 'No profiles found', 'rivalmind-team' ),
			'not_found_in_trash' => __( 'No profiles in the trash', 'rivalmind-team' ),
		);

		$supports = array(
			'title',
			'editor',
			'thumbnail',
			'custom-fields',
			'revisions',
			'page-attributes',
		);

		$args = array(
			'labels'          => $labels,
			'supports'        => $supports,
			'public'          => true,
			'capability_type' => 'post',
			'rewrite'         => array( 'slug' => 'team', ), // Permalinks format
			'menu_position'   => 5,
			'menu_icon'       => 'dashicons-id',
			'hierarchical'    => false,
		);

		$args = apply_filters( 'team_post_type_args', $args );

		register_post_type( $this->post_type, $args );
	}

	/**
	 * Register a taxonomy for Team Categories.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	protected function register_taxonomy_category() {
		$labels = array(
			'name'                       => __( 'Team Categories', 'rivalmind-team' ),
			'singular_name'              => __( 'Team Category', 'rivalmind-team' ),
			'menu_name'                  => __( 'Team Categories', 'rivalmind-team' ),
			'edit_item'                  => __( 'Edit Team Category', 'rivalmind-team' ),
			'update_item'                => __( 'Update Team Category', 'rivalmind-team' ),
			'add_new_item'               => __( 'Add New Team Category', 'rivalmind-team' ),
			'new_item_name'              => __( 'New Team Category Name', 'rivalmind-team' ),
			'parent_item'                => __( 'Parent Team Category', 'rivalmind-team' ),
			'parent_item_colon'          => __( 'Parent Team Category:', 'rivalmind-team' ),
			'all_items'                  => __( 'All Team Categories', 'rivalmind-team' ),
			'search_items'               => __( 'Search Team Categories', 'rivalmind-team' ),
			'popular_items'              => __( 'Popular Team Categories', 'rivalmind-team' ),
			'separate_items_with_commas' => __( 'Separate team categories with commas', 'rivalmind-team' ),
			'add_or_remove_items'        => __( 'Add or remove team categories', 'rivalmind-team' ),
			'choose_from_most_used'      => __( 'Choose from the most used team categories', 'rivalmind-team' ),
			'not_found'                  => __( 'No team categories found.', 'rivalmind-team' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => 'team-category' ),
			'show_admin_column' => true,
			'query_var'         => true,
		);

		$args = apply_filters( 'team_post_type_category_args', $args );

		register_taxonomy( $this->taxonomies[0], $this->post_type, $args );
	}
}