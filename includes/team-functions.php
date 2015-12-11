<?php

/**
 * Get Team
 *
 * @param  int $posts_per_page The number of team profiles you want to display
 * @param  string $orderby The order by setting
 *
 * @link https://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters
 *
 * @param  array $team_id The ID or IDs of the team(s), comma separated
 *
 * @return  string  Formatted HTML
 */
if ( ! function_exists( 'get_team' ) ):
	function get_team( $posts_per_page = - 1, $category = null, $team_id = null, $excerpt = false ) {
		$args = array(
			'posts_per_page' => (int) $posts_per_page,
			'post_type'      => 'team',
			'orderby'        => 'menu_order',
			'no_found_rows'  => true,
			'post_status'    => 'publish',
		);
		if ( $team_id ) {
			$args['post__in'] = array( $team_id );
		}
		if ( $category ) {
			$args['cat'] = $category;
		}

		$query = new WP_Query( $args );
		//TODO Make sure we have an avatar or use the image supplied by the user.
		$team = '';
		// Create a counter for the data-target attribute on each team member link
		$count = 0;
		if ( $query->have_posts() ) {
			$team .= '<div class="RivalMind-team"><ul class="team">';
			while ( $query->have_posts() ) : $query->the_post();
				$post_id = get_the_ID();
				$meta    = get_post_custom( $post_id );
				$title   = ! isset( $meta['profile_title'][0] ) ? '' : $meta['profile_title'][0];
				$links   = '';
				if ( ! empty( $meta['profile_twitter'][0] ) ) {
					$links .= '<li><a href="' . $meta['profile_twitter'][0] . '"><span class="screen-reader-text">Twitter</span></a></li>';
				}
				if ( ! empty( $meta['profile_linkedin'][0] ) ) {
					$links .= '<li><a href="' . $meta['profile_linkedin'][0] . '"><span class="screen-reader-text">LinkedIn</span></a></li>';
				}
				if ( ! empty( $meta['profile_facebook'][0] ) ) {
					$links .= '<li><a href="' . $meta['profile_facebook'][0] . '"><span class="screen-reader-text">Facebook</span></a></li>';
				}
				if ( ! empty( $meta['profile_email'][0] ) ) {
					$links .= '<li><a href="mailto:' . $meta['profile_email'][0] . '"><span class="screen-reader-text">' . $meta['profile_email'][0] . '</span></a></li>';
				}
				$image = ! has_post_thumbnail() ? '' : wp_get_attachment_image( get_post_thumbnail_id(), 'thumbnail' );

				$team .= '<li><a href="' . esc_url( get_permalink() ) . '" data-target="' . $count . '">';
				$team .= '<span class="team-image">' . $image . '</span>';
				$team .= '<h6 class="team-name">' . get_the_title() . '</h6>';
				$team .= '<span class="job-title">' . $title . '</span>';
				$team .= '</a>';
				if ( ! empty( $links ) ) {
					$team .= '<ul class="team-links">' . $links . '</ul>';
				}
				$team .= '</li>';
				// Increment data-target counter
				$count++;
			endwhile;
			wp_reset_postdata();
			$team .= '</ul></div>';
		}

		return $team;
	}
endif;


/**
 * Display Team
 *
 * @param int $posts_per_page
 * @param string $orderby
 * @param null $team_id
 */
if ( ! function_exists( 'the_team' ) ):
	function the_team( $posts_per_page = - 1, $category = null, $team_id = null ) {
		echo get_team( $posts_per_page, $category, $team_id );
	}
endif;

if ( ! function_exists( 'load_team_styles' ) ):
	function load_team_styles() {
		wp_enqueue_style( 'team-styles', plugins_url( 'css/styles.css', dirname( __FILE__ ) ) );
	}

	add_action( 'wp_enqueue_scripts', 'load_team_styles' );
endif;

if ( ! function_exists( 'team_shortcode' ) ):
	function team_shortcode( $atts ) {
		$a = shortcode_atts( array(
			'posts_per_page' => -1,
			'category' => null,
			'team_id'  => null,
		), $atts );

		return get_team($a['posts_per_page'], $a['category'], $a['team_id']);
	}
endif;
// TODO should be called on init hook
add_shortcode( 'team', 'team_shortcode' );