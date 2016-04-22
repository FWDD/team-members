<?php

function fwdd_team_help_tabs() {
	$screen = get_current_screen();

	if ('edit' === $screen->base && 'project' === $screen->post_type) {
		$tabs = array(
			array(
				'title'   => __('Overview'),
				'id'      => 'RM_team_overview',
				'content' => '<p>' . __('This screen provides access to team member profiles.', 'fwdd-team') . '</p>'
			),
			array(
				'title'   => __('Using Team Profiles', 'fwdd-team'),
				'id'      => 'RM_team_usage',
				'content' => '<p>' . __('To display the team profiles, use the fwdd Team widget. Click on <a href="widgets.php">Widgets</a> under Appearance.', 'fwdd-team') . '</p>'
			)
		);

		foreach ($tabs as $tab) {
			$screen->add_help_tab($tab);
		}

		$screen->set_help_sidebar('<a href="#">More info!</a>');
	}

	if ('post' === $screen->base && 'team' === $screen->post_type) {
		$tabs = array(
			array(
				'title'   => __('Title and Body', 'fwdd-team'),
				'id'      => 'RM_team_overview',
				'content' => '<p>' . __('The title will be the name of the team member. The body will be information about the team member.', 'fwdd-team') . '</p>'
			),
			array(
				'title'   => __('Profile Fields', 'fwdd-team'),
				'id'      => 'RM_team_details',
				'content' => '<p>' . __('This box allows you to enter the job title and social network links for the team member.', 'fwdd-team') . '</p>'
			),
			array(
				'title'   => 'Featured Image',
				'id'      => 'RM_team_image',
				'content' => '<p>' . __('The featured image will be shown next to the team member as a small thumbnail image.', 'fwdd-team') . '</p>'
			)
		);

		foreach ($tabs as $tab) {
			$screen->add_help_tab($tab);
		}

		$screen->set_help_sidebar('<a href="#">More info!</a>');
	}
}

add_action('load-post-new.php', 'fwdd_team_help_tabs');
add_action('load-post.php', 'fwdd_team_help_tabs');
add_action('load-edit.php', 'fwdd_team_help_tabs');