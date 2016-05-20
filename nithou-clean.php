<?php

/**
	* Plugin Name: Simplifier - Simon Vandereecken
	* Plugin URI: http://www.vandereecken.me
	* Description: Simplify the dashboard & menu access for the users
	* Version: 0.1
	* Author: Simon Vandereecken
	* Author URI: http://www.vandereecken.me
**/

/* Remove menu items */
add_action( 'admin_menu', 'remove_menus' );
function remove_menus(){
	if ( !current_user_can( 'manage_options' ) ) {
		remove_menu_page( 'tools.php' );
		remove_menu_page( 'options-general.php' );
	}
}

/* Remove widgets from dashboard*/

function remove_dashboard_meta() {
        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
}
add_action( 'admin_init', 'remove_dashboard_meta' );

/* Create simple help widget */

add_action( 'wp_dashboard_setup', 'register_my_dashboard_widget' );
function register_my_dashboard_widget() {
	wp_add_dashboard_widget(
		'my_dashboard_widget',
		'Website Guidelines',
		'my_dashboard_widget_display'
	);

}

/* Add quick help widget */

function my_dashboard_widget_display() {
    ?>
    <p>Hello, welcome to your website, here are some quick guidelines to get you started!</p>

	<h4><strong>Images</strong></h4>
    <p>Please make sure to always add good title and proper alt text to images. This makes single attachment pages better and does some SEO magic as well.</p> 

	<h4><strong>Important Links</strong></h4>
    <ul>
		<li><a href='<?php echo admin_url("post-new.php") ?>'>New Post</a></li>
		<li><a href='<?php echo admin_url("profile.php") ?>'>Your Profile</a></li>
    </ul>


    <?php
}

/* Redirect users to front page after login */

function acme_login_redirect( $redirect_to, $request, $user  ) {
	return ( is_array( $user->roles ) && in_array( 'administrator', $user->roles ) ) ? admin_url() : site_url();
}
add_filter( 'login_redirect', 'acme_login_redirect', 10, 3 );
