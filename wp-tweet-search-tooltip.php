<?php
/**
 * Plugin Name: WP Tweet Search Tooltip
 * Plugin URI: http://blog.ppfeufer.de/wordpress-wp-tweet-search-tooltip-plugin/
 * Description: Adds a tooltip on an chosen keyword for a search via twitter. Simply choose the keyword by surrounding with the shorttag. <code>&#91;tweetsearch&#93;Keyword&#91;/tweetsearch&#93;</code>. Wordpress 3.0 as minimum is requiered.
 * Version: 1.1.2
 * Author: H.-Peter Pfeufer
 * Author URI: http://ppfeufer.de
 * License: Free
 */

/**
 * Changelog:
 * = 1.1.0 =
 * Wordpress 3.0 is now required as minimum.
 * jQuery and jQuery-UI now privided by Wordpress.
 * Compatibility to "Use Google Libraries" plugin.
 *
 * = 1.0.0 =
 * Initial Release
 */

define('TWEETSEARCH_VERSION', '1.1.2');

/**
 * Plugin erst starten, wenn keine Adminseite angezeigt wird und Wordpress Verion 3.0 oder höher.
 * Wordpress 3.0 oder höher wird vorausgesetzt um jQuery und jQueryUI ordentlich laden zu können.
 */
if(!is_admin() && get_bloginfo('version') >= '3.0') {
	$var_sTweetSearchCSS_url = plugins_url(basename(dirname(__FILE__)) . '/css/');

	/**
	 * jQuery einbinden
	 * Diese werden ab Wordpress-Version 3.0 von Wordpress selbst zur Verfügung gestellt.
	 * Sollte das Plugin "Use Google Libraries" installiert sein, werden die aktuellen Versionen von Google CDN verwendet.
	 */
	wp_enqueue_script('jquery');

	/**
	 * Benötigtes CSS in Wordpress einbinden.
	 */
	wp_register_style('twitter-search-for-wordpress-jquery-ui-core-css', $var_sTweetSearchCSS_url . 'jquery.ui.core.css', array(), TWEETSEARCH_VERSION, 'screen');
	wp_register_style('twitter-search-for-wordpress-jquery-ui-resizable-css', $var_sTweetSearchCSS_url . 'jquery.ui.resizable.css', array(), TWEETSEARCH_VERSION, 'screen');
	wp_register_style('twitter-search-for-wordpress-jquery-ui-theme-css', $var_sTweetSearchCSS_url . 'jquery.ui.theme.css', array(), TWEETSEARCH_VERSION, 'screen');
	wp_register_style('twitter-search-for-wordpress-style-css', $var_sTweetSearchCSS_url . 'style.css', array(), TWEETSEARCH_VERSION, 'screen');

	wp_enqueue_style('twitter-search-for-wordpress-jquery-ui-core-css');
	wp_enqueue_style('twitter-search-for-wordpress-jquery-ui-resizable-css');
	wp_enqueue_style('twitter-search-for-wordpress-jquery-ui-theme-css');
	wp_enqueue_style('twitter-search-for-wordpress-style-css');
}

/**
 * Shortcode abfangen und umwandeln.
 *
 * @param array $atts
 * @param string $content
 */
function tweetsearch($atts, $content = null) {
	return '<span class="twitter_search">' . $content . '</span>';
}
add_shortcode('tweetsearch', 'tweetsearch');

function tweetsearch_footer() {
	$var_sTweetSearchJS_url = plugins_url(basename(dirname(__FILE__)) . '/js/');

	echo '<script type="text/javascript" src="' . $var_sTweetSearchJS_url . 'jquery.twitterpopup.js"></script>' . "\n";
	echo '<script type="text/javascript" src="' . $var_sTweetSearchJS_url . 'jquery.twitter.search.js"></script>' . "\n";
	echo '<script type="text/javascript">
			jQuery(function() {
				jQuery(\'#content\').find(\'.twitter_search\').twitterpopup();
			});
		</script>';
}
add_action('wp_footer', 'tweetsearch_footer');

function my_scripts_method() {
	wp_deregister_script('jquery-ui-core');
	wp_register_script('jquery-ui-core', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js');
	wp_enqueue_script('jquery-ui-core');
}

add_action('wp_enqueue_scripts', 'my_scripts_method');
?>