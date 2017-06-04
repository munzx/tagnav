<?php
/*
Plugin Name: tagnav
Plugin URI: github.com/munzx/tagnav
Description: Changes nav menu according to page's tag, usefull for mutli-language content
Version: 0.1
Author: Munzir Suliman
Author URI: github.com/munzx
License: GPL2
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

//Filter the nav menu
function customNavFilter($args){
	if($args['theme_location'] == 'primary') {
		$tags = get_the_tags()[0];
		$nav_params = array(
			"theme_location"=>"primary",
			"menu_id"=>"primary",
			"menu_class"=>"primary",
			"menu"=> $tags->name
			);

		return array_merge( $args, $nav_params);
	} else {
		return $args;
	}
}


//add tag support to pages
function tags_support_all() {
	register_taxonomy_for_object_type('post_tag', 'page');
}
// ensure all tags are included in queries
function tags_support_query($wp_query) {
	if ($wp_query->get('tag')){
		$wp_query->set('post_type', 'any');
	}
}

//add nav filter
add_filter( 'wp_nav_menu_args', 'customNavFilter');

// tag hooks
add_action('init', 'tags_support_all');
add_action('pre_get_posts', 'tags_support_query');

?>
