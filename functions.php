/* **************************************************************
Add the following code to your WordPress theme's functions.php file 
************************************************************** */

/* *******************************
Remove Query String from Static Resources
******************************* */
add_filter( 'style_loader_src', 'remove_cssjs_ver', 10, 2 );
add_filter( 'script_loader_src', 'remove_cssjs_ver', 10, 2 );
function remove_cssjs_ver( $src ) {
  if( strpos( $src, '?ver=' ) )
  $src = remove_query_arg( 'ver', $src );
  return $src;
}

/* *******************************
Remove Emojis
******************************* */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

/* *******************************
Remove Shortlink
******************************* */
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

/* *******************************
Disable Embed
******************************* */
add_action( 'wp_footer', 'disable_embed' );
function disable_embed(){
  wp_dequeue_script( 'wp-embed' );
}

/* *******************************
Disable XML-RPC
******************************* */
add_filter('xmlrpc_enabled', '__return_false');

/* *******************************
Remove RSD Link
******************************* */
remove_action( 'wp_head', 'rsd_link' ) ;

/* *******************************
Hide Version
******************************* */
remove_action( 'wp_head', 'wp_generator' ) ;

/* *******************************
Remove WLManifest Link
******************************* */
remove_action( 'wp_head', 'wlwmanifest_link' ) ;

/* *******************************
Disable JQuery Migrate
******************************* */
add_action('wp_enqueue_scripts', 'deregister_qjuery'); 
function deregister_qjuery() {  
    if ( !is_admin() ) {
        wp_deregister_script('jquery');
    }
}  

/* *******************************
Disable Self Pingback
******************************* */
add_action( 'pre_ping', 'disable_pingback' );
function disable_pingback( &$links ) {
  foreach ( $links as $l => $link )
        if ( 0 === strpos( $link, get_option( 'home' ) ) )
        unset($links[$l]);
}

/* *******************************
Disable Heartbeat
******************************* */
add_action( 'init', 'stop_heartbeat', 1 );
function stop_heartbeat() {
  wp_deregister_script('heartbeat');
}

/* *******************************
Disable Dashicons in Front-end
******************************* */
add_action( 'wp_enqueue_scripts', 'wpdocs_dequeue_dashicon' );
function wpdocs_dequeue_dashicon() {
	if (current_user_can( 'update_core' )) {
	    return;
	}
	wp_deregister_style('dashicons');
}

/* *******************************
Disable Contact Form 7 CSS/JS on Every Page
******************************* */
add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );
